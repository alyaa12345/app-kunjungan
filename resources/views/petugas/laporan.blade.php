<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Permohonan') }}
        </h2>
    </x-slot>

    @php
    // Penyelamat Data
    $finalData = $laporan_detail ?? $data ?? collect([]);
    $judulLaporan = $title ?? 'Laporan Data';
    @endphp

    <div id="screen-area" class="min-h-screen bg-gray-50 font-sans py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white border-b border-gray-200 shadow-sm mb-6 rounded-lg p-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Pusat Laporan</h1>
                        <p class="text-sm text-gray-500 mt-1">{{ $judulLaporan }}</p>
                        <p class="text-xs text-gray-400">Total: {{ $finalData->count() }} Data Ditemukan</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="document.getElementById('filterModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-bold shadow transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter Detail
                        </button>
                        <button onclick="window.print()" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2 rounded-lg font-bold shadow transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak PDF
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pengunjung</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tahanan</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($finalData as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="block font-bold text-gray-800">{{ $item->nama_pengunjung }}</span>
                                <span class="text-xs text-gray-500">{{ $item->nik_pengunjung }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm uppercase">{{ $item->nama_tahanan }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 text-xs font-bold rounded {{ $item->status == 'disetujui' ? 'bg-green-100 text-green-800' : ($item->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">Data tidak ditemukan dengan filter ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="print-area" style="display: none;">
        <table style="width: 100%; border-bottom: 3px solid black; margin-bottom: 20px;">
            <tr>
                <td style="width: 20%; text-align: center;">
                    <img src="{{ asset('assets/logo-kejari.png') }}" style="width: 80px; height: auto;">
                </td>
                <td style="width: 80%; text-align: center;">
                    <h2 style="font-size: 14pt; font-weight: bold; margin: 0;">KEJAKSAAN REPUBLIK INDONESIA</h2>
                    <h2 style="font-size: 16pt; font-weight: 900; margin: 0;">KEJAKSAAN NEGERI BANJARMASIN</h2>
                    <p style="font-size: 10pt; font-style: italic; margin: 5px 0 0 0;">
                        Jl. Brig Jend. Hasan Basri No.3, Pangeran, Banjarmasin Utara<br>
                        Kalimantan Selatan 70124 | Telp. (0511)-3300402
                    </p>
                </td>
            </tr>
        </table>

        <div style="text-align: center; margin-bottom: 30px;">
            <h3 style="font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; margin: 0;">LAPORAN REGISTER KUNJUNGAN</h3>
            <p style="font-size: 11pt; font-weight: bold; text-transform: uppercase; margin-top: 5px;">{{ $judulLaporan }}</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; font-size: 10pt;">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th style="border: 1px solid black; padding: 8px; text-align: center; width: 5%;">NO</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: center; width: 15%;">TANGGAL</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left;">PENGUNJUNG</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left;">TAHANAN</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: center;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($finalData as $index => $item)
                <tr>
                    <td style="border: 1px solid black; padding: 6px; text-align: center;">{{ $index + 1 }}</td>
                    <td style="border: 1px solid black; padding: 6px; text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                    <td style="border: 1px solid black; padding: 6px;">
                        <b>{{ $item->nama_pengunjung }}</b><br>
                        <span style="font-size: 8pt;">NIK: {{ $item->nik_pengunjung }}</span>
                    </td>
                    <td style="border: 1px solid black; padding: 6px; text-transform: uppercase;">{{ $item->nama_tahanan }}</td>
                    <td style="border: 1px solid black; padding: 6px; text-align: center;">
                        <b>{{ strtoupper($item->status) }}</b>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="border: 1px solid black; padding: 20px; text-align: center;">-- Tidak ada data --</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 50px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 60%;"></td>
                    <td style="width: 40%; text-align: center;">
                        <p>Banjarmasin, {{ date('d F Y') }}</p>
                        <p style="margin-bottom: 70px;">Petugas Pelayanan,</p>
                        <p style="font-weight: bold; text-decoration: underline;">{{ Auth::user()->name }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="filterModal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-lg text-gray-800">Filter Laporan Detail</h3>
                <button onclick="document.getElementById('filterModal').classList.add('hidden')" class="text-gray-500 hover:text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('petugas.laporan.statistik') }}" method="GET" class="p-6 space-y-4">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Status Kunjungan</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="semua">Semua Status</option>
                        <option value="menunggu">⏳ Menunggu</option>
                        <option value="disetujui">✅ Disetujui</option>
                        <option value="ditolak">❌ Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Cari Nama / NIK</label>
                    <input type="text" name="search" placeholder="Contoh: Budi atau NIK..." class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <hr class="border-gray-200">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Periode Waktu</label>
                    <select name="filter_type" onchange="toggleInputs()" class="w-full rounded-lg border-gray-300 mb-3">
                        <option value="harian">Harian</option>
                        <option value="mingguan">Mingguan</option>
                        <option value="bulanan">Bulanan</option>
                        <option value="tahunan">Tahunan</option>
                    </select>

                    <div id="input-harian">
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div id="input-mingguan" class="hidden grid grid-cols-2 gap-2">
                        <input type="date" name="start_date" class="w-full rounded-lg border-gray-300">
                        <input type="date" name="end_date" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div id="input-bulanan" class="hidden grid grid-cols-2 gap-2">
                        <select name="bulan" class="w-full rounded-lg border-gray-300">
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                @endfor
                        </select>
                        <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full rounded-lg border-gray-300">
                    </div>
                    <div id="input-tahunan" class="hidden">
                        <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full rounded-lg border-gray-300">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow mt-4 transition">
                    Terapkan Filter
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleInputs() {
            const type = document.querySelector('select[name="filter_type"]').value;
            ['harian', 'mingguan', 'bulanan', 'tahunan'].forEach(id => document.getElementById('input-' + id).classList.add('hidden'));
            document.getElementById('input-' + type).classList.remove('hidden');
        }
    </script>

    <style>
        @media screen {
            #print-area {
                display: none !important;
            }
        }

        @media print {
            @page {
                margin: 0;
                size: A4 portrait;
            }

            body * {
                visibility: hidden;
            }

            nav,
            header,
            footer,
            .web-view,
            #screen-area,
            #filterModal {
                display: none !important;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                display: block !important;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 1.5cm;
                background: white;
                color: black !important;
                font-family: 'Times New Roman', serif !important;
            }

            img {
                display: inline-block !important;
                visibility: visible !important;
            }
        }
    </style>
</x-app-layout>