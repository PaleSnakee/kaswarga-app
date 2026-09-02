@props(['title'])

<header class="sticky top-0 z-20 border-b border-[#e5e5e5] bg-white">
    <div class="flex min-h-16 items-center gap-4 px-4 sm:px-6 lg:px-8">
        <button type="button" @click="sidebarOpen = true"
            class="inline-flex h-9 w-9 items-center justify-center rounded-sm border border-[#e5e5e5] text-[#111111] hover:bg-[#f5f5f5] lg:hidden"
            aria-label="Buka navigasi">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                aria-hidden="true">
                <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div class="min-w-0 flex-1">
            <h1 class="truncate text-lg font-bold text-[#111111] sm:text-xl">{{ $title }}</h1>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            {{ $slot }}
        </div>
    </div>

    @if (trim($slot) !== '')
        <div class="border-t border-[#e5e5e5] px-4 py-3 md:hidden">
            {{ $slot }}
        </div>
    @endif
</header>
