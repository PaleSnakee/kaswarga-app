<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InternalTransactionDataController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $transactions = Transaction::query()
            ->select(['amount', 'transaction_type', 'category', 'transaction_date'])
            ->orderBy('id')
            ->get()
            ->map(fn (Transaction $transaction) => [
                'amount' => (float) $transaction->amount,
                'transaction_type' => $transaction->transaction_type,
                'category' => $transaction->category,
                'transaction_date' => $transaction->transaction_date->toDateString(),
            ]);

        return response()->json([
            'data' => $transactions,
            'count' => $transactions->count(),
        ]);
    }
    }