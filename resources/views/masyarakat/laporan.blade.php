<x-app-layout>
    <div class="web-view min-h-screen bg-[#F1F5F9] font-sans pb-20">

        <div class="bg-[#1e293b] pt-10 pb-32 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10"></div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-yellow-500 font-bold text-xs uppercase tracking-widest">Area Masyarakat</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">
                            Riwayat & Tiket <br> Kunjungan Anda
                        </h1>
                        <p class="text-slate-400 mt-2 max-w-xl text-sm leading-relaxed">
                            Pantau status pengajuan, lihat detail jadwal, dan cetak tiket kunjungan Anda dalam satu tempat yang terpadu.
                        </p>
                    </div>

                    <button onclick="window.print()" class="group bg-[#F5C542] hover:bg-[#e0b134] text-[#1e293b] px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-yellow-500/20 transition-all flex items-center gap-3 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span>Cetak Laporan Lengkap</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 -mt-20 relative z-20">

            <div class="bg-white p-4 rounded-xl shadow-lg border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
                <div class="flex items-center gap-3 text-slate-600">
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Filter Data Kunjungan</h3>
                        <p class="text-xs text-slate-400">Menampilkan semua riwayat.</p>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-2 rounded-lg border border-slate-200 text-xs font-bold text-slate-500">
                    Total Data: {{ count($data) }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($data as $item)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('l') }}
                            </p>
                            <h3 class="text-xl font-black text-slate-800">
                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase">ID TIKET</span>
                            <span class="block text-lg font-mono font-bold text-blue-600">#{{ $item->id }}</span>
                        </div>
                    </div>

                    <div class="p-5 bg-slate-50/50">
                        <div class="mb-4">
                            @if($item->status == 'disetujui')
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100/50 border border-emerald-200 text-emerald-700 text-xs font-bold uppercase w-full justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Disetujui
                            </div>
                            @elseif($item->status == 'ditolak')
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-100/50 border border-red-200 text-red-700 text-xs font-bold uppercase w-full justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Ditolak
                            </div>
                            @else
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-100/50 border border-amber-200 text-amber-700 text-xs font-bold uppercase w-full justify-center">
                                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Menunggu Verifikasi
                            </div>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Tahanan
                                </span>
                                <span class="font-bold text-slate-800 uppercase">{{ $item->nama_tahanan }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Waktu
                                </span>
                                <span class="font-bold text-slate-800">{{ $item->jam_kunjungan }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-300">
                    <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada riwayat kunjungan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="print-layer">
        <div class="paper-a4">

            <img src="{{ asset('assets/logo-kejari.png') }}" class="print-watermark">

            <table class="kop-table">
                <tr>
                    <td class="logo-col">
                        <img src="{{ asset('assets/logo-kejari.png') }}">
                    </td>
                    <td class="text-col">
                        <div class="kop-1">KEJAKSAAN REPUBLIK INDONESIA</div>
                        <div class="kop-2">KEJAKSAAN TINGGI KALIMANTAN SELATAN</div>
                        <div class="kop-3">KEJAKSAAN NEGERI BANJARMASIN</div>
                        <div class="kop-alamat">Jl. Brig Jend. Hasan Basri No.3, Pangeran, Kota Banjarmasin, Kalimantan Selatan 70124</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="garis-bawah"></td>
                </tr>
            </table>

            <div class="judul-area">
                <h1>LAPORAN REKAPITULASI KUNJUNGAN</h1>
                <p>PELAPOR: {{ strtoupper(Auth::user()->name) }}</p>
            </div>

            <table class="print-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">NO</th>
                        <th style="width: 15%;">TANGGAL</th>
                        <th style="width: 10%;">ID TIKET</th>
                        <th>TAHANAN TUJUAN</th>
                        <th style="width: 10%;">JML</th>
                        <th style="width: 15%;">JAM</th>
                        <th style="width: 15%;">STATUS</th>
                        <th style="width: 15%;">PETUGAS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td class="center">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                        <td class="center font-bold">#{{ $item->id }}</td>
                        <td class="uppercase" style="text-align: left; padding-left: 8px;">{{ $item->nama_tahanan }}</td>
                        <td class="center">{{ $item->jumlah_pengikut ?? 1 }}</td>
                        <td class="center" style="font-size: 9pt;">{{ $item->jam_kunjungan }}</td>
                        <td class="center status-cell {{ $item->status }}">
                            {{ strtoupper($item->status) }}
                        </td>
                        <td class="center italic">{{ $item->petugas->name ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="ttd-area">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 60%;"></td>
                        <td class="ttd-box">
                            <p>Banjarmasin, {{ date('d F Y') }}</p>
                            <p class="jabatan">Pemohon / Pelapor,</p>
                            <div class="space-ttd"></div>
                            <p class="nama">{{ strtoupper(Auth::user()->name) }}</p>
                            <p class="nip">Masyarakat</p>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

    <style>
        /* Sembunyikan Layer Print di Layar Biasa */
        #print-layer {
            display: none;
        }

        @media print {

            /* 1. HAPUS HEADER/FOOTER BROWSER (KUNCI UTAMA) */
            @page {
                margin: 0;
                size: A4 portrait;
            }

            /* 2. RESET MARGIN BODY */
            body {
                margin: 0;
                padding: 0;
                background-color: white;
            }

            /* 3. TAMPILKAN PRINT LAYER */
            #print-layer {
                display: block !important;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 9999;
                /* Pastikan background putih menutupi segalanya */
                background: white;
            }

            /* 4. ATUR PADDING KERTAS MANUAL (Pengganti Margin @page) */
            .paper-a4 {
                width: 100%;
                /* Padding ini yang memberi jarak aman dari tepi kertas */
                padding: 1.5cm 2cm;
                font-family: 'Times New Roman', serif;
                position: relative;
            }

            /* Sembunyikan Tampilan Web */
            .web-view,
            nav,
            header,
            footer {
                display: none !important;
            }

            /* Style Elemen Surat */
            .print-watermark {
                position: absolute;
                top: 350px;
                left: 50%;
                width: 350px;
                transform: translateX(-50%);
                opacity: 0.1;
                filter: grayscale(100%);
                z-index: -1;
            }

            .kop-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            .logo-col {
                width: 15%;
                text-align: center;
                vertical-align: middle;
            }

            .logo-col img {
                width: 90px;
                height: auto;
            }

            .text-col {
                text-align: center;
                vertical-align: middle;
                padding-left: 10px;
            }

            .kop-1 {
                font-size: 14pt;
                font-weight: bold;
            }

            .kop-2 {
                font-size: 16pt;
                font-weight: bold;
            }

            .kop-3 {
                font-size: 18pt;
                font-weight: 900;
                color: #166534;
                -webkit-print-color-adjust: exact;
            }

            .kop-alamat {
                font-size: 10pt;
                font-style: italic;
                margin-top: 5px;
            }

            .garis-bawah {
                border-top: 4px double black;
                height: 5px;
                margin-top: 10px;
            }

            .judul-area {
                text-align: center;
                margin-bottom: 25px;
            }

            .judul-area h1 {
                font-size: 14pt;
                font-weight: bold;
                text-decoration: underline;
                margin: 0;
            }

            .judul-area p {
                font-size: 10pt;
                font-weight: bold;
                margin-top: 5px;
                text-transform: uppercase;
            }

            .print-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 10pt;
            }

            .print-table th,
            .print-table td {
                border: 1px solid black;
                padding: 6px;
            }

            .print-table thead th {
                background-color: #e5e5e5 !important;
                font-weight: bold;
                text-align: center;
                -webkit-print-color-adjust: exact;
            }

            .center {
                text-align: center;
            }

            .uppercase {
                text-transform: uppercase;
            }

            .italic {
                font-style: italic;
            }

            .ttd-area {
                margin-top: 50px;
                page-break-inside: avoid;
            }

            .ttd-box {
                text-align: center;
                width: 40%;
            }

            .jabatan {
                margin-bottom: 70px;
            }

            .nama {
                font-weight: bold;
                text-decoration: underline;
            }

            * {
                box-shadow: none !important;
                text-shadow: none !important;
            }
        }
    </style>
</x-app-layout>