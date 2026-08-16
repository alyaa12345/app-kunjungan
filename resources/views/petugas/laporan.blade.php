<x-app-layout>
    <x-slot name="style">
        <style>
            @media print {
                /* 1. Usaha maksimal untuk membunuh header/footer browser dari kode */
                @page { 
                    size: A4 portrait; 
                    margin: 0 !important; 
                }
                
                body, html {
                    margin: 0 !important;
                    padding: 0 !important;
                    background-color: white !important;
                }

                /* 2. Sembunyikan PAKSA semua elemen layout bawaan Laravel/Breeze/Jetstream */
                nav, header, footer, aside, .min-h-screen > nav, header.bg-white, header.shadow { 
                    display: none !important; 
                }

                /* 3. Sembunyikan elemen dengan class print:hidden (seperti tombol dan form filter) */
                .print\:hidden { 
                    display: none !important; 
                }

                /* 4. Format khusus area yang HANYA BOLEH DICETAK */
                #area-cetak {
                    display: block !important;
                    padding: 1.5cm 2cm !important; /* Jarak aman kertas */
                    width: 100%;
                    -webkit-print-color-adjust: exact; 
                    print-color-adjust: exact;
                }
                
                /* Mencegah tabel terpotong jelek */
                table { page-break-inside: auto; }
                tr { page-break-inside: avoid; page-break-after: auto; }
                .signature-area { page-break-inside: avoid; }
            }
        </style>
    </x-slot>

    <x-slot name="header">
        <div class="relative bg-white pt-6 pb-8 overflow-hidden border-b border-slate-100 print:hidden">
            <div class="absolute top-0 right-0 -mr-12 -mt-12 w-48 h-48 rounded-full bg-indigo-50 opacity-60 blur-3xl"></div>
            <div class="absolute bottom-0 left-10 w-32 h-32 rounded-full bg-emerald-50 opacity-60 blur-2xl"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-5">
                <div>
                    <span class="bg-gradient-to-r from-slate-900 to-slate-700 text-[#F5C542] text-[10px] font-extrabold px-3 py-1.5 rounded-md tracking-widest uppercase shadow-sm mb-3 inline-block">
                        Pusat Informasi Ekspor
                    </span>
                    <h2 class="font-black text-3xl text-slate-800 tracking-tight leading-tight">
                        Laporan Pelayanan
                    </h2>
                    <p class="text-sm text-slate-500 font-medium mt-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $title ?? 'Rekapitulasi Laporan' }}
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <button onclick="window.print()" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak PDF
                    </button>

                    <a href="{{ route('petugas.laporan.excel', ['action' => 'download'] + request()->all()) }}" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white hover:text-[#F5C542] px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 group">
                        <svg class="w-5 h-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l4 4a1 1 0 01.586 1.414V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Unduh Rekap (.xls)
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen print:bg-white print:py-0 print:min-h-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 print:space-y-0 print:max-w-full print:px-0">

            <div class="bg-white p-5 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.05)] border border-slate-100 print:hidden">
                <div class="flex items-center gap-2 mb-4 px-1">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    <h3 class="text-xs font-extrabold text-slate-600 uppercase tracking-wide">Penyaringan Dokumen</h3>
                </div>
                
                <form action="{{ route('petugas.laporan.statistik') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4">
                    
                    <div class="w-full md:w-1/3 relative">
                        <label class="sr-only">Periode Laporan</label>
                        <select name="filter_type" onchange="this.form.submit()" class="pl-4 pr-10 py-3 w-full appearance-none border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 transition-colors outline-none cursor-pointer">
                            <option value="harian" {{ request('filter_type') == 'harian' ? 'selected' : '' }}>Rekap Harian (Hari Ini)</option>
                            <option value="bulanan" {{ request('filter_type') == 'bulanan' ? 'selected' : '' }}>Rekap Bulanan</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <div class="w-full md:w-1/3 relative">
                        <label class="sr-only">Status Validasi</label>
                        <select name="status" onchange="this.form.submit()" class="pl-4 pr-10 py-3 w-full appearance-none border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 text-sm font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 transition-colors outline-none cursor-pointer">
                            <option value="semua">Semua Status Dokumen</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅ Dokumen Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Dokumen Ditolak</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>🏁 Dokumen Selesai</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <div class="w-full md:w-auto flex justify-end gap-2 flex-1">
                        @if(request('filter_type') || request('status'))
                        <a href="{{ route('petugas.laporan.statistik') }}" class="px-5 py-3 bg-rose-50 hover:bg-rose-500 text-rose-600 hover:text-white border border-rose-100 rounded-xl font-bold text-sm transition-all flex items-center gap-2 group shadow-sm">
                            <svg class="w-4 h-4 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset Filter
                        </a>
                        @endif
                        <button type="submit" class="hidden md:inline-flex px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-xl font-bold text-sm shadow-sm transition-all items-center gap-2">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-3xl shadow-[0_2px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden print:border-none print:shadow-none print:rounded-none">
                
                <div class="p-6 border-b border-slate-100 flex items-center justify-between print:hidden">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                        <h3 class="text-lg font-extrabold text-slate-800">Detail Rekapitulasi Laporan</h3>
                    </div>
                    <span class="bg-slate-50 border border-slate-200 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-lg">
                        Total {{ count($laporan_detail) }} Baris
                    </span>
                </div>

                <div id="area-cetak">
                    
                    <div class="hidden print:block mb-6 w-full">
                        <div class="flex items-center justify-between">
                            <div class="w-24 flex-shrink-0 text-center">
                                <img src="{{ asset('assets/logo-kejari.png') }}" class="w-20 h-auto mx-auto object-contain" alt="Logo Kejaksaan">
                            </div>
                            <div class="text-center flex-1 px-4">
                                <h3 class="text-sm font-bold tracking-tight text-black">KEJAKSAAN REPUBLIK INDONESIA</h3>
                                <h2 class="text-base font-extrabold tracking-wide text-black mt-0.5">KEJAKSAAN TINGGI KALIMANTAN SELATAN</h2>
                                <h1 class="text-lg font-black tracking-wider text-black mt-0.5">KEJAKSAAN NEGERI BANJARMASIN</h1>
                                <p class="text-[11px] mt-1 text-black">Jl. Brigjen H. Hasan Basri No.3, Banjarmasin Utara, Kota Banjarmasin, Kalimantan Selatan 70124</p>
                            </div>
                            <div class="w-24 flex-shrink-0"></div> 
                        </div>
                        
                        <hr class="border-black border-[1.5px] mt-3 mb-[2px]">
                        <hr class="border-black border-[0.5px] mb-5">

                        <div class="text-center my-6">
                            <h4 class="text-base font-extrabold underline uppercase text-black">LAPORAN PELAYANAN / KUNJUNGAN</h4>
                            <p class="text-xs mt-1 text-black">Periode / Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto print:overflow-visible">
                        <table class="w-full text-sm text-left text-slate-600 print:text-black print:border-collapse print:border print:border-black">
                            <thead class="bg-slate-50/80 text-slate-400 text-[10px] uppercase font-extrabold tracking-widest border-b border-slate-100 print:bg-transparent print:text-black print:border-b-2 print:border-black text-center">
                                <tr>
                                    <th class="px-6 py-5 print:px-3 print:py-2 print:border print:border-black w-16 text-center">No</th>
                                    <th class="px-6 py-5 print:px-3 print:py-2 print:border print:border-black text-left">Identitas Pengunjung</th>
                                    <th class="px-6 py-5 print:px-3 print:py-2 print:border print:border-black">Hubungan</th>
                                    <th class="px-6 py-5 print:px-3 print:py-2 print:border print:border-black text-left">Warga Binaan Tujuan</th>
                                    <th class="px-6 py-5 print:px-3 print:py-2 print:border print:border-black text-center">Status Validasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 print:divide-black">
                                @forelse($laporan_detail as $index => $ld)
                                <tr class="hover:bg-indigo-50/30 transition-colors group print:hover:bg-transparent">
                                    <td class="px-6 py-4 print:px-3 print:py-2 print:border print:border-black font-bold text-slate-400 print:text-black text-center">
                                        {{ $index + 1 }}
                                    </td>
                                    
                                    <td class="px-6 py-4 print:px-3 print:py-2 print:border print:border-black">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-200 flex items-center justify-center font-black text-slate-500 shrink-0 group-hover:from-indigo-100 group-hover:to-indigo-200 group-hover:text-indigo-700 transition-colors print:hidden">
                                                {{ strtoupper(substr($ld->nama_pengunjung, 0, 1)) }}
                                            </div>
                                            <div class="font-extrabold text-slate-800 print:text-black uppercase text-[13px] tracking-wide">{{ $ld->nama_pengunjung }}</div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 print:px-3 print:py-2 print:border print:border-black text-center">
                                        <span class="inline-block bg-slate-50 border border-slate-200 text-slate-500 text-xs font-bold px-2.5 py-1 rounded-md print:bg-transparent print:border-none print:p-0 print:text-black">
                                            {{ $ld->hubungan_tahanan }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 print:px-3 print:py-2 print:border print:border-black">
                                        <div class="font-bold text-slate-700 print:text-black">{{ strtoupper($ld->nama_tahanan) }}</div>
                                    </td>

                                    <td class="px-6 py-4 print:px-3 print:py-2 print:border print:border-black text-center">
                                        @if(strtolower($ld->status) == 'disetujui')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm uppercase tracking-wider print:hidden">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            DISETUJUI
                                        </span>
                                        @elseif(strtolower($ld->status) == 'ditolak')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold rounded-full bg-rose-50 text-rose-700 border border-rose-200 shadow-sm uppercase tracking-wider print:hidden">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            DITOLAK
                                        </span>
                                        @elseif(strtolower($ld->status) == 'selesai')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-200 shadow-sm uppercase tracking-wider print:hidden">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            SELESAI
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-bold rounded-full bg-slate-100 text-slate-600 border border-slate-200 shadow-sm uppercase tracking-wider print:hidden">
                                            {{ strtoupper($ld->status) }}
                                        </span>
                                        @endif
                                        
                                        <span class="hidden print:inline font-bold text-black uppercase text-xs">
                                            {{ strtoupper($ld->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 print:py-6 print:border print:border-black text-center">
                                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 border border-slate-100 mb-5 shadow-sm print:hidden">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="font-bold text-slate-700 text-lg print:hidden">Laporan Kosong</h4>
                                        <p class="text-slate-400 font-medium text-sm mt-1 print:hidden">Data laporan sesuai penyaringan tidak ditemukan.</p>
                                        <span class="hidden print:block text-black font-bold">Tidak ada data.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="hidden print:block mt-12 pb-10 signature-area">
                        <div class="flex justify-end pr-10">
                            <div class="text-center w-64">
                                <p class="text-sm text-black">Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                                <p class="text-sm font-bold mt-1 text-black">Mengetahui,</p>
                                <p class="text-sm font-bold text-black">Kepala Seksi Intelijen</p>
                                
                                <div class="h-20"></div>

                                <p class="text-sm font-bold underline text-black">( .................................................... )</p>
                                <p class="text-xs mt-1 text-black text-left pl-6">NIP. </p>
                            </div>
                        </div>
                    </div>

                </div>
                </div>

        </div>
    </div>
</x-app-layout>