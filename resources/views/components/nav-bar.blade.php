<nav class="space-y-2">
    <a href="{{ route('dashboard') }}"
        class="flex items-center gap-3 rounded-2xl px-4 py-3 font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-brand-600 text-white shadow-lg shadow-brand-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span
            class="flex h-9 w-9 items-center justify-center rounded-xl text-sm font-bold {{ request()->routeIs('dashboard') ? 'bg-white/15' : 'bg-slate-800' }}">DB</span>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('kepala-keluarga.index') }}"
        class="flex items-center gap-3 rounded-2xl px-4 py-3 font-semibold transition {{ request()->routeIs('kepala-keluarga.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span
            class="flex h-9 w-9 items-center justify-center rounded-xl text-sm font-bold {{ request()->routeIs('kepala-keluarga.*') ? 'bg-white/15' : 'bg-slate-800' }}">KK</span>
        <span>Data KK</span>
    </a>
    <a href="{{ route('pengumuman.index') }}"
        class="flex items-center gap-3 rounded-2xl px-4 py-3 font-semibold transition {{ request()->routeIs('pengumuman.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span
            class="flex h-9 w-9 items-center justify-center rounded-xl text-sm font-bold {{ request()->routeIs('pengumuman.*') ? 'bg-white/15' : 'bg-slate-800' }}">PG</span>
        <span>Pengumuman</span>
    </a>
</nav>
