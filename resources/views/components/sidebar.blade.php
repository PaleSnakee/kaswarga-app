<aside
    class="fixed inset-y-0 left-0 z-40 flex w-60 -translate-x-full flex-col border-r border-[#e5e5e5] bg-white transition-transform duration-200 lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" @keydown.escape.window="sidebarOpen = false">
    <div class="border-b border-[#e5e5e5] px-6 py-6">
        <a href="{{ route('dashboard') }}" class="block">
            <p class="text-sm font-bold tracking-[0.16em] text-black">KASWARGA</p>
            <p class="mt-1 text-xs text-[#666666]">Sistem Informasi Kas Warga</p>
        </a>
    </div>

    <nav class="flex-1 space-y-1 px-3 py-5" aria-label="Navigasi utama">
        <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
            class="{{ request()->routeIs('dashboard') ? 'bg-black text-white' : 'text-[#111111] hover:bg-[#f5f5f5]' }} flex items-center gap-3 rounded-sm px-3 py-2.5 text-sm font-medium transition">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m3 9 9-7 9 7v10.5a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 19.5V9Z" />
                <path stroke-linecap="round" d="M9 21v-6h6v6" />
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('kepala-keluarga.index') }}" @click="sidebarOpen = false"
            class="{{ request()->routeIs('kepala-keluarga.*') ? 'bg-black text-white' : 'text-[#111111] hover:bg-[#f5f5f5]' }} flex items-center gap-3 rounded-sm px-3 py-2.5 text-sm font-medium transition">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            <span>Data Warga</span>
        </a>
        <a href="{{ route('transactions.index') }}" @click="sidebarOpen = false"
            class="{{ request()->routeIs('transactions.*') ? 'bg-black text-white' : 'text-[#111111] hover:bg-[#f5f5f5]' }} flex items-center gap-3 rounded-sm px-3 py-2.5 text-sm font-medium transition">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                aria-hidden="true">
                <rect x="3" y="6" width="18" height="12" rx="1" />
                <path stroke-linecap="round" d="M3 10h18M16 14h2" />
            </svg>
            <span>Kelola Kas</span>
        </a>
        <a href="{{ route('pengumuman.index') }}" @click="sidebarOpen = false"
            class="{{ request()->routeIs('pengumuman.*') ? 'bg-black text-white' : 'text-[#111111] hover:bg-[#f5f5f5]' }} flex items-center gap-3 rounded-sm px-3 py-2.5 text-sm font-medium transition">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.5 6.5 6 9H3v6h3l5.5 2.5V6.5ZM14 8a5 5 0 0 1 0 8M16.5 5.5a8.5 8.5 0 0 1 0 13" />
            </svg>
            <span>Pengumuman</span>
        </a>
        <span
            class="flex cursor-not-allowed items-center gap-3 rounded-sm px-3 py-2.5 text-sm font-medium text-[#999999]"
            title="Segera tersedia">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 16v-5m5 5V7m5 9v-3" />
            </svg>
            <span>Laporan</span>
        </span>
    </nav>

    <div class="relative border-t border-[#e5e5e5] p-3" x-data="{ profileOpen: false }">
        <button type="button" @click="profileOpen = !profileOpen" @click.outside="profileOpen = false"
            class="flex w-full items-center gap-3 rounded-sm px-3 py-3 text-left hover:bg-[#f5f5f5]">
            <span
                class="flex h-9 w-9 items-center justify-center rounded-full bg-black text-xs font-bold text-white">AD</span>
            <span class="min-w-0 flex-1"><span class="block text-sm font-semibold text-[#111111]">Admin</span><span
                    class="block text-xs text-[#666666]">Administrator</span></span>
            <svg class="h-4 w-4 text-[#666666]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
            </svg>
        </button>
        <div x-cloak x-show="profileOpen" x-transition.origin.bottom
            class="absolute bottom-16 left-3 right-3 border border-[#e5e5e5] bg-white p-1 shadow-sm">
            <a href="#" class="block rounded-sm px-3 py-2 text-sm text-[#111111] hover:bg-[#f5f5f5]">Profile</a>
            <button type="button"
                class="block w-full rounded-sm px-3 py-2 text-left text-sm text-[#111111] hover:bg-[#f5f5f5]">Logout</button>
        </div>
    </div>
</aside>
