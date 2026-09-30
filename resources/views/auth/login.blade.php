<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | KASWARGA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-[#111111]">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="w-full max-w-md border border-[#e5e5e5] bg-white p-6 sm:p-8">
            <div class="border-b border-[#e5e5e5] pb-6">
                <p class="text-sm font-bold tracking-[0.16em] text-black">KASWARGA</p>
                <h1 class="mt-3 text-2xl font-bold">Sistem Informasi Kas Warga</h1>
                <p class="mt-2 text-sm text-[#666666]">Masuk untuk melanjutkan ke sistem.</p>
            </div>

            @if (session('status'))
                <div class="mt-6 border border-[#e5e5e5] bg-[#f5f5f5] px-4 py-3 text-sm text-[#111111]">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="w-full border border-[#e5e5e5] px-3 py-2.5 text-sm outline-none transition focus:border-black focus:ring-1 focus:ring-black @error('email') border-red-600 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="w-full border border-[#e5e5e5] px-3 py-2.5 text-sm outline-none transition focus:border-black focus:ring-1 focus:ring-black @error('password') border-red-600 @enderror">
                    @error('password')
                        <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-[#666666]">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="border-[#e5e5e5] text-black focus:ring-black">
                    Ingat saya
                </label>

                <button type="submit" class="w-full bg-black px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#333333] focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                    Login
                </button>
            </form>
        </section>
    </main>
</body>
</html>
