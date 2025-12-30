<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIP RUTAN - Kejaksaan Negeri Banjarmasin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-50 text-slate-800 font-sans">

    <nav class="absolute top-0 w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">
                <div class="flex items-center gap-3">
                    <div class="bg-white/10 p-2 rounded-full border border-white/20 backdrop-blur-sm">
                        <img src="{{ asset('assets/logo-kejari.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    </div>
                    <div class="hidden md:block">
                        <h1 class="font-serif font-bold text-lg text-[#F5C542] leading-none tracking-wide">SIP-RUTAN</h1>
                        <p class="text-[10px] text-gray-300 uppercase tracking-widest mt-1">Kejaksaan Negeri Banjarmasin</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 text-sm font-bold text-[#0f172a] bg-[#F5C542] rounded-full hover:bg-yellow-400 transition shadow-lg hover:-translate-y-0.5 transform">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-white hover:text-[#F5C542] transition px-4 py-2">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-bold text-[#0f172a] bg-white rounded-full hover:bg-[#F5C542] transition shadow-lg hover:-translate-y-0.5 transform">
                        Daftar Akun
                    </a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-[#0f172a] overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-[500px] h-[500px] bg-[#F5C542] rounded-full blur-[120px] opacity-10"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-[400px] h-[400px] bg-blue-600 rounded-full blur-[100px] opacity-10"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 pt-40 pb-24 text-center">

            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-8 animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-widest text-[#F5C542]">Pelayanan Publik Digital Terpadu</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-serif font-bold text-white leading-tight mb-6 drop-shadow-lg">
                Layanan Kunjungan <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#F5C542] to-[#fff7cd]">Cepat & Transparan</span>
            </h1>

            <p class="text-lg md:text-xl text-slate-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                Platform resmi Kejaksaan Negeri Banjarmasin untuk mempermudah masyarakat dalam mengajukan jadwal kunjungan tahanan secara online, tanpa antri.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-[#F5C542] hover:bg-yellow-400 text-[#0f172a] font-bold text-lg rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    Ajukan Sekarang
                </a>
                <a href="#alur" class="w-full sm:w-auto px-8 py-4 bg-transparent border-2 border-white/20 hover:bg-white/10 text-white font-bold text-lg rounded-xl transition-all">
                    Pelajari Alur
                </a>
            </div>

            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-white/10 pt-10 max-w-4xl mx-auto">
                <div>
                    <div class="text-3xl font-bold text-white mb-1">24/7</div>
                    <div class="text-xs text-slate-400 uppercase tracking-widest">Akses Online</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white mb-1">100%</div>
                    <div class="text-xs text-slate-400 uppercase tracking-widest">Gratis</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white mb-1">QR</div>
                    <div class="text-xs text-slate-400 uppercase tracking-widest">Tiket Digital</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white mb-1">Realtime</div>
                    <div class="text-xs text-slate-400 uppercase tracking-widest">Notifikasi</div>
                </div>
            </div>
        </div>
    </div>

    <div id="alur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-[#0f172a] font-serif font-bold text-3xl md:text-4xl">Alur Pengajuan Kunjungan</h2>
                <div class="w-24 h-1 bg-[#F5C542] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100 hover:shadow-xl transition-all group">
                    <div class="w-16 h-16 bg-[#0f172a] rounded-2xl flex items-center justify-center text-[#F5C542] mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#0f172a] mb-3">1. Isi Formulir</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Lengkapi data diri pengunjung dan pilih jadwal kunjungan yang tersedia melalui dashboard pemohon.
                    </p>
                </div>

                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100 hover:shadow-xl transition-all group">
                    <div class="w-16 h-16 bg-[#0f172a] rounded-2xl flex items-center justify-center text-[#F5C542] mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#0f172a] mb-3">2. Verifikasi Petugas</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Data Anda akan diverifikasi oleh petugas secara online. Pantau status pengajuan melalui notifikasi.
                    </p>
                </div>

                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100 hover:shadow-xl transition-all group">
                    <div class="w-16 h-16 bg-[#0f172a] rounded-2xl flex items-center justify-center text-[#F5C542] mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#0f172a] mb-3">3. Datang & Scan QR</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Jika disetujui, Anda akan mendapatkan Tiket QR Code. Tunjukkan kepada petugas saat kedatangan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-[#0f172a] py-8 text-center text-slate-500 text-sm border-t border-[#F5C542]">
        <p>&copy; {{ date('Y') }} Kejaksaan Negeri Banjarmasin. Hak Cipta Dilindungi.</p>
    </footer>

</body>

</html>