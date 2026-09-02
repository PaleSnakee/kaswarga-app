@extends('layouts.app')

@section('title', 'Data Kepala Keluarga')

@section('header')
    <form action="{{ route('kepala-keluarga.index') }}" method="GET" class="relative w-full max-w-xl">
        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#666666]" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="6" />
            <path stroke-linecap="round" d="m20 20-4-4" />
        </svg>
        <input type="search" name="search" value="{{ $search }}"
            placeholder="Cari nama kepala keluarga, alamat, atau no. telepon..." class="form-control pl-9">
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
                    {{ $kepalaKeluargaEdit ? 'Mode Edit' : 'Input Baru' }}</p>
                <h3 class="mt-1 text-xl font-bold text-slate-900">
                    {{ $kepalaKeluargaEdit ? 'Ubah Data Kepala Keluarga' : 'Tambah Data Kepala Keluarga' }}
                </h3>
                <p class="mt-2 text-sm text-slate-500">
                    {{ $kepalaKeluargaEdit ? 'Perbarui data kepala keluarga yang dipilih.' : 'Masukkan nama, alamat, dan nomor telepon kepala keluarga.' }}
                </p>
            </div>

            <form
                action="{{ $kepalaKeluargaEdit ? route('kepala-keluarga.update', $kepalaKeluargaEdit) : route('kepala-keluarga.store') }}"
                method="POST" class="space-y-5">
                @csrf
                @if ($kepalaKeluargaEdit)
                    @method('PUT')
                @endif

                <div>
                    <label for="nama" class="mb-2 block text-sm font-semibold text-slate-700">Nama
                        Kepala Keluarga</label>
                    <input id="nama" type="text" name="nama"
                        value="{{ old('nama', $kepalaKeluargaEdit->nama ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100"
                        placeholder="Masukkan nama kepala keluarga">
                </div>

                <div>
                    <label for="alamat" class="mb-2 block text-sm font-semibold text-slate-700">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="4"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100"
                        placeholder="Masukkan alamat lengkap kepala keluarga">{{ old('alamat', $kepalaKeluargaEdit->alamat ?? '') }}</textarea>
                </div>

                <div>
                    <label for="no_telepon" class="mb-2 block text-sm font-semibold text-slate-700">No
                        Telepon</label>
                    <input id="no_telepon" type="text" name="no_telepon"
                        value="{{ old('no_telepon', $kepalaKeluargaEdit->no_telepon ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100"
                        placeholder="Contoh: 081234567890">
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                        class="rounded-2xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">
                        {{ $kepalaKeluargaEdit ? 'Update Kepala Keluarga' : 'Simpan Kepala Keluarga' }}
                    </button>

                    @if ($kepalaKeluargaEdit)
                        <a href="{{ route('kepala-keluarga.index') }}"
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
                    <h3 class="text-xl font-bold text-slate-900">Daftar Kepala Keluarga</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Menampilkan {{ $kepalaKeluargas->count() }} data kepala
                        keluarga{{ $search ? ' untuk pencarian "' . $search . '"' : '' }}.
                    </p>
                </div>
                <a href="{{ route('kepala-keluarga.index') }}"
                    class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">
                    Refresh
                </a>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="text-left text-sm font-semibold text-slate-500">
                            <th class="pb-4 pr-4">No</th>
                            <th class="pb-4 pr-4">Nama</th>
                            <th class="pb-4 pr-4">Alamat</th>
                            <th class="pb-4 pr-4">No Telepon</th>
                            <th class="pb-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($kepalaKeluargas as $index => $kepalaKeluarga)
                            <tr class="align-top">
                                <td class="py-4 pr-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                                <td class="py-4 pr-4">
                                    <p class="font-semibold text-slate-900">{{ $kepalaKeluarga->nama }}</p>
                                </td>
                                <td class="py-4 pr-4 text-sm text-slate-600">{{ $kepalaKeluarga->alamat }}
                                </td>
                                <td class="py-4 pr-4 text-sm text-slate-600">
                                    {{ $kepalaKeluarga->no_telepon }}</td>
                                <td class="py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('kepala-keluarga.index', ['edit' => $kepalaKeluarga->id, 'search' => $search]) }}"
                                            class="rounded-xl bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('kepala-keluarga.destroy', $kepalaKeluarga) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data kepala keluarga ini?')">
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
                                <td colspan="5" class="py-10 text-center text-sm text-slate-500">
                                    Data kepala keluarga belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
