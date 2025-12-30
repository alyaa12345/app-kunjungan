<x-app-layout>
    <div class="min-h-screen bg-[#F8FAFC]">

        <div class="bg-[#0f172a] py-10 border-b-4 border-[#F5C542]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">

                    <div class="text-white">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 mb-3">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-[10px] uppercase tracking-widest font-bold text-[#F5C542]">Sistem Online Terpadu</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-serif font-bold leading-tight">
                            Portal Pelayanan <span class="text-[#F5C542]">Kunjungan Digital</span>
                        </h1>
                        <p class="text-slate-400 mt-2 text-sm md:text-base max-w-2xl">
                            Selamat datang, <strong>{{ Auth::user()->name }}</strong>. Kelola jadwal kunjungan Anda dengan mudah dan transparan.
                        </p>
                    </div>

                    <div class="bg-white/5 border border-white/10 rounded-xl p-5 flex items-center gap-5 min-w-[250px]">
                        <div class="text-right">
                            <div class="text-xs text-slate-400 uppercase tracking-wider">Total Permohonan</div>
                            <div class="text-3xl font-bold text-white">{{ $kunjungans->count() }}</div>
                        </div>
                        <div class="h-12 w-12 bg-[#F5C542] rounded-lg flex items-center justify-center text-[#0f172a] shadow-lg">
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
            <div class="mb-8 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r shadow-sm flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <div>
                    <h4 class="font-bold text-sm">Permohonan Berhasil!</h4>
                    <p class="text-xs">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-[#0f172a] text-lg">Menu Laporan</h3>
                <span class="text-xs text-slate-500">Akses cepat informasi</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <a href="{{ route('masyarakat.laporan', 'statistik') }}" class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-500 transition-all group text-center">
                    <div class="w-10 h-10 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-slate-700 text-sm">Statistik</span>
                </a>
                <a href="{{ route('masyarakat.laporan', 'jadwal') }}" class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-purple-500 transition-all group text-center">
                    <div class="w-10 h-10 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-purple-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-slate-700 text-sm">Jadwal</span>
                </a>
                <a href="{{ route('masyarakat.laporan', 'dokumen') }}" class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all group text-center">
                    <div class="w-10 h-10 mx-auto bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-slate-700 text-sm">Dokumen</span>
                </a>
                <a href="{{ route('masyarakat.laporan', 'notifikasi') }}" class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-orange-500 transition-all group text-center">
                    <div class="w-10 h-10 mx-auto bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-orange-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-slate-700 text-sm">Riwayat</span>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <div>
                        <h3 class="font-bold text-[#0f172a]">Tiket Permohonan Saya</h3>
                        <p class="text-xs text-slate-500">Daftar riwayat pengajuan kunjungan</p>
                    </div>
                    <a href="{{ route('masyarakat.create') }}" class="px-4 py-2 bg-[#F5C542] hover:bg-yellow-400 text-[#0f172a] text-xs font-bold rounded shadow transition">
                        + Buat Baru
                    </a>
                </div>

                @if($kunjungans->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-700">Tidak Ada Data</h4>
                    <p class="text-slate-500 text-sm mt-1">Belum ada riwayat kunjungan saat ini.</p>
                </div>
                @else
                <div class="divide-y divide-slate-100">
                    @foreach($kunjungans as $item)
                    <div class="p-4 hover:bg-slate-50 transition flex flex-col md:flex-row items-center justify-between gap-4">

                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <div class="w-14 h-14 bg-[#0f172a] rounded flex flex-col items-center justify-center text-white shrink-0">
                                <span class="text-[9px] uppercase font-bold opacity-70">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('M') }}</span>
                                <span class="text-lg font-bold font-serif">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d') }}</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-mono text-slate-400">#REQ-{{ $item->id }}</span>
                                    @if($item->status == 'menunggu')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">VERIFIKASI</span>
                                    @elseif($item->status == 'disetujui')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">DISETUJUI</span>
                                    @elseif($item->status == 'ditolak')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">DITOLAK</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm">{{ $item->nama_tahanan }}</h4>
                            </div>
                        </div>

                        <a href="{{ route('masyarakat.show', $item->id) }}" class="text-sm font-bold text-blue-600 hover:underline">
                            Lihat Detail
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="text-center text-slate-400 text-xs py-8">
                &copy; {{ date('Y') }} Kejaksaan Negeri Banjarmasin
            </div>
        </div>
    </div>
</x-app-layout>