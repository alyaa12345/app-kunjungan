<x-app-layout>
    @php
        // Definisikan daftar bulan untuk komponen filter & cetak
        $daftar_bulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $tahun_sekarang = date('Y');
    @endphp

    <div class="min-h-screen bg-slate-50/50 py-8 px-4 sm:px-6 lg:px-8 print:hidden font-sans">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- Header & Filter Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
                <!-- Info Title -->
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-xl border border-blue-100 text-blue-600 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Laporan Evaluasi</h1>
                        <p class="text-slate-500 text-sm mt-0.5">Monitoring data kunjungan berkala dan validasi status.</p>
                    </div>
                </div>

                <!-- Action Controls (Filters & Buttons) -->
                <div class="flex flex-col md:flex-row items-stretch md:items-center gap-4 w-full xl:w-auto">
                    <!-- Form Filter -->
                    <form method="GET" action="{{ route('kepala.laporan.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-2 w-full xl:w-auto">
                        <!-- Filter Status -->
                        <div>
                            <select name="status" onchange="this.form.submit()" class="w-full xl:w-44 h-10 bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 px-3 font-medium cursor-pointer transition-all hover:bg-slate-100">
                                <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <!-- Filter Bulan -->
                        <div>
                            <select name="bulan" onchange="this.form.submit()" class="w-full xl:w-44 h-10 bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 px-3 font-medium cursor-pointer transition-all hover:bg-slate-100">
                                <option value="">Semua Bulan</option>
                                @foreach($daftar_bulan as $key => $val)
                                    <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tahun -->
                        <div>
                            <select name="tahun" onchange="this.form.submit()" class="w-full xl:w-36 h-10 bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 px-3 font-medium cursor-pointer transition-all hover:bg-slate-100">
                                <option value="">Semua Tahun</option>
                                @for($i = $tahun_sekarang; $i >= $tahun_sekarang - 4; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </form>

                    <!-- Tombol Ekspor -->
                    <div class="flex gap-2 min-w-[240px] md:w-auto">
                        <a href="{{ route('kepala.laporan.preview', request()->all()) }}" class="flex-1 inline-flex items-center justify-center gap-2 h-10 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium transition-all shadow-sm active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Excel</span>
                        </a>

                        <button onclick="window.print()" class="flex-1 inline-flex items-center justify-center gap-2 h-10 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-medium transition-all shadow-sm active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            <span>Cetak PDF</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4 w-16 text-center">No</th>
                                <th class="px-6 py-4">Tanggal Kunjungan</th>
                                <th class="px-6 py-4">Pemohon & Tujuan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Waktu (WITA)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($data as $index => $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center font-medium text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800 uppercase tracking-wide text-xs">{{ $item->user->name ?? $item->nama_pengunjung }}</div>
                                    <div class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                        <span class="px-1.5 py-0.5 bg-slate-100 rounded text-[10px] text-slate-600 font-medium">Tujuan:</span>
                                        <span class="font-medium text-slate-700">{{ $item->nama_tahanan }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->status == 'disetujui')
                                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui
                                        </span>
                                    @elseif($item->status == 'ditolak')
                                        <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                                        </span>
                                    @elseif($item->status == 'selesai')
                                        <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide border border-blue-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-mono text-slate-500 text-xs">
                                    {{ $item->updated_at->format('H:i') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12">
                                    <div class="flex flex-col items-center justify-center text-slate-400 border-2 border-dashed border-slate-200 rounded-2xl p-8 bg-slate-50/50">
                                        <svg class="w-10 h-10 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Tidak ada data ditemukan untuk kriteria filter tersebut.</span>
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

    <!-- Tampilan Cetak Resmi (A4 Portrait) -->
    <div id="print-layer">
        <div class="paper-a4">
            <img src="{{ asset('assets/logo-kejari.png') }}" class="print-watermark" alt="Watermark">

            <table class="kop-table">
                <tr>
                    <td class="logo-col">
                        <img src="{{ asset('assets/logo-kejari.png') }}" alt="Logo">
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
                <p>
                    STATUS: {{ strtoupper(request('status') && request('status') != 'semua' ? request('status') : 'SEMUA DATA') }}
                    @if(request('bulan'))
                        | BULAN: {{ strtoupper($daftar_bulan[request('bulan')]) }}
                    @endif
                    @if(request('tahun'))
                        | TAHUN: {{ request('tahun') }}
                    @endif
                </p>
                <p class="tgl-cetak">Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WITA</p>
            </div>

            <table class="print-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">NO</th>
                        <th style="width: 18%;">TANGGAL</th>
                        <th>PEMOHON & DETAIL TUJUAN</th>
                        <th style="width: 18%;">STATUS</th>
                        <th style="width: 12%;">WAKTU</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td class="center">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                        <td class="uppercase">
                            <span class="bold">{{ $item->user->name ?? $item->nama_pengunjung }}</span>
                            <div style="font-size: 8pt; font-weight: normal; margin-top: 3px; text-transform: none;">Tujuan Tahanan: <span class="bold">{{ $item->nama_tahanan }}</span></div>
                        </td>
                        <td class="center bold">{{ strtoupper($item->status) }}</td>
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
                            <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            <p class="jabatan">Kepala Kejaksaan Negeri,</p>
                            <p class="nama">H. FULAN, SH., MH.</p>
                            <p class="nip">NIP. 19800101 200001 1 001</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Cetak Stylesheet Scope -->
    <style>
        #print-layer {
            display: none;
        }

        @media print {
            @page {
                margin: 0;
                size: A4 portrait;
            }

            /* Sembunyikan elemen bawaan dari x-app-layout (navbar, header, footer) */
            header, nav, aside, footer {
                display: none !important;
            }

            /* Hilangkan warna background abu-abu dari layout bawaan */
            body, html, main {
                background-color: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Tampilkan area cetak */
            #print-layer {
                display: block !important;
                width: 100%;
                background-color: white;
            }

            .paper-a4 {
                width: 100%;
                margin: 0 auto;
                padding: 1.5cm 2cm;
                font-family: 'Times New Roman', serif;
                color: black;
                position: relative;
                background: white;
            }

            .print-watermark {
                position: absolute;
                top: 350px;
                left: 50%;
                width: 400px;
                transform: translateX(-50%);
                opacity: 0.06;
                filter: grayscale(100%);
                z-index: -1;
            }

            .kop-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
            .logo-col { width: 15%; text-align: center; vertical-align: middle; }
            .logo-col img { width: 90px; height: auto; }
            .text-col { text-align: center; vertical-align: middle; padding-left: 10px; line-height: 1.3; }

            .kop-1 { font-size: 13pt; font-weight: bold; }
            .kop-2 { font-size: 15pt; font-weight: bold; }
            .kop-3 { font-size: 17pt; font-weight: 900; color: #166534; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .kop-alamat { font-size: 9.5pt; font-style: italic; margin-top: 5px; }
            .garis-bawah { border-top: 4px double black; height: 5px; margin-top: 15px; }

            .judul-area { text-align: center; margin-bottom: 25px; }
            .judul-area h1 { font-size: 13pt; font-weight: bold; text-decoration: underline; margin: 0; }
            .judul-area p { font-size: 9.5pt; margin-top: 6px; font-weight: bold; }
            .tgl-cetak { font-size: 8.5pt; font-style: italic; font-weight: normal !important; margin-top: 3px !important; }

            .print-table { width: 100%; border-collapse: collapse; font-size: 9.5pt; }
            .print-table th, .print-table td { border: 1px solid black; padding: 7px; vertical-align: middle; }
            .print-table thead th { background-color: #f1f5f9 !important; font-weight: bold; text-align: center; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

            .center { text-align: center; }
            .uppercase { text-transform: uppercase; }
            .bold { font-weight: bold; }

            .ttd-area { margin-top: 50px; page-break-inside: avoid; }
            .ttd-box { text-align: center; width: 45%; font-size: 10.5pt; }
            .jabatan { margin-bottom: 75px; font-weight: bold; }
            .nama { font-weight: bold; text-decoration: underline; text-transform: uppercase; margin-bottom: 2px; }

            * { box-shadow: none !important; text-shadow: none !important; }
        }
    </style>
</x-app-layout>