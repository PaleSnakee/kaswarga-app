<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KASWARGA')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: false }" class="min-h-screen">
    <x-sidebar />

    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-black/30 lg:hidden"
        @click="sidebarOpen = false" aria-hidden="true"></div>

    <main class="min-h-screen lg:ml-60">
        <x-header :title="trim($__env->yieldContent('title')) ?: 'KASWARGA'">
            @yield('header')
        </x-header>

        <div class="px-4 py-6 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>

</html>
