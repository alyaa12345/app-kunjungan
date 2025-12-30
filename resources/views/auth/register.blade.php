<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - SIP RUTAN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">

    <div class="min-h-screen flex flex-col md:flex-row">

        <div class="hidden md:flex md:w-1/2 bg-[#0f172a] relative overflow-hidden items-center justify-center p-12 text-white">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-[#F5C542] rounded-full blur-[150px] opacity-10"></div>

            <div class="relative z-10 text-center">
                <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/20 shadow-2xl p-3">
                    <img src="{{ asset('assets/logo-kejari.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <h2 class="text-xs font-bold tracking-[0.3em] uppercase text-[#F5C542] mb-2">Registrasi Pemohon</h2>
                <h1 class="text-3xl font-serif font-bold mb-4">Buat Akun Baru</h1>
                <p class="text-slate-400 text-sm max-w-sm mx-auto leading-relaxed">
                    Bergabunglah untuk menikmati kemudahan layanan kunjungan online yang transparan dan cepat.
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
                    <h2 class="text-2xl font-bold text-[#0f172a]">Isi Data Diri</h2>
                    <p class="mt-1 text-sm text-gray-500">Lengkapi formulir di bawah ini dengan benar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F5C542] focus:ring-[#F5C542] sm:text-sm py-2.5"
                            placeholder="Sesuai KTP">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F5C542] focus:ring-[#F5C542] sm:text-sm py-2.5"
                            placeholder="contoh@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F5C542] focus:ring-[#F5C542] sm:text-sm py-2.5"
                            placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Ulangi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#F5C542] focus:ring-[#F5C542] sm:text-sm py-2.5"
                            placeholder="Ketik ulang sandi">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-[#0f172a] bg-[#F5C542] hover:bg-yellow-400 hover:-translate-y-0.5 transition-all focus:outline-none">
                        DAFTAR SEKARANG
                    </button>
                </form>

                <div class="mt-6 text-center border-t border-gray-100 pt-6">
                    <p class="text-sm text-gray-500">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="font-bold text-[#0f172a] hover:text-[#F5C542] hover:underline">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>