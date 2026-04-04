<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Kaswarga</title>

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
                <h1 class="mt-3 text-2xl font-bold text-white">Dashboard</h1>
                <p class="mt-2 text-sm text-slate-400">Pantau informasi penting kepala keluarga dan pengumuman terbaru.
                </p>
            </div>

            <x-nav-bar />
        </aside>

        <main class="flex-1">
            <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
                <div
                    class="flex flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-10">
                    <div>
                        <p class="text-sm text-slate-500">Halaman Utama</p>
                        <h2 class="text-2xl font-bold text-slate-900">{{ $greeting }}, Admin</h2>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('kepala-keluarga.index') }}"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">
                            Kelola KK
                        </a>
                        <button
                            class="flex items-center gap-3 rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-500 font-bold">A</span>
                            <span>Profile</span>
                        </button>
                    </div>
                </div>
            </header>

            <section class="px-4 py-6 sm:px-6 lg:px-10 lg:py-8">

                <div class="rounded-3xl bg-white p-6 shadow-soft">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Pengumuman</h3>
                            <p class="mt-1 text-sm text-slate-500">Informasi penting untuk kepala keluarga dan pengurus
                                lingkungan.</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 lg:grid-cols-3">
                        @foreach ($pengumuman as $item)
                            <div class="rounded-2xl bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-brand-600">{{ $item->judul }}</p>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $item->isi }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    <div class="rounded-3xl bg-white p-6 shadow-soft">
                        <p class="text-sm text-slate-500">Jumlah Kepala Keluarga</p>
                        <h3 class="mt-3 text-4xl font-bold text-slate-900">{{ $jumlahKepalaKeluarga }}</h3>
                        <p class="mt-2 text-sm text-slate-500">Seluruh data yang tersimpan sekarang hanya berisi kepala
                            keluarga.</p>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-soft">
                        <p class="text-sm text-slate-500">Akses Cepat</p>
                        <h3 class="mt-3 text-xl font-bold text-slate-900">Manajemen Kepala Keluarga</h3>
                        <p class="mt-2 text-sm text-slate-500">Tambahkan, ubah, atau hapus data kepala keluarga dari
                            menu data KK.</p>
                        <a href="{{ route('kepala-keluarga.index') }}"
                            class="mt-4 inline-flex rounded-2xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                            Buka Data KK
                        </a>
                    </div>
                </div>


            </section>
        </main>
    </div>
</body>

</html>
