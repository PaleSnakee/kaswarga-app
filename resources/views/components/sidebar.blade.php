@php
    $user = auth()->user();
    $isAdmin = $user->hasRole('admin');
    $isBendahara = $user->hasRole('bendahara');
    $isWarga = $user->hasRole('warga');
    $dashboardRoute = $isAdmin ? 'admin.dashboard' : ($isBendahara ? 'bendahara.dashboard' : 'warga.dashboard');
    $roleLabel = $isAdmin ? 'Administrator' : ($isBendahara ? 'Bendahara' : 'Warga');
@endphp

<aside
    class="fixed inset-y-0 left-0 z-40 flex w-60 -translate-x-full flex-col border-r border-[#e5e5e5] bg-white transition-transform duration-200 lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" @keydown.escape.window="sidebarOpen = false">
    <div class="border-b border-[#e5e5e5] px-6 py-6">
        <a href="{{ route($dashboardRoute) }}" class="block">
            <p class="text-sm font-bold tracking-[0.16em] text-black">KASWARGA</p>
            <p class="mt-1 text-xs text-[#666666]">Sistem Informasi Kas Warga</p>
        </a>
    </div>

    <nav class="flex-1 space-y-1 px-3 py-5" aria-label="Navigasi utama">
        <a href="{{ route($dashboardRoute) }}" @click="sidebarOpen = false"
            class="{{ request()->routeIs('*.dashboard') ? 'bg-black text-white' : 'text-[#111111] hover:bg-[#f5f5f5]' }} flex items-center rounded-sm px-3 py-2.5 text-sm font-medium transition">
            Dashboard
        </a>

        @if ($isAdmin)
            <a href="{{ route('kepala-keluarga.index') }}" @click="sidebarOpen = false"
                class="{{ request()->routeIs('kepala-keluarga.*') ? 'bg-black text-white' : 'text-[#111111] hover:bg-[#f5f5f5]' }} flex items-center rounded-sm px-3 py-2.5 text-sm font-medium transition">
                Data Warga
            </a>
        @endif

        <a href="{{ route('transactions.index') }}" @click="sidebarOpen = false"
            class="{{ request()->routeIs('transactions.*') ? 'bg-black text-white' : 'text-[#111111] hover:bg-[#f5f5f5]' }} flex items-center rounded-sm px-3 py-2.5 text-sm font-medium transition">
            {{ $isWarga ? 'Informasi Kas' : 'Kelola Kas' }}
        </a>

        @if ($isAdmin || $isBendahara)
            <a href="{{ route('anomalies.index') }}" @click="sidebarOpen = false"
                class="{{ request()->routeIs('anomalies.*') ? 'bg-black text-white' : 'text-[#111111] hover:bg-[#f5f5f5]' }} flex items-center rounded-sm px-3 py-2.5 text-sm font-medium transition">
                Audit Anomali
            </a>
        @endif
        <a href="{{ route('pengumuman.index') }}" @click="sidebarOpen = false"
            class="{{ request()->routeIs('pengumuman.*') ? 'bg-black text-white' : 'text-[#111111] hover:bg-[#f5f5f5]' }} flex items-center rounded-sm px-3 py-2.5 text-sm font-medium transition">
            Pengumuman
        </a>
    </nav>

    <div class="relative border-t border-[#e5e5e5] p-3" x-data="{ profileOpen: false }">
        <button type="button" @click="profileOpen = !profileOpen" @click.outside="profileOpen = false"
            class="flex w-full items-center gap-3 rounded-sm px-3 py-3 text-left hover:bg-[#f5f5f5]">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-black text-xs font-bold text-white">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </span>
            <span class="min-w-0 flex-1">
                <span class="block truncate text-sm font-semibold text-[#111111]">{{ $user->name }}</span>
                <span class="block text-xs text-[#666666]">{{ $roleLabel }}</span>
            </span>
        </button>
        <div x-cloak x-show="profileOpen" x-transition.origin.bottom
            class="absolute bottom-16 left-3 right-3 border border-[#e5e5e5] bg-white p-1 shadow-sm">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="block w-full rounded-sm px-3 py-2 text-left text-sm text-[#111111] hover:bg-[#f5f5f5]">
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
