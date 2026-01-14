<x-app-layout>
    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="bg-[#0f172a] py-10 border-b-4 border-[#F5C542] relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">

                    <div class="text-white">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-3 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-[10px] uppercase tracking-widest font-bold text-[#F5C542]">Sistem Online Terpadu</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-serif font-bold leading-tight">
                            Portal Pelayanan <span class="text-[#F5C542]">Kunjungan Digital</span>
                        </h1>
                        <p class="text-slate-400 mt-2 text-sm md:text-base max-w-2xl">
                            Selamat datang, <strong>{{ Auth::user()->name }}</strong>. Kelola jadwal kunjungan Anda dengan mudah, cepat, dan transparan.
                        </p>
                    </div>

                    <div class="bg-white/5 border border-white/10 rounded-xl p-5 flex items-center gap-5 min-w-[250px] backdrop-blur-sm hover:bg-white/10 transition">
                        <div class="text-right">
                            <div class="text-xs text-slate-400 uppercase tracking-wider">Total Permohonan</div>
                            <div class="text-3xl font-bold text-white">{{ $kunjungans->count() }}</div>
                        </div>
                        <div class="h-12 w-12 bg-[#F5C542] rounded-lg flex items-center justify-center text-[#0f172a] shadow-lg shadow-orange-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if(session('success'))
            <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r shadow-sm flex items-center gap-3 animate-fade-in-down">
                <div class="bg-emerald-100 p-2 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm">Berhasil!</h4>
                    <p class="text-xs">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-[#0f172a] text-xl">Menu Layanan</h3>
                    <p class="text-xs text-slate-500">Akses cepat fitur aplikasi</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">

                <a href="{{ route('masyarakat.laporan', 'statistik') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700 group-hover:text-blue-600">Statistik</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Grafik Kunjungan</p>
                </a>

                <a href="{{ route('masyarakat.laporan', 'jadwal') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700 group-hover:text-purple-600">Jadwal & Tiket</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Cetak & Lihat Tiket</p>
                </a>

                <a href="{{ route('masyarakat.riwayat') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700 group-hover:text-emerald-600">Riwayat</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Arsip Permohonan</p>
                </a>

                <div onclick="document.getElementById('infoModal').classList.remove('hidden')" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center cursor-pointer">
                    <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700 group-hover:text-orange-600">Tata Tertib</h4>
                    <p class="text-[10px] text-slate-400 mt-1">Info Kunjungan</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <div>
                        <h3 class="font-bold text-[#0f172a]">Tiket Permohonan Saya</h3>
                        <p class="text-xs text-slate-500">Daftar 5 pengajuan terakhir</p>
                    </div>
                    <a href="{{ route('masyarakat.create') }}" class="px-5 py-2.5 bg-[#F5C542] hover:bg-yellow-400 text-[#0f172a] text-xs font-bold rounded-lg shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Baru
                    </a>
                </div>

                @if($kunjungans->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700">Tidak Ada Data</h4>
                    <p class="text-slate-500 text-sm mt-1">Mulai buat janji kunjungan sekarang.</p>
                </div>
                @else
                <div class="divide-y divide-slate-100">
                    @foreach($kunjungans as $item)
                    <div class="p-4 hover:bg-blue-50/50 transition flex flex-col md:flex-row items-center justify-between gap-4 group">

                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <div class="w-16 h-16 bg-[#0f172a] rounded-xl flex flex-col items-center justify-center text-white shrink-0 shadow-md group-hover:scale-105 transition-transform">
                                <span class="text-[10px] uppercase font-bold opacity-70 tracking-widest">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('M') }}</span>
                                <span class="text-2xl font-bold font-serif leading-none">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d') }}</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-mono font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">#REQ-{{ $item->id }}</span>

                                    @if($item->status == 'menunggu')
                                    <span class="flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> VERIFIKASI
                                    </span>
                                    @elseif($item->status == 'disetujui')
                                    <span class="flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg> DISETUJUI
                                    </span>
                                    @elseif($item->status == 'ditolak')
                                    <span class="flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">
                                        DITOLAK
                                    </span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $item->nama_tahanan }}
                                </h4>
                            </div>
                        </div>

                        <a href="{{ route('masyarakat.show', $item->id) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-4 py-2 rounded-lg transition flex items-center gap-1">
                            Lihat Detail
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="text-center text-slate-400 text-xs py-10">
                &copy; {{ date('Y') }} Kejaksaan Negeri Banjarmasin
            </div>
        </div>
    </div>

    <div id="infoModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('infoModal').classList.add('hidden')"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg animate-scale-up">

                    <div class="bg-[#0f172a] px-4 py-4 sm:px-6 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="bg-[#F5C542] p-1.5 rounded text-[#0f172a]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold leading-6 text-white">Tata Tertib Kunjungan</h3>
                        </div>
                        <button type="button" class="text-slate-400 hover:text-white transition" onclick="document.getElementById('infoModal').classList.add('hidden')">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-6 max-h-[400px] overflow-y-auto bg-slate-50">
                        <ul class="space-y-4 text-sm text-slate-700">
                            <li class="flex gap-4 p-3 bg-white rounded-xl border border-slate-200 shadow-sm">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-sm">1</span>
                                <span class="leading-relaxed">Wajib membawa <strong>KTP/SIM Asli</strong> yang masih berlaku sebagai syarat masuk.</span>
                            </li>
                            <li class="flex gap-4 p-3 bg-white rounded-xl border border-slate-200 shadow-sm">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-sm">2</span>
                                <span class="leading-relaxed">Dilarang membawa <strong>HP, Senjata Tajam, Narkoba</strong>, dan barang terlarang lainnya.</span>
                            </li>
                            <li class="flex gap-4 p-3 bg-white rounded-xl border border-slate-200 shadow-sm">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-sm">3</span>
                                <span class="leading-relaxed">Pengunjung wajib <strong>berpakaian sopan</strong> (Dilarang celana pendek/rok mini).</span>
                            </li>
                            <li class="flex gap-4 p-3 bg-white rounded-xl border border-slate-200 shadow-sm">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-sm">4</span>
                                <span class="leading-relaxed">Waktu kunjungan dibatasi maksimal <strong>20 Menit</strong> per sesi.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                        <button type="button" class="inline-flex w-full justify-center rounded-xl bg-[#0f172a] px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-[#F5C542] hover:text-[#0f172a] sm:ml-3 sm:w-auto transition-all" onclick="document.getElementById('infoModal').classList.add('hidden')">
                            Saya Mengerti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>