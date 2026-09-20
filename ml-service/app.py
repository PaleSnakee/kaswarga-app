from __future__ import annotations

import os
from datetime import date
from pathlib import Path
from typing import Literal

import httpx
import joblib
import pandas as pd
from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, Field
from sklearn.compose import ColumnTransformer
from sklearn.ensemble import IsolationForest
from sklearn.pipeline import Pipeline
from sklearn.preprocessing import OneHotEncoder

MODEL_PATH = Path(os.getenv("ML_MODEL_PATH", "model.joblib"))
LARAVEL_TRAIN_DATA_URL = os.getenv(
    "LARAVEL_TRAIN_DATA_URL", "http://127.0.0.1:8000/api/ml/train-data"
)
INTERNAL_TOKEN = os.getenv("ML_SERVICE_INTERNAL_TOKEN", "")
CONTAMINATION = float(os.getenv("ML_CONTAMINATION", "0.05"))

app = FastAPI(title="KASWARGA ML Service", version="1.0.0")
model: Pipeline | None = None
trained_samples = 0


class TransactionPayload(BaseModel):
    amount: float = Field(gt=0)
    transaction_type: Literal["pemasukan", "pengeluaran"]
    category: str = Field(min_length=1, max_length=255)
    transaction_date: date


class PredictionResponse(BaseModel):
    score: float
    is_anomaly: bool
    status: Literal["normal", "review"]


class TrainResponse(BaseModel):
    trained_samples: int
    contamination: float


def to_features(records: list[dict]) -> pd.DataFrame:
    frame = pd.DataFrame(records)

    if frame.empty:
        return frame

    parsed_date = pd.to_datetime(frame["transaction_date"], errors="coerce")
    if parsed_date.isna().any():
        raise ValueError("transaction_date tidak valid.")

    frame["day_of_week"] = parsed_date.dt.dayofweek
    frame["month"] = parsed_date.dt.month

    return frame[["amount", "transaction_type", "category", "day_of_week", "month"]]


def build_model() -> Pipeline:
    preprocessor = ColumnTransformer(
        transformers=[
            ("numeric", "passthrough", ["amount", "day_of_week", "month"]),
            (
                "categorical",
                OneHotEncoder(handle_unknown="ignore"),
                ["transaction_type", "category"],
            ),
        ]
    )

    return Pipeline(
        steps=[
            ("preprocessor", preprocessor),
            (
                "detector",
                IsolationForest(
                    contamination=CONTAMINATION,
                    random_state=42,
                    n_estimators=200,
                ),
            ),
        ]
    )


def load_saved_model() -> None:
    global model, trained_samples

    if MODEL_PATH.exists():
        artifact = joblib.load(MODEL_PATH)
        model = artifact["model"]
        trained_samples = int(artifact.get("trained_samples", 0))


@app.on_event("startup")
def startup() -> None:
    load_saved_model()


@app.get("/health")
def health() -> dict:
    return {
        "status": "ok",
        "model_ready": model is not None,
        "trained_samples": trained_samples,
    }


@app.post("/train", response_model=TrainResponse)
async def train() -> TrainResponse:
    global model, trained_samples

    if not INTERNAL_TOKEN:
        raise HTTPException(
            status_code=500,
            detail="ML_SERVICE_INTERNAL_TOKEN belum dikonfigurasi.",
        )

    try:
        async with httpx.AsyncClient(timeout=15.0) as client:
            response = await client.get(
                LARAVEL_TRAIN_DATA_URL,
                headers={"X-ML-Internal-Token": INTERNAL_TOKEN},
            )
            response.raise_for_status()
    except httpx.HTTPError as exception:
        raise HTTPException(
            status_code=502,
            detail=f"Gagal mengambil data training Laravel: {exception}",
        ) from exception

    payload = response.json()
    records = payload.get("data") if isinstance(payload, dict) else None

    if not isinstance(records, list) or len(records) < 2:
        raise HTTPException(
            status_code=422,
            detail="Minimal dua transaksi diperlukan untuk training.",
        )

    try:
        features = to_features(records)
    except (KeyError, ValueError) as exception:
        raise HTTPException(status_code=422, detail=str(exception)) from exception

    model = build_model()
    model.fit(features)
    trained_samples = len(features)

    joblib.dump(
        {"model": model, "trained_samples": trained_samples},
        MODEL_PATH,
    )

    return TrainResponse(
        trained_samples=trained_samples,
        contamination=CONTAMINATION,
    )


@app.post("/predict", response_model=PredictionResponse)
def predict(transaction: TransactionPayload) -> PredictionResponse:
    if model is None:
        raise HTTPException(
            status_code=503,
            detail="Model belum ditraining. Jalankan POST /train terlebih dahulu.",
        )

    features = to_features([transaction.model_dump(mode="json")])
    prediction = int(model.predict(features)[0])
    decision_score = float(model.decision_function(features)[0])

    # Skor yang lebih tinggi menunjukkan transaksi semakin tidak lazim.
    anomaly_score = -decision_score
    is_anomaly = prediction == -1

    return PredictionResponse(
        score=round(anomaly_score, 6),
        is_anomaly=is_anomaly,
        status="review" if is_anomaly else "normal",
    )