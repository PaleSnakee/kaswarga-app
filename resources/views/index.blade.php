<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Kepala Keluarga Kaswarga</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    },
                    boxShadow: {
                        soft: '0 20px 45px -15px rgba(15, 23, 42, 0.12)',
                    }
                }
            }
        };
    </script>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">
    <div class="flex min-h-screen">
        <aside class="hidden w-72 flex-col bg-slate-900 px-6 py-8 text-slate-200 lg:flex">
            <div class="mb-10">
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-400">Kaswarga</p>
                <h1 class="mt-3 text-2xl font-bold text-white">Manajemen Kepala Keluarga</h1>
                <p class="mt-2 text-sm text-slate-400">Kelola data kepala keluarga secara cepat dari satu dashboard.</p>
            </div>

            <x-nav-bar />
        </aside>

        <main class="flex-1">
            <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
                <div
                    class="flex flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-10">
                    <div>
                        <p class="text-sm text-slate-500">Dashboard CRUD</p>
                        <h2 class="text-2xl font-bold text-slate-900">Data Kepala Keluarga</h2>
                    </div>

                    <form action="{{ route('kepala-keluarga.index') }}" method="GET" class="relative w-full max-w-xl">
                        <span
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}"
                            placeholder="Cari nama kepala keluarga, alamat, atau no telepon..."
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-100">
                    </form>

                    <button
                        class="flex items-center gap-3 rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-500 font-bold">A</span>
                        <span>Profile</span>
                    </button>
                </div>
            </header>

            <section class="px-4 py-6 sm:px-6 lg:px-10 lg:py-8">
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
                                <label for="alamat"
                                    class="mb-2 block text-sm font-semibold text-slate-700">Alamat</label>
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
                                                    <form
                                                        action="{{ route('kepala-keluarga.destroy', $kepalaKeluarga) }}"
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
            </section>
        </main>
    </div>
</body>

</html>
