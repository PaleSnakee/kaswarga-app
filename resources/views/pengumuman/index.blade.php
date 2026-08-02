<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Pengumuman Kaswarga</title>

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
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-100">Kaswarga</p>
                <p class="mt-2 text-sm text-slate-400">Kelola informasi penting untuk kepala keluarga dan pengurus.</p>
            </div>

            <x-nav-bar />
        </aside>

        <main class="flex-1">
            <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
                <div
                    class="flex flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-10">
                    <div>
                        <p class="text-sm text-slate-500">Dashboard CRUD</p>
                        <h2 class="text-2xl font-bold text-slate-900">Data Pengumuman</h2>
                    </div>

                    <form action="{{ route('pengumuman.index') }}" method="GET" class="relative w-full max-w-xl">
                        <span
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}"
                            placeholder="Cari judul atau isi pengumuman..."
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
                                {{ $pengumumanEdit ? 'Mode Edit' : 'Input Baru' }}</p>
                            <h3 class="mt-1 text-xl font-bold text-slate-900">
                                {{ $pengumumanEdit ? 'Ubah Pengumuman' : 'Tambah Pengumuman' }}
                            </h3>
                            <p class="mt-2 text-sm text-slate-500">
                                {{ $pengumumanEdit ? 'Perbarui pengumuman yang dipilih.' : 'Masukkan judul dan isi pengumuman untuk dashboard.' }}
                            </p>
                        </div>

                        <form
                            action="{{ $pengumumanEdit ? route('pengumuman.update', $pengumumanEdit) : route('pengumuman.store') }}"
                            method="POST" class="space-y-5">
                            @csrf
                            @if ($pengumumanEdit)
                                @method('PUT')
                            @endif

                            <div>
                                <label for="judul"
                                    class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
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
                                                    <form action="{{ route('pengumuman.destroy', $pengumuman) }}"
                                                        method="POST"
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
            </section>
        </main>
    </div>
</body>

</html>
