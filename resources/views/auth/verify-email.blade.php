<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - SIP RUTAN</title>
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
                <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/20 p-4 shadow-xl">
                    <svg class="w-12 h-12 text-[#F5C542]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-serif font-bold mb-2">Cek Email Anda</h1>
                <p class="text-slate-400 text-sm max-w-sm mx-auto">
                    Kami telah mengirimkan tautan verifikasi ke alamat email yang Anda daftarkan.
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
                    <h2 class="text-2xl font-bold text-[#0f172a]">Verifikasi Diperlukan</h2>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                        Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan.
                    </p>
                    <p class="mt-2 text-sm text-gray-500">
                        Jika Anda tidak menerima email, kami dapat mengirim ulang.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-lg border border-green-100 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tautan verifikasi baru telah dikirim ke email Anda.
                </div>
                @endif

                <div class="mt-4 flex flex-col gap-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-[#0f172a] bg-[#F5C542] hover:bg-yellow-400 hover:-translate-y-0.5 transition-all">
                            KIRIM ULANG VERIFIKASI
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all">
                            KELUAR (LOGOUT)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>