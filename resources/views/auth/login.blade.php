<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - SIP RUTAN Kejaksaan Negeri Banjarmasin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">

    <div class="min-h-screen flex flex-col md:flex-row">

        <div class="hidden md:flex md:w-1/2 bg-[#0f172a] relative overflow-hidden items-center justify-center p-12 text-white">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#F5C542] rounded-full blur-[150px] opacity-10"></div>

            <div class="relative z-10 text-center">
                <div class="w-32 h-32 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-8 border border-white/20 shadow-2xl backdrop-blur-sm p-4">
                    <img src="{{ asset('assets/logo-kejari.png') }}" alt="Logo Kejari" class="w-full h-full object-contain">
                </div>

                <h2 class="text-xs font-bold tracking-[0.3em] uppercase text-[#F5C542] mb-2">Sistem Online Terpadu</h2>
                <h1 class="text-4xl font-serif font-bold mb-4 leading-tight">Kejaksaan Negeri <br> Banjarmasin</h1>
                <p class="text-slate-400 text-sm max-w-md mx-auto leading-relaxed">
                    Masuk untuk mengelola jadwal kunjungan, memantau status permohonan, dan mengakses layanan digital kami.
                </p>
            </div>

            <div class="absolute bottom-6 text-xs text-slate-600">
                &copy; {{ date('Y') }} SIP-RUTAN. All rights reserved.
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center p-6 md:p-12 bg-white relative">

            <div class="absolute top-6 left-6 md:hidden flex items-center gap-2">
                <img src="{{ asset('assets/logo-kejari.png') }}" class="w-8 h-8">
                <span class="font-bold text-[#0f172a] text-sm">SIP-RUTAN</span>
            </div>

            <div class="w-full max-w-md space-y-8">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-bold text-[#0f172a]">Selamat Datang</h2>
                    <p class="mt-2 text-sm text-gray-500">Silakan masukkan akun Anda untuk melanjutkan.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email / NIP</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F5C542] focus:ring-[#F5C542] sm:text-sm py-3"
                                placeholder="contoh@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#0f172a] hover:text-[#F5C542] hover:underline">
                                Lupa sandi?
                            </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F5C542] focus:ring-[#F5C542] sm:text-sm py-3"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-[#0f172a] focus:ring-[#F5C542] border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600">Ingat saya di perangkat ini</label>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-bold text-[#0f172a] bg-[#F5C542] hover:bg-yellow-400 hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F5C542]">
                        MASUK SEKARANG
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-bold text-[#0f172a] hover:text-[#F5C542] hover:underline">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>