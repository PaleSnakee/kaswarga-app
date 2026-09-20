@extends('layouts.app')

@section('title', 'Audit Anomali')

@section('header')
    <form action="{{ route('anomalies.index') }}" method="GET" class="relative w-full max-w-xl">
        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#666666]" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <circle cx="11" cy="11" r="6" />
            <path stroke-linecap="round" d="m20 20-4-4" />
        </svg>
        <input type="search" name="search" value="{{ $search }}"
            placeholder="Cari warga, kategori, atau keterangan..." class="form-control pl-9">
    </form>
@endsection

@section('content')
    <div class="rounded-3xl bg-white p-6 shadow-soft">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm font-medium text-rose-600">Pemeriksaan ML</p>
                <h2 class="mt-1 text-xl font-bold text-slate-900">Transaksi Terindikasi Anomali</h2>
                <p class="mt-2 text-sm text-slate-500">Tinjau dan verifikasi transaksi yang ditandai oleh layanan ML.</p>
            </div>
            <a href="{{ route('anomalies.index') }}"
                class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">
                Refresh
            </a>
        </div>

        <form action="{{ route('anomalies.index') }}" method="GET" class="mb-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
            <input type="hidden" name="search" value="{{ $search }}">
            <select name="type" class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm">
                <option value="all">Semua Jenis</option>
                <option value="pemasukan" @selected($type === 'pemasukan')>Pemasukan</option>
                <option value="pengeluaran" @selected($type === 'pengeluaran')>Pengeluaran</option>
            </select>
            <select name="category" class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm">
                <option value="all">Semua Kategori</option>
                @foreach ($categories as $item)
                    <option value="{{ $item }}" @selected($category === $item)>{{ $item }}</option>
                @endforeach
            </select>
            <select name="audit_status" class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm">
                <option value="all">Semua Status</option>
                <option value="review" @selected($auditStatus === 'review')>Perlu Ditinjau</option>
                <option value="verified" @selected($auditStatus === 'verified')>Terverifikasi</option>
                <option value="normal" @selected($auditStatus === 'normal')>Normal</option>
            </select>
            <input type="date" name="date_from" value="{{ $dateFrom }}" aria-label="Tanggal mulai"
                class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm">
            <div class="flex gap-2">
                <input type="date" name="date_to" value="{{ $dateTo }}" aria-label="Tanggal akhir"
                    class="min-w-0 flex-1 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm">
                <button type="submit" class="rounded-2xl bg-brand-600 px-4 py-3 text-sm font-semibold text-white hover:bg-brand-700">Filter</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] divide-y divide-slate-200">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="pb-3 pr-3">Tanggal</th>
                        <th class="pb-3 pr-3">Warga</th>
                        <th class="pb-3 pr-3">Transaksi</th>
                        <th class="pb-3 pr-3">Skor</th>
                        <th class="pb-3 pr-3">Audit</th>
                        <th class="pb-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td class="py-3 pr-3 text-sm text-slate-600">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                            <td class="py-3 pr-3 text-sm font-semibold text-slate-900">{{ $transaction->headFamily?->nama ?? '-' }}</td>
                            <td class="py-3 pr-3">
                                <p class="text-sm text-slate-900">{{ $transaction->category }}</p>
                                <p class="text-xs font-semibold {{ $transaction->transaction_type === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                </p>
                            </td>
                            <td class="py-3 pr-3 text-sm font-semibold text-rose-600">{{ number_format((float) $transaction->anomaly_score, 4) }}</td>
                            <td class="py-3 pr-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $transaction->audit_status === 'verified' ? 'bg-emerald-100 text-emerald-700' : ($transaction->audit_status === 'normal' ? 'bg-slate-100 text-slate-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ ['review' => 'Perlu Ditinjau', 'verified' => 'Terverifikasi', 'normal' => 'Normal'][$transaction->audit_status] }}
                                </span>
                            </td>
                            <td class="py-3 text-right">
                                <a href="{{ route('anomalies.show', $transaction) }}" class="rounded-lg bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-200">Tinjau</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-10 text-center text-sm text-slate-500">Tidak ada transaksi anomali untuk filter ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $transactions->withQueryString()->links() }}</div>
    </div>
@endsection