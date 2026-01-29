<x-app-layout>
    <div class="web-view min-h-screen bg-[#F1F5F9] font-sans pb-20 p-4 md:p-8">

        <div class="max-w-7xl mx-auto mb-6 flex flex-col md:flex-row justify-between items-end gap-4 print:hidden">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Laporan Evaluasi</h1>
                <p class="text-slate-500 text-sm">Data diurutkan berdasarkan Tanggal Kunjungan terbaru.</p>
            </div>

            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <form method="GET" action="{{ route('kepala.laporan.index') }}" class="flex-1">
                    <select name="status" onchange="this.form.submit()" class="w-full md:w-48 bg-white border border-slate-300 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 p-2.5 font-bold cursor-pointer shadow-sm">
                        <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>📂 Semua Data</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅ Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                    </select>
                </form>

                <a href="{{ route('kepala.laporan.preview', request()->all()) }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Preview Excel
                </a>

                <button onclick="window.print()" class="bg-[#0f172a] hover:bg-[#F5C542] hover:text-[#0f172a] text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print PDF
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden print:hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 w-10 text-center border-r border-slate-100">No</th>
                            <th class="px-6 py-4 w-32">Tanggal</th>
                            <th class="px-6 py-4">Pemohon</th>
                            <th class="px-6 py-4 w-32 text-center">Status</th>
                            <th class="px-6 py-4 bg-yellow-50/50 text-slate-700 w-48">Verifikator</th>
                            <th class="px-6 py-4 w-32">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data as $index => $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-center border-r border-slate-100">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-slate-700">
                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 uppercase">{{ $item->user->name ?? $item->nama_pengunjung }}</div>
                                <div class="text-xs text-slate-500">Tujuan: {{ $item->nama_tahanan }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->status == 'disetujui')
                                <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-[10px] font-bold uppercase border border-emerald-200">Disetujui</span>
                                @elseif($item->status == 'ditolak')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-[10px] font-bold uppercase border border-red-200">Ditolak</span>
                                @else
                                <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-[10px] font-bold uppercase border border-amber-200">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 bg-yellow-50/30 font-bold text-slate-700 uppercase italic">
                                {{ $item->petugas->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 font-mono">{{ $item->updated_at->format('H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">Tidak ada data untuk filter ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
                <h1>LAPORAN MONITORING & EVALUASI KUNJUNGAN</h1>
                <p>FILTER: {{ strtoupper(request('status') ?? 'SEMUA DATA') }}</p>
                <p class="tgl-cetak">Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WITA</p>
            </div>

            <table class="print-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">NO</th>
                        <th style="width: 15%;">TANGGAL</th>
                        <th>PEMOHON</th>
                        <th style="width: 10%;">STATUS</th>
                        <th>VERIFIKATOR</th>
                        <th style="width: 10%;">WAKTU</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td class="center">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                        <td class="uppercase bold">{{ $item->user->name ?? $item->nama_pengunjung }}</td>
                        <td class="center status-cell {{ $item->status }}">
                            {{ strtoupper($item->status) }}
                        </td>
                        <td class="center italic">{{ $item->petugas->name ?? '-' }}</td>
                        <td class="center">{{ $item->updated_at->format('H:i') }}</td>
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
                            <p class="jabatan">Kepala Kejaksaan Negeri,</p>
                            <div class="space-ttd"></div>
                            <p class="nama">H. FULAN, SH., MH.</p>
                            <p class="nip">NIP. 19800101 200001 1 001</p>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

    <style>
        #print-layer {
            display: none;
        }

        @media print {

            /* 1. Reset Kertas */
            @page {
                margin: 0;
                size: A4 portrait;
            }

            html,
            body {
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
                background: white !important;
            }

            /* 2. Sembunyikan Layout Web Utama */
            body>* {
                visibility: hidden;
            }

            /* 3. Tampilkan Hanya Layer Print */
            #print-layer,
            #print-layer * {
                visibility: visible !important;
            }

            /* 4. Posisikan Layer Print di Paling Atas */
            #print-layer {
                display: block !important;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                background-color: white;
                z-index: 9999;
            }

            /* Hapus elemen web */
            .web-view,
            nav,
            header,
            footer {
                display: none !important;
            }

            /* Styling Kertas A4 */
            .paper-a4 {
                width: 100%;
                margin: 0 auto;
                padding: 1cm 1.5cm;
                font-family: 'Times New Roman', serif;
                color: black;
                position: relative;
            }

            /* Watermark di tengah */
            .print-watermark {
                position: absolute;
                top: 300px;
                left: 50%;
                width: 350px;
                transform: translateX(-50%);
                opacity: 0.1;
                filter: grayscale(100%);
                z-index: -1;
            }

            /* Kop Surat */
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

            /* Judul */
            .judul-area {
                text-align: center;
                margin-bottom: 25px;
            }

            .judul-area h1 {
                font-size: 14pt;
                font-weight: bold;
                text-decoration: underline;
                margin: 0;
                text-transform: uppercase;
            }

            .judul-area p {
                font-size: 10pt;
                margin-top: 5px;
                font-weight: bold;
                text-transform: uppercase;
            }

            .tgl-cetak {
                font-size: 9pt;
                font-style: italic;
                font-weight: normal;
            }

            /* Tabel */
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

            .bold {
                font-weight: bold;
            }

            .italic {
                font-style: italic;
            }

            /* Tanda Tangan */
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
                font-weight: bold;
            }

            .nama {
                font-weight: bold;
                text-decoration: underline;
                text-transform: uppercase;
            }

            .nip {
                font-size: 10pt;
            }

            * {
                box-shadow: none !important;
                text-shadow: none !important;
            }
        }
    </style>
</x-app-layout>