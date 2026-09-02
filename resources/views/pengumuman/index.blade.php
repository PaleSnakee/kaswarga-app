@extends('layouts.app')

@section('title', 'Data Pengumuman')

@section('header')
    <form action="{{ route('pengumuman.index') }}" method="GET" class="relative w-full max-w-xl">
        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#666666]" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="6" />
            <path stroke-linecap="round" d="m20 20-4-4" />
        </svg>
        <input type="search" name="search" value="{{ $search }}" placeholder="Cari judul atau isi pengumuman..."
            class="form-control pl-9">
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

    <div class="grid gap-6 xl:grid-cols-[380px_1fr]">
        <div class="rounded-3xl bg-white p-6 shadow-soft">
            <div class="mb-6">
                <p class="text-sm font-medium text-brand-600">
                    {{ $pengumumanEdit ? 'Mode Edit' : 'Input Baru' }}</p>
                <h3 class="mt-1 text-xl font-bold text-slate-900">
                    {{ $pengumumanEdit ? 'Ubah Pengumuman' : 'Tambah Pengumuman' }}
                </h3>
                <p class="mt-2 text-sm text-slate-500">
                    {{ $pengumumanEdit ? 'Perbarui pengumuman yang dipilih.' : 'Masukkan judul dan isi pengumuman untuk dashboard.' }}
                </p>
            </div>

            <form action="{{ $pengumumanEdit ? route('pengumuman.update', $pengumumanEdit) : route('pengumuman.store') }}"
                method="POST" class="space-y-5">
                @csrf
                @if ($pengumumanEdit)
                    @method('PUT')
                @endif

                <div>
                    <label for="judul" class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
                    <input id="judul" type="text" name="judul"
                        value="{{ old('judul', $pengumumanEdit->judul ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100"
                        placeholder="Masukkan judul pengumuman">
                </div>

                <div>
                    <label for="isi" class="mb-2 block text-sm font-semibold text-slate-700">Isi
                        Pengumuman</label>
                    <textarea id="isi" name="isi" rows="6"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100"
                        placeholder="Masukkan isi pengumuman">{{ old('isi', $pengumumanEdit->isi ?? '') }}</textarea>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                        class="rounded-2xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">
                        {{ $pengumumanEdit ? 'Update Pengumuman' : 'Simpan Pengumuman' }}
                    </button>

                    @if ($pengumumanEdit)
                        <a href="{{ route('pengumuman.index') }}"
                            class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">
                            Batal
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-soft">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Daftar Pengumuman</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Menampilkan {{ $pengumumans->count() }}
                        pengumuman{{ $search ? ' untuk pencarian "' . $search . '"' : '' }}.
                    </p>
                </div>
                <a href="{{ route('pengumuman.index') }}"
                    class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">
                    Refresh
                </a>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="text-left text-sm font-semibold text-slate-500">
                            <th class="pb-4 pr-4">No</th>
                            <th class="pb-4 pr-4">Judul</th>
                            <th class="pb-4 pr-4">Isi</th>
                            <th class="pb-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengumumans as $index => $pengumuman)
                            <tr class="align-top">
                                <td class="py-4 pr-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-4 pr-4">
                                    <p class="font-semibold text-slate-900">{{ $pengumuman->judul }}</p>
                                </td>
                                <td class="py-4 pr-4 text-sm text-slate-600">{{ $pengumuman->isi }}</td>
                                <td class="py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('pengumuman.index', ['edit' => $pengumuman->id, 'search' => $search]) }}"
                                            class="rounded-xl bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('pengumuman.destroy', $pengumuman) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-xl bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-sm text-slate-500">
                                    Pengumuman belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
