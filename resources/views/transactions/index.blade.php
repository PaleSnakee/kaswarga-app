@extends('layouts.app')

@section('title', 'Kelola Kas')

@section('header')
    <form action="{{ route('transactions.index') }}" method="GET" class="relative w-full max-w-xl">
        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#666666]" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="6" />
            <path stroke-linecap="round" d="m20 20-4-4" />
        </svg>
        <input type="search" name="search" value="{{ $search }}"
            placeholder="Cari transaksi berdasarkan warga, kategori, atau keterangan..." class="form-control pl-9">
    </form>
@endsection

@section('content')
    @if (session('success'))
        <div
            class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
            <p class="font-semibold">Data belum bisa disimpan.</p>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Statistik Kas -->
    <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Pemasukan -->
        <div class="rounded-3xl bg-white p-6 shadow-soft">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Pemasukan</p>
                    <h3 class="mt-3 text-3xl font-bold text-emerald-600">
                        {{ 'Rp' . number_format($totalPemasukan, 0, ',', '.') }}</h3>
                </div>
                <div class="rounded-xl bg-emerald-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="rounded-3xl bg-white p-6 shadow-soft">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Pengeluaran</p>
                    <h3 class="mt-3 text-3xl font-bold text-rose-600">
                        {{ 'Rp' . number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                </div>
                <div class="rounded-xl bg-rose-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Saldo Kas -->
        <div class="rounded-3xl bg-white p-6 shadow-soft">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Saldo Kas</p>
                    <h3 class="mt-3 text-3xl font-bold text-brand-600">
                        {{ 'Rp' . number_format($saldoKas, 0, ',', '.') }}</h3>
                </div>
                <div class="rounded-xl bg-brand-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Jumlah Transaksi -->
        <div class="rounded-3xl bg-white p-6 shadow-soft">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Jumlah Transaksi</p>
                    <h3 class="mt-3 text-3xl font-bold text-purple-600">
                        {{ number_format($jumlahTransaksi, 0, ',', '.') }}</h3>
                </div>
                <div class="rounded-xl bg-purple-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[340px_1fr]">
        <!-- Card Input Kas -->
        <div class="rounded-3xl bg-white p-6 shadow-soft">
            <div class="mb-6">
                <p class="text-sm font-medium text-brand-600">
                    {{ $transactionEdit ? 'Mode Edit' : 'Input Baru' }}</p>
                <h3 class="mt-1 text-xl font-bold text-slate-900">
                    {{ $transactionEdit ? 'Ubah Transaksi Kas' : 'Tambah Transaksi Kas' }}
                </h3>
                <p class="mt-2 text-sm text-slate-500">
                    {{ $transactionEdit ? 'Perbarui data transaksi kas yang dipilih.' : 'Masukkan data transaksi kas warga.' }}
                </p>
            </div>

            <form
                action="{{ $transactionEdit ? route('transactions.update', $transactionEdit) : route('transactions.store') }}"
                method="POST" class="space-y-5" id="transactionForm">
                @csrf
                @if ($transactionEdit)
                    @method('PUT')
                @endif

                <!-- Jenis Transaksi -->
                <div>
                    <label for="transaction_type" class="mb-2 block text-sm font-semibold text-slate-700">Jenis
                        Transaksi</label>
                    <select id="transaction_type" name="transaction_type" onchange="updateCategories()"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100">
                        <option value="" disabled selected>Pilih Jenis Transaksi</option>
                        <option value="pemasukan"
                            {{ old('transaction_type', $transactionEdit->transaction_type ?? '') == 'pemasukan' ? 'selected' : '' }}>
                            Pemasukan</option>
                        <option value="pengeluaran"
                            {{ old('transaction_type', $transactionEdit->transaction_type ?? '') == 'pengeluaran' ? 'selected' : '' }}>
                            Pengeluaran</option>
                    </select>
                </div>

                <!-- Nominal -->
                <div>
                    <label for="amount" class="mb-2 block text-sm font-semibold text-slate-700">Nominal</label>
                    <input id="amount" type="number" name="amount" min="1"
                        value="{{ old('amount', $transactionEdit->amount ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100"
                        placeholder="Masukkan nominal">
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category" class="mb-2 block text-sm font-semibold text-slate-700">Kategori</label>
                    <select id="category" name="category"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @php
                            $categories =
                                ($transactionEdit && $transactionEdit->transaction_type == 'pemasukan') ||
                                old('transaction_type') == 'pemasukan'
                                    ? $categoriesPemasukan
                                    : ($transactionEdit && $transactionEdit->transaction_type == 'pengeluaran'
                                        ? $categoriesPengeluaran
                                        : []);
                            $selectedCategory = old('category', $transactionEdit->category ?? '');
                        @endphp
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $selectedCategory == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="transaction_date" class="mb-2 block text-sm font-semibold text-slate-700">Tanggal</label>
                    <input id="transaction_date" type="date" name="transaction_date"
                        value="{{ old('transaction_date', isset($transactionEdit) ? $transactionEdit->transaction_date->format('Y-m-d') : date('Y-m-d')) }}"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100">
                </div>

                <!-- Nama Warga -->
                <div>
                    <label for="head_family_id" class="mb-2 block text-sm font-semibold text-slate-700">Nama Warga</label>
                    <select id="head_family_id" name="head_family_id"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100">
                        <option value="" disabled selected>Pilih Warga</option>
                        @foreach ($headFamilies as $warga)
                            <option value="{{ $warga->id }}"
                                {{ old('head_family_id', $transactionEdit->head_family_id ?? '') == $warga->id ? 'selected' : '' }}>
                                {{ $warga->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Keterangan</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100"
                        placeholder="Masukkan keterangan transaksi">{{ old('description', $transactionEdit->description ?? '') }}</textarea>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                        class="rounded-2xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">
                        {{ $transactionEdit ? 'Update Transaksi' : 'Simpan Transaksi' }}
                    </button>

                    @if ($transactionEdit)
                        <a href="{{ route('transactions.index') }}"
                            class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">
                            Batal
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Card Daftar Kas -->
        <div class="rounded-3xl bg-white p-6 shadow-soft">
            <!-- Filter Section -->
            <div class="mb-6">
                <form action="{{ route('transactions.index') }}" method="GET" class="space-y-4">
                    <div class="grid gap-3 sm:grid-cols-2">
                        <!-- Bulan -->
                        <div>
                            <label for="month" class="mb-2 block text-xs font-medium text-slate-700">Bulan</label>
                            <select id="month" name="month"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100">
                                <option value="all" {{ $month == 'all' ? 'selected' : '' }}>Semua Bulan
                                </option>
                                @foreach ($months as $key => $monthName)
                                    <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label for="year" class="mb-2 block text-xs font-medium text-slate-700">Tahun</label>
                            <select id="year" name="year"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100">
                                <option value="all" {{ $year == 'all' ? 'selected' : '' }}>Semua Tahun
                                </option>
                                @foreach ($years as $yr)
                                    <option value="{{ $yr }}" {{ $year == $yr ? 'selected' : '' }}>
                                        {{ $yr }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Transaksi Filter -->
                        <div>
                            <label for="type" class="mb-2 block text-xs font-medium text-slate-700">Jenis</label>
                            <select id="type" name="type"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100">
                                <option value="all" {{ $type == 'all' ? 'selected' : '' }}>Semua Jenis
                                </option>
                                <option value="pemasukan" {{ $type == 'pemasukan' ? 'selected' : '' }}>
                                    Pemasukan</option>
                                <option value="pengeluaran" {{ $type == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran
                                </option>
                            </select>
                        </div>

                        <!-- Kategori Filter -->
                        <div>
                            <label for="category_filter"
                                class="mb-2 block text-xs font-medium text-slate-700">Kategori</label>
                            <select id="category_filter" name="category"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100">
                                <option value="all" {{ $category == 'all' ? 'selected' : '' }}>Semua
                                    Kategori</option>
                                @foreach (array_merge($categoriesPemasukan, $categoriesPengeluaran) as $cat)
                                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit"
                            class="rounded-2xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('transactions.index') }}"
                            class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">
                            Reset Filter
                        </a>
                    </div>
                </form>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Daftar Transaksi Kas</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Menampilkan {{ $transactions->count() }}
                        transaksi{{ $search ? ' untuk pencarian "' . $search . '"' : '' }}.
                    </p>
                </div>
                <a href="{{ route('transactions.index') }}"
                    class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">
                    Refresh
                </a>
            </div>

            <div class="mt-6">
                <table class="w-full table-fixed divide-y divide-slate-200">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="w-10 pb-3 pr-2">No</th>
                            <th class="w-20 pb-3 pr-2">Tanggal</th>
                            <th class="w-28 pb-3 pr-2">Nama</th>
                            <th class="w-28 pb-3 pr-2">Kategori</th>
                            <th class="w-24 pb-3 pr-2">Nominal</th>
                            <th class="w-28 pb-3 pr-2">Status</th>
                            <th class="w-28 pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transactions as $index => $transaction)
                            <tr class="align-middle">
                                <td class="py-3 pr-2 text-xs text-slate-500">
                                    {{ $transactions->firstItem() + $index }}</td>
                                <td class="py-3 pr-2 text-xs text-slate-600 whitespace-nowrap">
                                    {{ $transaction->transaction_date->format('d/m/Y') }}
                                </td>
                                <td class="py-3 pr-2">
                                    <p class="truncate text-sm font-semibold text-slate-900">
                                        {{ $transaction->headFamily->nama }}</p>
                                </td>
                                <td class="py-3 pr-2 text-xs text-slate-600">
                                    {{ $transaction->category }}
                                </td>
                                <td
                                    class="py-3 pr-2 text-xs font-semibold whitespace-nowrap {{ $transaction->transaction_type == 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ 'Rp' . number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3 pr-2">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $transaction->transaction_type == 'pemasukan' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $transaction->transaction_type == 'pemasukan' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <div class="flex justify-end gap-1.5">
                                        <a href="{{ route('transactions.index', ['edit' => $transaction->id, 'search' => $search, 'month' => $month, 'year' => $year, 'type' => $type, 'category' => $category]) }}"
                                            class="rounded-lg bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 transition hover:bg-amber-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-lg bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-sm text-slate-500">
                                    Data transaksi belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateCategories() {
            const type = document.getElementById('transaction_type');
            const categorySelect = document.getElementById('category');

            if (!type || !categorySelect) return;

            const selectedValue = categorySelect.value;
            categorySelect.innerHTML = '';

            const placeholderOption = document.createElement('option');
            placeholderOption.value = '';
            placeholderOption.textContent = 'Pilih Kategori';
            placeholderOption.disabled = true;
            placeholderOption.selected = true;
            categorySelect.appendChild(placeholderOption);

            const categories = type.value === 'pemasukan' ? ['Iuran Bulanan', 'Donasi', 'Denda', 'Lainnya'] :
                type.value === 'pengeluaran' ? ['Operasional', 'Kebersihan', 'Keamanan', 'Perbaikan', 'Konsumsi',
                    'Lainnya'
                ] : [];

            categories.forEach((category) => {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = category;
                categorySelect.appendChild(option);
            });

            if (selectedValue && categories.includes(selectedValue)) {
                categorySelect.value = selectedValue;
            }
        }

        document.addEventListener('DOMContentLoaded', updateCategories);
    </script>
@endpush
