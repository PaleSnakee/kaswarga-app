@extends('layouts.app')

@section('title', 'Tinjau Anomali')

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mx-auto max-w-3xl rounded-3xl bg-white p-6 shadow-soft">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <a href="{{ route('anomalies.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">← Kembali ke daftar anomali</a>
                <p class="mt-5 text-sm font-medium text-rose-600">Pemeriksaan ML</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900">Detail Transaksi Anomali</h2>
            </div>
            <span class="inline-flex w-fit rounded-full bg-rose-100 px-3 py-1.5 text-sm font-semibold text-rose-700">
                Skor: {{ number_format((float) $transaction->anomaly_score, 6) }}
            </span>
        </div>

        <dl class="mt-8 grid gap-5 border-y border-slate-100 py-6 sm:grid-cols-2">
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal</dt><dd class="mt-1 text-sm font-medium text-slate-900">{{ $transaction->transaction_date->format('d F Y') }}</dd></div>
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Warga</dt><dd class="mt-1 text-sm font-medium text-slate-900">{{ $transaction->headFamily?->nama ?? '-' }}</dd></div>
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Jenis</dt><dd class="mt-1 text-sm font-medium text-slate-900">{{ ucfirst($transaction->transaction_type) }}</dd></div>
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nominal</dt><dd class="mt-1 text-sm font-bold {{ $transaction->transaction_type === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</dd></div>
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kategori</dt><dd class="mt-1 text-sm font-medium text-slate-900">{{ $transaction->category }}</dd></div>
            <div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status Saat Ini</dt><dd class="mt-1 text-sm font-medium text-slate-900">{{ ['review' => 'Perlu Ditinjau', 'verified' => 'Terverifikasi', 'normal' => 'Normal'][$transaction->audit_status] }}</dd></div>
            <div class="sm:col-span-2"><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Keterangan</dt><dd class="mt-1 text-sm text-slate-700">{{ $transaction->description ?: '-' }}</dd></div>
        </dl>

        <form action="{{ route('anomalies.updateAuditStatus', $transaction) }}" method="POST" class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-end">
            @csrf
            @method('PUT')
            <div class="flex-1">
                <label for="audit_status" class="mb-2 block text-sm font-semibold text-slate-700">Keputusan Audit</label>
                <select id="audit_status" name="audit_status" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm">
                    <option value="normal" @selected($transaction->audit_status === 'normal')>Tandai Normal</option>
                    <option value="verified" @selected($transaction->audit_status === 'verified')>Verifikasi sebagai Anomali</option>
                </select>
            </div>
            <button type="submit" class="rounded-2xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-700">Simpan Keputusan</button>
        </form>
    </div>
@endsection