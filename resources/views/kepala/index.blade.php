<x-app-layout>
    <div class="min-h-screen bg-[#F8FAFC] pb-10">

        <div class="bg-[#0f172a] text-white pt-8 pb-24 rounded-b-[3rem] shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 opacity-10 transform translate-x-10 -translate-y-10">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <h1 class="text-2xl font-bold text-[#F5C542]">Dashboard Monitoring</h1>
                <p class="text-slate-400 text-sm mt-1">Pantau kinerja pelayanan kunjungan secara Real-Time.</p>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                    <div class="bg-white/10 backdrop-blur-sm p-4 rounded-2xl border border-white/10">
                        <div class="text-xs text-slate-300 uppercase tracking-wider font-bold">Total Hari Ini</div>
                        <div class="text-3xl font-bold mt-1">{{ $stats['total_hari_ini'] }}</div>
                        <div class="text-[10px] text-slate-400 mt-2">Permohonan Masuk</div>
                    </div>
                    <div class="bg-emerald-500/20 backdrop-blur-sm p-4 rounded-2xl border border-emerald-500/30">
                        <div class="text-xs text-emerald-300 uppercase tracking-wider font-bold">Disetujui Petugas</div>
                        <div class="text-3xl font-bold mt-1 text-emerald-400">{{ $stats['disetujui'] }}</div>
                        <div class="text-[10px] text-emerald-200/70 mt-2">Izin Diterbitkan</div>
                    </div>
                    <div class="bg-red-500/20 backdrop-blur-sm p-4 rounded-2xl border border-red-500/30">
                        <div class="text-xs text-red-300 uppercase tracking-wider font-bold">Ditolak</div>
                        <div class="text-3xl font-bold mt-1 text-red-400">{{ $stats['ditolak'] }}</div>
                        <div class="text-[10px] text-red-200/70 mt-2">Masalah Berkas/Lainnya</div>
                    </div>
                    <div class="bg-amber-500/20 backdrop-blur-sm p-4 rounded-2xl border border-amber-500/30">
                        <div class="text-xs text-amber-300 uppercase tracking-wider font-bold">Antrian</div>
                        <div class="text-3xl font-bold mt-1 text-amber-400">{{ $stats['menunggu'] }}</div>
                        <div class="text-[10px] text-amber-200/70 mt-2">Belum Diproses Staff</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 -mt-12 relative z-20">
            <div class="bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Aktivitas Pelayanan Terbaru</h3>
                        <p class="text-xs text-slate-500">5 Transaksi terakhir yang diproses oleh Staff.</p>
                    </div>
                    <a href="{{ route('kepala.laporan') }}" class="text-xs font-bold text-[#0f172a] hover:text-[#F5C542] flex items-center gap-1 transition">
                        Lihat Semua Arsip &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-100 text-slate-500 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Waktu Proses</th>
                                <th class="px-6 py-4">Petugas Eksekutor</th>
                                <th class="px-6 py-4">Pengunjung</th>
                                <th class="px-6 py-4">Keputusan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($terbaru as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-700">{{ $item->updated_at->format('H:i') }}</div>
                                    <div class="text-xs text-slate-400">{{ $item->updated_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600">
                                            ST
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 text-xs uppercase">Staff Admin</div>
                                            <div class="text-[10px] text-slate-400">Verifikator</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-800">{{ $item->nama_pengunjung }}</div>
                                    <div class="text-xs text-slate-500">Tujuan: {{ $item->nama_tahanan }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'disetujui')
                                    <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase border border-emerald-200">
                                        Disetujui
                                    </span>
                                    @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase border border-red-200">
                                        Ditolak
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-sm">
                                    Belum ada aktivitas pelayanan hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>