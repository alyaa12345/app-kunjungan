<x-app-layout>
    <div class="min-h-screen bg-[#F8FAFC] font-sans">

        <div class="bg-gradient-to-br from-[#0f172a] to-[#1e293b] text-white pt-10 pb-16 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-[#F5C542] rounded-full mix-blend-overlay filter blur-3xl opacity-10 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10"></div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-[#F5C542] text-[#0f172a] text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg shadow-yellow-500/20">
                                Area Pimpinan
                            </span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight">
                            Dashboard Monitoring
                        </h1>
                        <p class="text-slate-400 text-sm mt-2 max-w-xl leading-relaxed border-l-2 border-[#F5C542] pl-3">
                            Pantau kinerja pelayanan, statistik harian, dan aktivitas petugas secara Real-Time.
                        </p>
                    </div>

                    <div class="text-right hidden md:block bg-white/5 backdrop-blur-md border border-white/10 px-5 py-3 rounded-2xl">
                        <p class="text-3xl font-black text-[#F5C542]">
                            {{ \Carbon\Carbon::now('Asia/Makassar')->format('H:i') }} <span class="text-sm font-bold text-slate-400">WITA</span>
                        </p>
                        <p class="text-xs text-slate-300 font-bold uppercase tracking-wider mt-1">
                            {{ \Carbon\Carbon::now('Asia/Makassar')->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/10 relative group hover:bg-white/15 transition-all">
                        <p class="text-xs text-slate-300 uppercase tracking-wider font-bold mb-1">Total Permohonan</p>
                        <h3 class="text-4xl font-black text-white">{{ $stats['total_hari_ini'] }}</h3>
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">Data masuk hari ini</p>
                    </div>

                    <div class="bg-emerald-500/10 backdrop-blur-md p-6 rounded-2xl border border-emerald-500/20 relative group hover:bg-emerald-500/20 transition-all">
                        <p class="text-xs text-emerald-400 uppercase tracking-wider font-bold mb-1">Disetujui</p>
                        <h3 class="text-4xl font-black text-white">{{ $stats['disetujui'] }}</h3>
                        <p class="text-[10px] text-emerald-200/70 mt-2 font-medium">Izin diterbitkan</p>
                    </div>

                    <div class="bg-red-500/10 backdrop-blur-md p-6 rounded-2xl border border-red-500/20 relative group hover:bg-red-500/20 transition-all">
                        <p class="text-xs text-red-400 uppercase tracking-wider font-bold mb-1">Ditolak</p>
                        <h3 class="text-4xl font-black text-white">{{ $stats['ditolak'] }}</h3>
                        <p class="text-[10px] text-red-200/70 mt-2 font-medium">Berkas tidak lengkap</p>
                    </div>

                    <div class="bg-amber-500/10 backdrop-blur-md p-6 rounded-2xl border border-amber-500/20 relative group hover:bg-amber-500/20 transition-all">
                        <p class="text-xs text-amber-400 uppercase tracking-wider font-bold mb-1">Antrian</p>
                        <h3 class="text-4xl font-black text-white">{{ $stats['menunggu'] }}</h3>
                        <p class="text-[10px] text-amber-200/70 mt-2 font-medium">Menunggu Verifikasi Staff</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-6 py-10">

                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="bg-blue-50 text-blue-600 p-3 rounded-xl shadow-sm border border-blue-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-xl">Aktivitas Pelayanan</h3>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Pantau status permohonan terbaru secara real-time.</p>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('kepala.index') }}" class="w-full md:w-auto flex items-center gap-3">
                        <div class="relative w-full md:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                            </div>
                            <select name="filter" onchange="this.form.submit()" class="bg-slate-50 border border-slate-300 text-slate-700 text-xs font-bold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 shadow-sm cursor-pointer hover:bg-white transition-colors uppercase">
                                <option value="">📂 Tampilkan Semua</option>
                                <option value="menunggu" {{ request('filter') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                                <option value="disetujui" {{ request('filter') == 'disetujui' ? 'selected' : '' }}>✅ Disetujui</option>
                                <option value="ditolak" {{ request('filter') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4">Waktu Proses</th>
                                    <th class="px-6 py-4">Petugas Eksekutor</th>
                                    <th class="px-6 py-4">Pengunjung & Tujuan</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($terbaru as $item)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-700 text-base">
                                                {{ \Carbon\Carbon::parse($item->updated_at)->timezone('Asia/Makassar')->format('H:i') }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wide">
                                                {{ \Carbon\Carbon::parse($item->updated_at)->locale('id')->diffForHumans() }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-xs font-bold border border-slate-200 uppercase">
                                                {{ substr($item->petugas->name ?? 'S', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 text-xs uppercase group-hover:text-blue-600 transition-colors">
                                                    {{ $item->petugas->name ?? 'System Admin' }}
                                                </div>
                                                <div class="text-[10px] text-slate-400 font-medium">Verifikator Staff</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="font-bold text-slate-800 uppercase text-sm">{{ $item->nama_pengunjung }}</div>
                                            <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                                <span class="text-slate-400">Bertemu:</span>
                                                <span class="font-bold bg-slate-100 px-1.5 py-0.5 rounded text-[10px] text-slate-600 uppercase border border-slate-200">{{ $item->nama_tahanan }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'disetujui')
                                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase border border-emerald-100 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui
                                        </span>
                                        @elseif($item->status == 'ditolak')
                                        <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase border border-red-100 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase border border-amber-100 shadow-sm animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-slate-50 p-4 rounded-full mb-3 border border-slate-100">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium text-sm">Tidak ada data untuk kategori ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>