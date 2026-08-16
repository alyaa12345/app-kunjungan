<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-white pt-6 pb-8 overflow-hidden">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-40 h-40 rounded-full bg-blue-50 opacity-60 blur-3xl"></div>
            <div class="absolute bottom-0 left-10 w-24 h-24 rounded-full bg-emerald-50 opacity-60 blur-2xl"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="bg-slate-900 text-[#F5C542] text-[10px] font-extrabold px-3 py-1.5 rounded-md tracking-widest uppercase shadow-sm mb-3 inline-block">
                        Database Kejaksaan & Lapas
                    </span>
                    <h2 class="font-black text-3xl text-slate-800 tracking-tight leading-tight">
                        Arsip & Riwayat Kunjungan
                    </h2>
                    <p class="text-sm text-slate-500 font-medium mt-1.5">
                        Daftar riwayat dan keputusan administrasi permohonan kunjungan masyarakat.
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-5 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] border border-slate-100 relative z-10">
                <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row items-center gap-4">
                    
                    <div class="w-full md:w-1/3 relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="cari" value="{{ request('cari') }}" class="pl-11 pr-4 py-2.5 w-full border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 text-sm bg-slate-50 focus:bg-white transition-all outline-none" placeholder="Cari Nama Pengunjung...">
                    </div>

                    <div class="w-full md:w-1/4 relative">
                        <select name="bulan" onchange="this.form.submit()" class="pl-4 pr-10 py-2.5 w-full appearance-none border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 transition-colors outline-none cursor-pointer">
                            <option value="">Semua Bulan</option>
                            <option value="01" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ request('bulan') == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <div class="w-full md:w-1/4 relative">
                        <select name="status" onchange="this.form.submit()" class="pl-4 pr-10 py-2.5 w-full appearance-none border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-100 focus:border-blue-500 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 transition-colors outline-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅ Diterima / Disetujui</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>🏁 Selesai Hadir</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <div class="w-full md:w-auto flex flex-1 justify-end gap-2">
                        @if(request('cari') || request('bulan') || request('status'))
                            <a href="{{ url()->current() }}" class="px-5 py-2.5 bg-rose-50 hover:bg-rose-500 text-rose-600 hover:text-white border border-rose-100 rounded-xl font-bold text-sm transition-all flex items-center gap-2 group shadow-sm">
                                <svg class="w-4 h-4 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Reset
                            </a>
                        @endif
                        <button type="submit" class="hidden md:inline-flex px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-sm shadow-md transition-all items-center gap-2">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-3xl shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-white">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-6 bg-blue-500 rounded-full"></div>
                        <h3 class="text-lg font-extrabold text-slate-800">Catatan Dokumen Masuk</h3>
                    </div>
                    <span class="bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold px-3 py-1 rounded-lg">
                        {{ $riwayat->count() }} Data Ditemukan
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="bg-slate-50/80 text-slate-500 text-[10px] uppercase font-extrabold tracking-widest border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-5">Identitas Pengunjung</th>
                                <th class="px-6 py-5">Tujuan (Tahanan)</th>
                                <th class="px-6 py-5">Waktu Kunjungan</th>
                                <th class="px-6 py-5 text-center">Status Legalitas</th>
                                <th class="px-6 py-5">Keterangan / Alasan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($riwayat as $r)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-200 flex items-center justify-center font-black text-slate-500 shrink-0 group-hover:from-blue-100 group-hover:to-blue-200 group-hover:text-blue-700 transition-colors">
                                            {{ strtoupper(substr($r->nama_pengunjung, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-800 uppercase text-[13px]">{{ $r->nama_pengunjung }}</div>
                                            <div class="text-[11px] font-medium text-slate-400 mt-0.5">NIK: <span class="text-slate-500">{{ $r->nik_pengunjung ?? '-' }}</span></div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="inline-flex items-center gap-2 py-1.5 px-3 rounded-lg bg-white border border-slate-200 shadow-sm">
                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-400"></div>
                                        <span class="font-bold text-xs text-slate-700">{{ strtoupper($r->nama_tahanan) }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->translatedFormat('d M Y') }}</div>
                                    <div class="text-[11px] font-medium text-slate-400 mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        SESI {{ strtoupper($r->sesi_kunjungan ?? '-') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if(strtolower($r->status) == 'disetujui' || strtolower($r->status) == 'diterima')
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            DISETUJUI
                                        </div>
                                    @elseif(strtolower($r->status) == 'selesai')
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                            SELESAI HADIR
                                        </div>
                                    @elseif(strtolower($r->status) == 'ditolak')
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-rose-50 text-rose-700 border border-rose-200 shadow-sm">
                                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            DITOLAK
                                        </div>
                                    @else
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-600 border border-slate-200 shadow-sm">
                                            {{ $r->status }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @if($r->alasan_penolakan)
                                        <div class="text-xs font-medium text-rose-600 bg-rose-50/50 p-2.5 rounded-lg border border-rose-100 max-w-xs leading-relaxed">
                                            "{{ $r->alasan_penolakan }}"
                                        </div>
                                    @else
                                        <div class="text-xs italic text-slate-400">Tidak ada catatan</div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 border border-slate-100 mb-5 shadow-sm">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-slate-700 text-lg">Arsip Kosong</h4>
                                    <p class="text-slate-400 font-medium text-sm mt-1">Belum ada riwayat dokumen yang cocok dengan filter Anda.</p>
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