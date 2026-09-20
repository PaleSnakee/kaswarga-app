<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class TransactionAnomalyService
{
    public function analyze(Transaction $transaction): bool
    {
        $baseUrl = rtrim((string) config('services.ml_service.url'), '/');

        if ($baseUrl === '') {
            Log::warning('ML prediction skipped: ML_SERVICE_URL is not configured.', [
                'transaction_id' => $transaction->id,
            ]);

            return false;
        }

        try {
            $response = Http::acceptJson()
                ->timeout((int) config('services.ml_service.timeout', 5))
                ->post($baseUrl.'/predict', [
                    'amount' => (float) $transaction->amount,
                    'transaction_type' => $transaction->transaction_type,
                    'category' => $transaction->category,
                    'transaction_date' => $transaction->transaction_date->toDateString(),
                ]);

            if (! $response->successful()) {
                Log::warning('ML prediction request failed.', [
                    'transaction_id' => $transaction->id,
                    'status_code' => $response->status(),
                    'response' => $response->json(),
                ]);

                return false;
            }

            $result = $response->json();

            if (
                ! is_array($result)
                || ! array_key_exists('score', $result)
                || ! array_key_exists('is_anomaly', $result)
                || ! in_array($result['status'] ?? null, ['normal', 'review'], true)
            ) {
                Log::warning('ML prediction response has an invalid format.', [
                    'transaction_id' => $transaction->id,
                    'response' => $result,
                ]);

                return false;
            }

            $transaction->update([
                'anomaly_score' => (float) $result['score'],
                'is_anomaly' => (bool) $result['is_anomaly'],
                'audit_status' => $result['status'],
            ]);

            return true;
        } catch (ConnectionException $exception) {
            Log::warning('ML service is unavailable. Transaction remains saved without ML analysis.', [
                'transaction_id' => $transaction->id,
                'message' => $exception->getMessage(),
            ]);
        } catch (Throwable $exception) {
            Log::error('Unexpected ML prediction error.', [
                'transaction_id' => $transaction->id,
                'message' => $exception->getMessage(),
            ]);
        }

        return false;
    }
}