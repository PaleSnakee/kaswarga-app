@extends('layouts.app')

@section('content')
    <div class="mb-6 border-b border-[#e5e5e5] pb-5">
        <p class="text-sm text-[#666666]">{{ $greeting }}, {{ auth()->user()->name }}</p>
        <h2 class="mt-1 text-2xl font-bold text-[#111111]">Dashboard</h2>
    </div>

    <div class="grid gap-5 xl:grid-cols-3">
        <section class="panel p-5 xl:col-span-2">
            <div class="flex items-center justify-between border-b border-[#e5e5e5] pb-4">
                <div>
                    <h3 class="font-bold text-[#111111]">Pengumuman Terbaru</h3>
                    <p class="mt-1 text-sm text-[#666666]">Informasi untuk warga dan pengurus.</p>
                </div>
                <a href="{{ route('pengumuman.index') }}"
                    class="text-sm font-medium text-[#111111] underline underline-offset-4">{{ auth()->user()->hasRole('admin') ? 'Kelola' : 'Lihat semua' }}</a>
            </div>
            <div class="divide-y divide-[#e5e5e5]">
                @forelse ($pengumuman as $item)
                    <article class="py-4">
                        <h4 class="font-semibold text-[#111111]">{{ $item->judul }}</h4>
                        <p class="mt-1 text-sm leading-6 text-[#666666]">{{ $item->isi }}</p>
                    </article>
                @empty
                    <p class="py-8 text-center text-sm text-[#666666]">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </section>

        <section class="panel p-5">
            <p class="text-sm text-[#666666]">Jumlah Kepala Keluarga</p>
            <p class="mt-3 text-4xl font-bold tracking-tight text-[#111111]">{{ $jumlahKepalaKeluarga }}</p>
            <p class="mt-3 text-sm leading-6 text-[#666666]">Total data kepala keluarga yang tercatat dalam sistem.</p>
            @if (auth()->user()->hasRole('admin'))
                <a href="{{ route('kepala-keluarga.index') }}" class="btn-primary mt-5">Buka Data Warga</a>
            @else
                <a href="{{ route('transactions.index') }}" class="btn-primary mt-5">Lihat Informasi Kas</a>
            @endif
        </section>
    </div>
@endsection
