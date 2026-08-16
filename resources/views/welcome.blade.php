<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIP RUTAN - Kejaksaan Negeri Banjarmasin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom Animations untuk menambah kesan hidup */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.1; transform: scale(1); }
            50% { opacity: 0.25; transform: scale(1.05); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .animate-pulse-glow {
            animation: pulse-glow 8s ease-in-out infinite;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-slate-800 font-sans selection:bg-[#F5C542] selection:text-[#0f172a]">

    <!-- Navbar -->
    <nav class="absolute top-0 w-full z-50 transition-all duration-300 border-b border-white/5 bg-gradient-to-b from-[#0f172a]/80 to-transparent">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div class="bg-white/10 p-2.5 rounded-2xl border border-white/20 backdrop-blur-md shadow-[0_0_15px_rgba(245,197,66,0.15)] group-hover:shadow-[0_0_25px_rgba(245,197,66,0.3)] transition-all duration-300">
                        <img src="{{ asset('assets/logo-kejari.png') }}" alt="Logo" class="w-10 h-10 object-contain group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="hidden md:block">
                        <h1 class="font-serif font-bold text-xl text-[#F5C542] leading-none tracking-wider drop-shadow-md">SIP-RUTAN</h1>
                        <p class="text-[10px] text-slate-300 uppercase tracking-[0.2em] mt-1.5 font-medium">Kejaksaan Negeri Banjarmasin</p>
                    </div>
                </div>

                <div class="flex items-center gap-5">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 text-sm font-bold text-[#0f172a] bg-[#F5C542] rounded-full hover:bg-yellow-400 transition-all duration-300 shadow-[0_4px_14px_0_rgba(245,197,66,0.39)] hover:shadow-[0_6px_20px_rgba(245,197,66,0.23)] hover:-translate-y-0.5 transform">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-300 hover:text-[#F5C542] transition-colors duration-300 px-2 py-2">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-bold text-[#0f172a] bg-white rounded-full hover:bg-[#F5C542] transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform">
                        Daftar Akun
                    </a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-[#0f172a] overflow-hidden min-h-screen flex flex-col justify-center">
        <!-- Background Textures & Glows -->
        <div class="absolute inset-0 opacity-[0.15]" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#0f172a]/50 to-[#0f172a]"></div>
        
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-[#F5C542] rounded-full blur-[140px] animate-pulse-glow"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-blue-600 rounded-full blur-[120px] animate-pulse-glow" style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 pt-32 pb-20 text-center flex flex-col items-center">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full glass-card mb-10 transform transition hover:scale-105 cursor-default">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-xs font-bold uppercase tracking-[0.15em] text-[#F5C542]">Pelayanan Publik Digital Terpadu</span>
            </div>

            <!-- Title -->
            <h1 class="text-5xl md:text-7xl font-serif font-bold text-white leading-[1.1] mb-6 drop-shadow-2xl">
                Layanan Kunjungan <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#F5C542] via-yellow-200 to-[#F5C542] bg-[length:200%_auto] animate-gradient">Cepat & Transparan</span>
            </h1>

            <p class="text-lg md:text-xl text-slate-300 max-w-2xl mx-auto mb-12 leading-relaxed font-light">
                Platform resmi <strong class="font-semibold text-white">Kejaksaan Negeri Banjarmasin</strong> untuk mempermudah masyarakat dalam mengajukan jadwal kunjungan tahanan secara online, tanpa antri.
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-5 w-full sm:w-auto">
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-[#F5C542] text-[#0f172a] font-bold text-lg rounded-2xl shadow-[0_0_20px_rgba(245,197,66,0.4)] hover:shadow-[0_0_35px_rgba(245,197,66,0.6)] transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    Ajukan Sekarang
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="#alur" class="w-full sm:w-auto px-8 py-4 bg-white/5 border border-white/20 hover:bg-white/10 text-white font-bold text-lg rounded-2xl backdrop-blur-sm transition-all duration-300">
                    Pelajari Alur
                </a>
            </div>

            <!-- Stats Glass Card -->
            <div class="mt-20 glass-card rounded-3xl p-8 w-full max-w-4xl mx-auto animate-float">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-white/10">
                    <div class="px-4">
                        <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-white to-slate-400 mb-2">24/7</div>
                        <div class="text-xs text-[#F5C542] font-semibold uppercase tracking-widest">Akses Online</div>
                    </div>
                    <div class="px-4">
                        <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-white to-slate-400 mb-2">100%</div>
                        <div class="text-xs text-[#F5C542] font-semibold uppercase tracking-widest">Gratis</div>
                    </div>
                    <div class="px-4">
                        <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-white to-slate-400 mb-2">QR</div>
                        <div class="text-xs text-[#F5C542] font-semibold uppercase tracking-widest">Tiket Digital</div>
                    </div>
                    <div class="px-4">
                        <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-br from-white to-slate-400 mb-2"><svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
                        <div class="text-xs text-[#F5C542] font-semibold uppercase tracking-widest">Realtime</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Decorative Bottom Wave/Divider -->
        <div class="absolute bottom-0 w-full h-24 bg-gradient-to-t from-gray-50 to-transparent"></div>
    </div>

    <!-- Alur Section -->
    <div id="alur" class="py-24 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-[#F5C542] font-bold tracking-widest uppercase text-sm mb-2 block">Panduan</span>
                <h2 class="text-[#0f172a] font-serif font-bold text-3xl md:text-5xl">Alur Pengajuan Kunjungan</h2>
                <div class="w-24 h-1.5 bg-gradient-to-r from-[#F5C542] to-yellow-200 mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="relative">
                <!-- Garis Penghubung (Hanya Desktop) -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-slate-300 to-transparent -translate-y-1/2 z-0"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 relative z-10">
                    <!-- Card 1 -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:border-[#F5C542]/30 transition-all duration-300 group hover:-translate-y-2">
                        <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-[#0f172a] mb-6 group-hover:bg-[#F5C542] group-hover:text-white transition-all duration-300 shadow-sm mx-auto md:mx-0">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-[#0f172a] mb-4 text-center md:text-left"><span class="text-[#F5C542]">01.</span> Isi Formulir</h3>
                        <p class="text-slate-600 leading-relaxed text-center md:text-left">
                            Lengkapi data diri pengunjung dan pilih jadwal kunjungan yang tersedia secara praktis melalui dashboard pemohon.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:border-[#F5C542]/30 transition-all duration-300 group hover:-translate-y-2">
                        <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-[#0f172a] mb-6 group-hover:bg-[#F5C542] group-hover:text-white transition-all duration-300 shadow-sm mx-auto md:mx-0">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-[#0f172a] mb-4 text-center md:text-left"><span class="text-[#F5C542]">02.</span> Verifikasi</h3>
                        <p class="text-slate-600 leading-relaxed text-center md:text-left">
                            Data Anda akan diverifikasi oleh petugas kami. Anda dapat memantau status persetujuan secara real-time.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-2xl hover:border-[#F5C542]/30 transition-all duration-300 group hover:-translate-y-2">
                        <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-[#0f172a] mb-6 group-hover:bg-[#F5C542] group-hover:text-white transition-all duration-300 shadow-sm mx-auto md:mx-0">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-[#0f172a] mb-4 text-center md:text-left"><span class="text-[#F5C542]">03.</span> Scan QR</h3>
                        <p class="text-slate-600 leading-relaxed text-center md:text-left">
                            Jika disetujui, Anda akan mendapatkan Tiket QR Code digital. Cukup tunjukkan kepada petugas saat datang ke lokasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#0f172a] relative overflow-hidden border-t-4 border-[#F5C542]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 opacity-80">
                    <img src="{{ asset('assets/logo-kejari.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                    <span class="text-slate-300 font-serif font-bold">SIP-RUTAN</span>
                </div>
                <p class="text-slate-400 text-sm font-light text-center md:text-left">
                    &copy; {{ date('Y') }} Kejaksaan Negeri Banjarmasin. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>