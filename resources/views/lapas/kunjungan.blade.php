<x-app-layout>
    <x-slot name="style">
        <style>
            /* Konfigurasi Khusus Kertas Cetak */
            @media print {
                @page { 
                    size: A4 portrait; 
                    margin: 1.5cm;
                }
                
                body, html, main, .min-h-screen {
                    background-color: #ffffff !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    font-family: 'Times New Roman', Times, serif !important;
                }

                .print\:hidden, nav, header {
                    display: none !important;
                }

                .print-area {
                    width: 100% !important;
                    box-shadow: none !important;
                    border: none !important;
                }

                .kop-garis-resmi {
                    border-bottom: 3px solid black !important;
                    position: relative;
                    margin-top: 15px !important;
                    margin-bottom: 25px !important;
                }
                .kop-garis-resmi::after {
                    content: "";
                    position: absolute;
                    bottom: -3px;
                    left: 0;
                    width: 100%;
                    border-bottom: 1px solid black !important;
                }

                table.print-table {
                    width: 100% !important;
                    border-collapse: collapse !important;
                    margin-top: 15px !important;
                    font-family: Arial, Helvetica, sans-serif !important;
                }
                table.print-table th, table.print-table td {
                    border: 1px solid #000 !important;
                    color: #000 !important;
                    padding: 10px 8px !important;
                    font-size: 12px !important;
                    vertical-align: middle !important;
                }
                table.print-table th {
                    text-align: center !important;
                    font-weight: bold !important;
                    background-color: #f3f4f6 !important;
                    -webkit-print-color-adjust: exact;
                    color-adjust: exact;
                }
                
                .avoid-break { 
                    page-break-inside: avoid !important; 
                }
            }
        </style>
    </x-slot>

    <x-slot name="header">
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 bg-white pt-2 pb-4 print:hidden">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold tracking-widest uppercase mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Pos Penjagaan
                </div>
                <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                    Daftar Kunjungan Tatap Muka
                </h2>
                <p class="text-sm text-slate-500 font-medium mt-1.5">
                    Kelola daftar pengunjung yang telah memiliki izin masuk (ACC).
                </p>
            </div>
            
            <div class="w-full xl:w-auto flex flex-col sm:flex-row items-center gap-3">
                <form action="{{ route('lapas.kunjungan') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-3">
                    <div class="relative w-full sm:w-auto group">
                        <select name="filter" onchange="this.form.submit()" class="pl-4 pr-10 py-2.5 w-full sm:w-auto appearance-none border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-slate-100 transition-colors outline-none cursor-pointer shadow-sm">
                            <option value="">Semua Waktu</option>
                            <option value="hari_ini" {{ request('filter') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="minggu_ini" {{ request('filter') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="bulan_ini" {{ request('filter') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400 group-hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <div class="relative w-full sm:w-72 group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="cari" value="{{ request('cari') }}" class="pl-10 pr-4 py-2.5 w-full border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white shadow-sm outline-none transition-all placeholder:text-slate-400" placeholder="Cari pengunjung / tahanan...">
                    </div>
                </form>

                <button onclick="window.print()" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-all flex items-center justify-center gap-2 whitespace-nowrap shadow-md hover:shadow-lg active:scale-95">
                    <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Laporan
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 bg-slate-50 min-h-screen print:bg-white print:py-0 print:min-h-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 print:max-w-full print:px-0">
            
            <div class="print-area bg-white sm:rounded-2xl shadow-sm border-y sm:border border-slate-200 overflow-hidden">
                
                <div class="px-6 py-5 border-b border-slate-100 print:hidden flex items-center justify-between bg-white">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-3">
                        <span class="flex h-6 w-1.5 bg-indigo-500 rounded-full"></span>
                        Antrean Masuk Kunjungan
                    </h3>
                    <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1 rounded-lg">Total: {{ $kunjungans->total() }} Data</span>
                </div>

                <div class="hidden print:block mx-8 pt-8">
                    <div class="flex items-center justify-start pb-2">
                        <div class="w-[80px] h-[80px] mr-6 shrink-0">
                            <img src="{{ asset('assets/logo-kejari.png') }}" class="print-watermark" alt="Watermark">
                        </div>
                        
                        <div class="text-center flex-1 pr-[80px]">
                            <h3 class="text-[14px] font-bold tracking-tight text-black leading-tight uppercase">Kementerian Hukum dan Hak Asasi Manusia RI</h3>
                            <h2 class="text-[18px] font-bold tracking-wide text-black mt-1 leading-tight uppercase">Rumah Tahanan Negara Kelas IIA</h2>
                            <h1 class="text-[20px] font-black tracking-wider text-black mt-1 leading-tight uppercase">Banjarmasin</h1>
                            <p class="text-[12px] text-black mt-2 leading-none font-sans">Jl. Letjen Suprapto No.1, Antasan Besar, Kec. Banjarmasin Tengah, Kalimantan Selatan 70114</p>
                        </div>
                    </div>
                    <div class="kop-garis-resmi"></div>
                </div>

                <div class="text-center mb-6 hidden print:block">
                    <h4 class="text-[16px] font-bold underline uppercase text-black">LAPORAN KUNJUNGAN TATAP MUKA</h4>
                    <p class="text-[12px] text-black mt-1 font-sans">Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                </div>

                @if($kunjungans->isEmpty())
                <div class="p-16 flex flex-col items-center justify-center text-center bg-slate-50/50 print:bg-white">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4 print:hidden">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <p class="text-base font-semibold text-slate-600 print:text-black">Belum Ada Antrean Kunjungan</p>
                    <p class="text-sm text-slate-400 mt-1 print:hidden">Pengunjung yang disetujui akan muncul di sini.</p>
                </div>
                @else
                <div class="overflow-x-auto print:mx-8 print:pb-4">
                    <table class="w-full text-left print-table">
                        <thead class="print:hidden bg-slate-50/80 border-b border-slate-200">
                            <tr>
                                <th class="py-3.5 pl-6 pr-4 text-xs text-slate-500 font-bold uppercase tracking-wider w-16">No</th>
                                <th class="py-3.5 px-4 text-xs text-slate-500 font-bold uppercase tracking-wider">Identitas Pengunjung</th>
                                <th class="py-3.5 px-4 text-xs text-slate-500 font-bold uppercase tracking-wider">Tujuan (Warga Binaan)</th>
                                <th class="py-3.5 px-4 text-xs text-slate-500 font-bold uppercase tracking-wider text-center">Status</th>
                                <th class="py-3.5 px-6 text-xs text-slate-500 font-bold uppercase tracking-wider text-right w-32">Aksi</th>
                            </tr>
                        </thead>
                        
                        <thead class="hidden print:table-header-group">
                            <tr>
                                <th class="w-12">No.</th>
                                <th>Nama Pengunjung & Sesi</th>
                                <th>Tujuan (Warga Binaan)</th>
                                <th class="w-32">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 print:divide-y-0 bg-white">
                            @foreach($kunjungans as $index => $item)
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                <td class="py-4 pl-6 pr-4 text-sm font-medium text-slate-500 print:text-black print:text-center print:p-2 print:border">
                                    {{ $kunjungans->firstItem() + $index }}
                                </td>
                                
                                <td class="py-4 px-4 print:p-2 print:border">
                                    <div class="font-bold text-slate-800 text-sm print:text-black print:text-sm">{{ strtoupper($item->nama_pengunjung) }}</div>
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1 print:text-black print:mt-0.5">
                                        <svg class="w-3.5 h-3.5 print:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d M Y') }} 
                                        <span class="text-slate-300 print:text-black mx-0.5">|</span> 
                                        <span class="font-bold text-indigo-600 print:text-black">SESI {{ strtoupper($item->jam_kunjungan) }}</span>
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4 print:p-2 print:border">
                                    <div class="font-bold text-slate-800 text-sm print:text-black">{{ strtoupper($item->nama_tahanan) }}</div>
                                </td>
                                
                                <td class="py-4 px-4 text-center print:p-2 print:border">
                                    <div class="print:hidden flex justify-center">
                                        @if($item->status == 'disetujui')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200/60 uppercase tracking-wide">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/60 uppercase tracking-wide">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Hadir
                                            </span>
                                        @endif
                                    </div>
                                    <div class="hidden print:block font-bold text-[12px]">
                                        {{ $item->status == 'disetujui' ? 'BELUM HADIR' : 'HADIR' }}
                                    </div>
                                </td>
                                
                                <td class="py-4 px-6 text-right print:hidden">
                                    @if($item->status == 'disetujui')
                                    <a href="{{ url('lapas/gate-check?tiket_id='.$item->id) }}" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm hover:shadow focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Proses Masuk
                                        <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                    @else
                                    <span class="inline-flex items-center justify-center text-slate-400 text-xs font-bold px-4 py-2.5 bg-slate-50 rounded-lg border border-slate-100">
                                        Selesai
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($kunjungans->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 print:hidden bg-slate-50/50">
                    {{ $kunjungans->links() }}
                </div>
                @endif
                
                @endif

                <div class="hidden print:block mt-12 mx-8 pb-12 avoid-break">
                    <div class="flex justify-end">
                        <div class="text-center w-[280px]">
                            <p class="text-[12px] text-black font-sans">Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            <p class="text-[12px] text-black mt-0.5 font-bold">Petugas Jaga Pos Utama</p>
                            
                            <div class="h-24"></div>
                            
                            <p class="text-[12px] font-bold text-black border-b border-black inline-block min-w-[200px] pb-1">
                                ( .................................................... )
                            </p>
                            <p class="text-[12px] text-black mt-1 font-sans">NIP. ........................................</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>