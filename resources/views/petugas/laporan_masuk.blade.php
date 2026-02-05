<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Permohonan Masuk') }}
        </h2>
    </x-slot>

    <div class="web-view min-h-screen bg-gray-50 font-sans py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
                <form method="GET" action="{{ route('petugas.laporan.index') }}" class="flex flex-col md:flex-row gap-4 items-end justify-between">

                    <div class="w-full md:w-64">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter Status</label>
                        <select name="status" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 cursor-pointer">
                            <option value="semua" {{ request('status') == 'semua' || !request('status') ? 'selected' : '' }}>📂 Semua Data</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅ Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('petugas.laporan.excel', ['status' => request('status', 'semua'), 'action' => 'download']) }}" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded shadow text-sm font-bold flex items-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export Excel
                        </a>

                        <button onclick="window.print()" type="button" class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded shadow text-sm font-bold flex items-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak PDF
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pemohon</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tahanan</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="block text-sm font-bold text-gray-900 uppercase">{{ $item->user->name ?? 'Guest' }}</span>
                                <span class="block text-xs text-gray-500">{{ $item->nik_pengunjung }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 uppercase">{{ $item->nama_tahanan }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-bold rounded {{ $item->status == 'disetujui' ? 'bg-green-100 text-green-800' : ($item->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 italic">
                                {{ $item->alasan_penolakan ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic bg-gray-50">Data permohonan kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="print-view">
        <table style="width: 100%; border-bottom: 3px double black; margin-bottom: 20px; line-height: 1.3;">
            <tr>
                <td style="width: 15%; text-align: center; vertical-align: top; padding-bottom: 10px;">
                    <img src="{{ asset('assets/logo-kejari.png') }}" style="width: 85px; height: auto;" alt="Logo">
                </td>
                <td style="width: 70%; text-align: center; vertical-align: top; color: black;">
                    <div style="font-size: 14pt; font-weight: bold; font-family: 'Times New Roman', serif;">KEJAKSAAN REPUBLIK INDONESIA</div>
                    <div style="font-size: 16pt; font-weight: bold; font-family: 'Times New Roman', serif;">KEJAKSAAN TINGGI KALIMANTAN SELATAN</div>
                    <div style="font-size: 18pt; font-weight: 900; font-family: 'Times New Roman', serif;">KEJAKSAAN NEGERI BANJARMASIN</div>
                    <div style="font-size: 10pt; font-style: italic; font-family: 'Times New Roman', serif; margin-top: 5px;">
                        Jl. Brig Jend. Hasan Basri No.3, Rw.02, Pangeran, Kec. Banjarmasin Utara,<br>
                        Kota Banjarmasin, Kalimantan Selatan 70124 | Telp. (0511)-3300402
                    </div>
                </td>
                <td style="width: 15%;"></td>
            </tr>
        </table>

        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="font-family: 'Times New Roman', serif; font-size: 14pt; font-weight: bold; text-decoration: underline; margin: 0; color: black;">
                LAPORAN REKAPITULASI PERMOHONAN
            </h2>
            <p style="font-family: 'Times New Roman', serif; font-size: 10pt; margin-top: 5px; text-transform: uppercase; color: black;">
                STATUS DATA: {{ request('status') == 'semua' || !request('status') ? 'SEMUA DATA' : strtoupper(request('status')) }}
            </p>
        </div>

        <table style="width: 100%; border-collapse: collapse; font-family: 'Times New Roman', serif; font-size: 11pt; color: black;">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th style="border: 1px solid black; padding: 6px; text-align: center; width: 30px;">NO</th>
                    <th style="border: 1px solid black; padding: 6px; text-align: center; width: 100px;">TANGGAL</th>
                    <th style="border: 1px solid black; padding: 6px; text-align: left;">NAMA PENGUNJUNG</th>
                    <th style="border: 1px solid black; padding: 6px; text-align: left;">TAHANAN TUJUAN</th>
                    <th style="border: 1px solid black; padding: 6px; text-align: center; width: 40px;">JML</th>
                    <th style="border: 1px solid black; padding: 6px; text-align: center; width: 80px;">STATUS</th>
                    <th style="border: 1px solid black; padding: 6px; text-align: left;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @php
                // Grouping Data Berdasarkan Bulan
                $groupedData = $data->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('F Y');
                });
                $no = 1;
                @endphp

                @forelse($groupedData as $bulan => $items)
                <tr>
                    <td colspan="7" style="border: 1px solid black; padding: 6px; font-weight: bold; background-color: #e5e5e5; text-transform: uppercase;">
                        PERIODE: {{ $bulan }}
                    </td>
                </tr>

                @foreach($items as $item)
                <tr>
                    <td style="border: 1px solid black; padding: 6px; text-align: center;">{{ $no++ }}</td>
                    <td style="border: 1px solid black; padding: 6px; text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                    <td style="border: 1px solid black; padding: 6px; text-transform: uppercase; font-weight: bold;">{{ $item->user->name ?? 'Guest' }}</td>
                    <td style="border: 1px solid black; padding: 6px; text-transform: uppercase;">{{ $item->nama_tahanan }}</td>
                    <td style="border: 1px solid black; padding: 6px; text-align: center;">{{ $item->jumlah_pengikut }}</td>
                    <td style="border: 1px solid black; padding: 6px; text-align: center; font-weight: bold; font-size: 10pt; text-transform: uppercase;">{{ $item->status }}</td>
                    <td style="border: 1px solid black; padding: 6px; font-style: italic;">{{ $item->alasan_penolakan ?? '-' }}</td>
                </tr>
                @endforeach
                @empty
                <tr>
                    <td colspan="7" style="border: 1px solid black; padding: 20px; text-align: center; font-style: italic;">Tidak ada data ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 50px; page-break-inside: avoid;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 60%;"></td>
                    <td style="width: 40%; text-align: center; font-family: 'Times New Roman', serif; color: black;">
                        <p style="margin-bottom: 5px;">Banjarmasin, {{ date('d F Y') }}</p>
                        <p style="font-weight: bold; margin-bottom: 80px;">Petugas Pelayanan,</p>
                        <p style="font-weight: bold; text-decoration: underline; text-transform: uppercase;">{{ Auth::user()->name }}</p>
                        <p>NIP. ...........................</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <style>
        /* Sembunyikan Print View di Layar Biasa */
        .print-view {
            display: none;
        }

        /* Mode Cetak (Print) */
        @media print {
            @page {
                margin: 0;
                size: A4 portrait;
            }

            .web-view,
            nav,
            header,
            footer {
                display: none !important;
            }

            .print-view {
                display: block !important;
                background-color: white;
                padding: 1.5cm 2cm;
                width: 100%;
                position: absolute;
                top: 0;
                left: 0;
            }

            body {
                background-color: white;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</x-app-layout>