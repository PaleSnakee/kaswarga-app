<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnomalyController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $type = $request->query('type', 'all');
        $category = $request->query('category', 'all');
        $auditStatus = $request->query('audit_status', 'all');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $transactions = Transaction::with('headFamily')
            ->where('is_anomaly', true)
            ->when($search, function ($query, $searchTerm) {
                $query->where(function ($searchQuery) use ($searchTerm) {
                    $searchQuery->whereHas('headFamily', function ($wargaQuery) use ($searchTerm) {
                        $wargaQuery->where('nama', 'like', '%'.$searchTerm.'%');
                    })
                        ->orWhere('category', 'like', '%'.$searchTerm.'%')
                        ->orWhere('description', 'like', '%'.$searchTerm.'%');
                });
            })
            ->when($type !== 'all', fn ($query) => $query->where('transaction_type', $type))
            ->when($category !== 'all', fn ($query) => $query->where('category', $category))
            ->when($auditStatus !== 'all', fn ($query) => $query->where('audit_status', $auditStatus))
            ->when($dateFrom, fn ($query) => $query->whereDate('transaction_date', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->whereDate('transaction_date', '<=', $dateTo))
            ->latest('transaction_date')
            ->paginate(10);

        $categories = Transaction::where('is_anomaly', true)
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('anomalies.index', compact(
            'transactions', 'search', 'type', 'category', 'auditStatus', 'dateFrom', 'dateTo', 'categories'
        ));
    }

    public function show(Transaction $transaction): View
    {
        abort_unless($transaction->is_anomaly, 404);

        return view('anomalies.show', compact('transaction'));
    }

    public function updateAuditStatus(Request $request, Transaction $transaction): RedirectResponse
    {
        abort_unless($transaction->is_anomaly, 404);

        $validated = $request->validate([
            'audit_status' => ['required', 'in:normal,verified'],
        ]);

        $transaction->update($validated);

        return redirect()
            ->route('anomalies.show', $transaction)
            ->with('success', 'Status audit transaksi berhasil diperbarui.');
    }
}
