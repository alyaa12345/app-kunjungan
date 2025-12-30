<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Sandi - SIP RUTAN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">

    <div class="min-h-screen flex flex-col md:flex-row">

        <div class="hidden md:flex md:w-1/2 bg-[#0f172a] relative overflow-hidden items-center justify-center p-12 text-white">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>

            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/20 p-3">
                    <svg class="w-10 h-10 text-[#F5C542]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-serif font-bold mb-2">Pemulihan Akun</h1>
                <p class="text-slate-400 text-sm max-w-xs mx-auto">
                    Kami akan membantu Anda mengatur ulang kata sandi agar bisa kembali mengakses layanan.
                </p>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center p-6 md:p-12 bg-white relative">

            <div class="w-full max-w-md space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-[#0f172a]">Lupa Kata Sandi?</h2>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                        Jangan khawatir. Masukkan alamat email yang Anda daftarkan, dan kami akan mengirimkan tautan untuk membuat kata sandi baru.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email Terdaftar</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F5C542] focus:ring-[#F5C542] sm:text-sm py-3"
                            placeholder="contoh@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-[#0f172a] hover:bg-slate-800 hover:-translate-y-0.5 transition-all focus:outline-none">
                        KIRIM TAUTAN RESET
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-400 hover:text-[#0f172a] flex items-center justify-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Halaman Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>