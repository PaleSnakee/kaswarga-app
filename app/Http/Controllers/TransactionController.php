<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman kelola kas
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);
        $type = $request->query('type');
        $category = $request->query('category');

        // Query transaksi dengan filter
        $transactions = Transaction::with('headFamily')
            ->when($search, function ($query, $searchTerm) {
                $query->whereHas('headFamily', function ($q) use ($searchTerm) {
                    $q->where('nama', 'like', '%' . $searchTerm . '%');
                })
                ->orWhere('category', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'like', '%' . $searchTerm . '%');
            })
            ->when($month && $month !== 'all', function ($query) use ($month) {
                $query->whereMonth('transaction_date', $month);
            })
            ->when($year && $year !== 'all', function ($query) use ($year) {
                $query->whereYear('transaction_date', $year);
            })
            ->when($type && $type !== 'all', function ($query) use ($type) {
                $query->where('transaction_type', $type);
            })
            ->when($category && $category !== 'all', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->latest('transaction_date')
            ->paginate(10);

        // Data untuk dropdown
        $headFamilies = Warga::orderBy('nama')->get();
        
        // Statistik kas
        $totalPemasukan = Transaction::where('transaction_type', 'pemasukan')
            ->when($month && $month !== 'all', function ($query) use ($month) {
                $query->whereMonth('transaction_date', $month);
            })
            ->when($year && $year !== 'all', function ($query) use ($year) {
                $query->whereYear('transaction_date', $year);
            })
            ->sum('amount');

        $totalPengeluaran = Transaction::where('transaction_type', 'pengeluaran')
            ->when($month && $month !== 'all', function ($query) use ($month) {
                $query->whereMonth('transaction_date', $month);
            })
            ->when($year && $year !== 'all', function ($query) use ($year) {
                $query->whereYear('transaction_date', $year);
            })
            ->sum('amount');

        $saldoKas = $totalPemasukan - $totalPengeluaran;
        $jumlahTransaksi = Transaction::count();

        // Transaction untuk edit mode
        $transactionEdit = null;
        if ($request->filled('edit')) {
            $transactionEdit = Transaction::find($request->query('edit'));
        }

        // Data untuk filter
        $months = [
            '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
            '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
            '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $categoriesPemasukan = ['Iuran Bulanan', 'Donasi', 'Denda', 'Lainnya'];
        $categoriesPengeluaran = ['Operasional', 'Kebersihan', 'Keamanan', 'Perbaikan', 'Konsumsi', 'Lainnya'];
        $years = range(date('Y') - 5, date('Y') + 1);

        return view('transactions.index', [
            'transactions' => $transactions,
            'transactionEdit' => $transactionEdit,
            'headFamilies' => $headFamilies,
            'search' => $search,
            'month' => $month,
            'year' => $year,
            'type' => $type,
            'category' => $category,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoKas' => $saldoKas,
            'jumlahTransaksi' => $jumlahTransaksi,
            'months' => $months,
            'categoriesPemasukan' => $categoriesPemasukan,
            'categoriesPengeluaran' => $categoriesPengeluaran,
            'years' => $years,
        ]);
    }

    /**
     * Menyimpan transaksi baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'head_family_id' => ['required', 'exists:wargas,id'],
            'transaction_type' => ['required', 'in:pemasukan,pengeluaran'],
            'amount' => ['required', 'numeric', 'min:1'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'transaction_date' => ['required', 'date'],
        ]);

        Transaction::create($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi kas berhasil ditambahkan.');
    }

    /**
     * Memperbarui transaksi
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'head_family_id' => ['required', 'exists:wargas,id'],
            'transaction_type' => ['required', 'in:pemasukan,pengeluaran'],
            'amount' => ['required', 'numeric', 'min:1'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'transaction_date' => ['required', 'date'],
        ]);

        $transaction->update($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi kas berhasil diperbarui.');
    }

    /**
     * Menghapus transaksi
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi kas berhasil dihapus.');
    }
}