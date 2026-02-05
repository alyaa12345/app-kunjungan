<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Sandi - SIP RUTAN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">

    <div class="min-h-screen flex flex-col md:flex-row">

        <div class="hidden md:flex md:w-1/2 bg-[#0f172a] relative overflow-hidden items-center justify-center p-12 text-white">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-[#F5C542] rounded-full blur-[150px] opacity-10"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-600 rounded-full blur-[120px] opacity-10"></div>

            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/20 p-3 shadow-lg backdrop-blur-sm">
                    <svg class="w-10 h-10 text-[#F5C542]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>

                <h1 class="text-3xl font-serif font-bold mb-2 tracking-wide">Keamanan Akun</h1>
                <p class="text-slate-400 text-sm max-w-xs mx-auto leading-relaxed">
                    Pastikan Anda menggunakan kata sandi yang kuat (kombinasi huruf dan angka) demi keamanan data.
                </p>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center p-6 md:p-12 bg-white relative">

            <div class="absolute top-6 left-6 md:hidden flex items-center gap-2">
                <img src="{{ asset('assets/logo-kejari.png') }}" class="w-8 h-8">
                <span class="font-bold text-[#0f172a] text-sm">SIP-RUTAN</span>
            </div>

            <div class="w-full max-w-md space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-[#0f172a]">Buat Kata Sandi Baru</h2>
                    <p class="mt-2 text-sm text-gray-500">Silakan masukkan kata sandi baru untuk akun Anda.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase mb-1">Email Akun</label>
                        <input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus
                            class="block w-full rounded-lg border-gray-300 bg-gray-100 text-gray-500 shadow-sm sm:text-sm py-3 cursor-not-allowed font-medium"
                            readonly>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase mb-1">Kata Sandi Baru</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F5C542] focus:ring-[#F5C542] sm:text-sm py-3 font-semibold"
                            placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-500 uppercase mb-1">Ulangi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F5C542] focus:ring-[#F5C542] sm:text-sm py-3 font-semibold"
                            placeholder="Ketik ulang sandi baru">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-lg text-sm font-bold text-[#0f172a] bg-[#F5C542] hover:bg-yellow-400 hover:-translate-y-0.5 transition-all focus:outline-none tracking-wide">
                        SIMPAN & MASUK
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>