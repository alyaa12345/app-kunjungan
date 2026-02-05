<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-wide">
                {{ __('Master Data Tahanan') }}
            </h2>
            <div class="flex items-center gap-2">
                <span class="bg-slate-800 text-white text-xs font-bold px-3 py-1 rounded shadow">
                    TOTAL: {{ $tahanans->count() }} ORANG
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERT SUKSES --}}
            @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-600 text-green-800 p-4 shadow-sm rounded-r flex items-center gap-3" role="alert">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <div>
                    <p class="font-bold">SUKSES</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            {{-- FORM INPUT DATA (Disembunyikan saat Print) --}}
            <div class="bg-white rounded-xl shadow-md border border-gray-200 mb-8 overflow-hidden no-print">
                <div class="bg-slate-800 px-6 py-4 border-b border-slate-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <h3 class="font-bold text-white uppercase tracking-wider text-sm">Input Data Tahanan Baru</h3>
                </div>

                <div class="p-6 bg-gray-50">
                    <form action="{{ route('petugas.tahanan.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="w-full rounded border-gray-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 text-sm" placeholder="Sesuai KTP/Berkas..." required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Bin / Binti</label>
                                <input type="text" name="nama_bin" class="w-full rounded border-gray-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 text-sm" placeholder="Nama Orang Tua..." required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kasus / Pasal</label>
                                <input type="text" name="kasus" class="w-full rounded border-gray-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 text-sm" placeholder="Contoh: 363 KUHP (Pencurian)" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nomor Registrasi</label>
                                <input type="text" name="nomor_registrasi" class="w-full rounded border-gray-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 text-sm" placeholder="Nomor Register Tahanan" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Blok & Kamar</label>
                                <select name="blok_kamar" class="w-full rounded border-gray-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 text-sm" required>
                                    <option value="" disabled selected>-- PILIH BLOK --</option>
                                    <option value="Blok A (Narkoba)">BLOK A (NARKOBA)</option>
                                    <option value="Blok B (Kriminal)">BLOK B (KRIMINAL)</option>
                                    <option value="Blok C (Wanita)">BLOK C (WANITA)</option>
                                    <option value="Blok D (Isolasi)">BLOK D (ISOLASI)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status Kesehatan/Keamanan</label>
                                <select name="status" class="w-full rounded border-gray-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 text-sm" required>
                                    <option value="normal" selected>✅ AMAN / NORMAL</option>
                                    <option value="sakit">⚠️ SAKIT (Klinik)</option>
                                    <option value="isolasi">⛔ ISOLASI (Register F)</option>
                                </select>
                            </div>

                            <div class="md:col-span-2 lg:col-span-3 flex justify-end mt-2">
                                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 px-6 rounded shadow transition duration-200 flex items-center gap-2 text-sm uppercase tracking-wide">
                                    Simpan Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABEL TAMPILAN UTAMA (LAYAR) --}}
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                <div class="p-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
                    <h3 class="font-bold text-gray-800 uppercase tracking-wide">Daftar Penghuni</h3>

                    <div class="flex gap-3">
                        <button onclick="openPreviewModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm flex items-center gap-2 shadow transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l4 4a1 1 0 01.586 1.414V19a2 2 0 01-2 2z"></path>
                            </svg>
                            BUAT LAPORAN
                        </button>

                        <div class="relative">
                            <input type="text" id="searchInput" onkeyup="searchTable()" class="pl-10 pr-4 py-2 border border-gray-300 rounded focus:ring-slate-500 focus:border-slate-500 text-sm" placeholder="Cari Nama...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse" id="mainTable">
                        <thead class="bg-slate-800 text-white uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Identitas</th>
                                <th class="px-6 py-4">No. Reg / Kamar</th>
                                <th class="px-6 py-4">Kasus</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Jatah Visit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($tahanans as $t)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 capitalize">{{ $t->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500 italic">Bin: {{ $t->nama_bin }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-mono font-bold">{{ $t->nomor_registrasi }}</div>
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded border">{{ $t->blok_kamar }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded border border-purple-200 text-xs font-bold uppercase">{{ $t->kasus ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($t->status == 'isolasi')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">⛔ ISOLASI</span>
                                    @elseif($t->status == 'sakit')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200">⚠️ SAKIT</span>
                                    @else
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">✅ NORMAL</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-slate-800">{{ $t->status == 'isolasi' ? '0' : ($t->jatah_kunjungan ?? 2) }}</span> <span class="text-xs">x / Minggu</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center italic text-gray-400">Data Kosong</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL PREVIEW (UNTUK CETAK & EXCEL BERSIH) --}}
    {{-- ========================================== --}}
    <div id="previewModal" class="fixed inset-0 z-50 hidden bg-black/70 flex justify-center items-start pt-10 overflow-auto">
        <div class="bg-white w-full max-w-4xl p-8 rounded-lg shadow-2xl relative mb-10">

            {{-- TOMBOL CLOSE --}}
            <button onclick="document.getElementById('previewModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-2xl font-bold no-print">&times;</button>

            {{-- HEADER MODAL (AKAN HILANG SAAT PRINT) --}}
            <div class="flex justify-between items-center mb-6 border-b pb-4 no-print">
                <h2 class="text-2xl font-bold text-gray-800">Preview Laporan</h2>
                <div class="flex gap-2">
                    <button onclick="downloadExcel()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Excel
                    </button>
                    <button onclick="window.print()" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded shadow flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak PDF
                    </button>
                </div>
            </div>

            {{-- AREA KERTAS (YANG AKAN DICETAK/DIEXPORT) --}}
            <div id="printArea" class="bg-white text-black font-serif">

                {{-- KOP SURAT --}}
                <table style="width: 100%; border-bottom: 3px double black; margin-bottom: 20px;">
                    <tr>
                        <td style="width: 15%; text-align: center; vertical-align: middle;">
                            <img src="{{ asset('assets/logo-kejari.png') }}" style="width: 80px; height: auto;">
                        </td>
                        <td style="width: 85%; text-align: center; vertical-align: middle;">
                            <h2 style="font-size: 14pt; font-weight: bold; margin: 0; text-transform: uppercase;">KEJAKSAAN REPUBLIK INDONESIA</h2>
                            <h2 style="font-size: 16pt; font-weight: 900; margin: 0; text-transform: uppercase;">KEJAKSAAN NEGERI BANJARMASIN</h2>
                            <p style="font-size: 10pt; margin: 2px 0 0 0; font-style: italic;">
                                Jl. Brig Jend. Hasan Basri No.3, Pangeran, Banjarmasin Utara, Kalimantan Selatan
                            </p>
                        </td>
                    </tr>
                </table>

                <div class="text-center mb-6">
                    <h3 style="font-size: 12pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">LAPORAN DATA TAHANAN</h3>
                    <p style="font-size: 10pt;">Dicetak pada: {{ date('d F Y') }}</p>
                </div>

                {{-- TABEL BERSIH UNTUK CETAK (Gunakan Border Standard HTML agar terbaca Excel/PDF) --}}
                <table class="w-full text-sm" style="border-collapse: collapse; width: 100%;" border="1" id="tableForExport">
                    <thead>
                        <tr style="background-color: #f0f0f0; text-align: center; font-weight: bold;">
                            <th style="padding: 8px; border: 1px solid black; width: 5%;">NO</th>
                            <th style="padding: 8px; border: 1px solid black; width: 30%;">NAMA LENGKAP</th>
                            <th style="padding: 8px; border: 1px solid black; width: 20%;">NO. REGISTRASI</th>
                            <th style="padding: 8px; border: 1px solid black; width: 20%;">BLOK KAMAR</th>
                            <th style="padding: 8px; border: 1px solid black; width: 15%;">STATUS</th>
                            <th style="padding: 8px; border: 1px solid black; width: 10%;">VISIT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tahanans as $index => $t)
                        <tr>
                            <td style="border: 1px solid black; padding: 6px; text-align: center;">{{ $index + 1 }}</td>
                            <td style="border: 1px solid black; padding: 6px;">
                                <b>{{ strtoupper($t->nama_lengkap) }}</b><br>
                                <span style="font-size: 10px; font-style: italic;">BIN: {{ strtoupper($t->nama_bin) }}</span>
                            </td>
                            <td style="border: 1px solid black; padding: 6px; text-align: center;">{{ $t->nomor_registrasi }}</td>
                            <td style="border: 1px solid black; padding: 6px; text-align: center;">{{ $t->blok_kamar }}</td>
                            <td style="border: 1px solid black; padding: 6px; text-align: center; font-weight: bold;">
                                @if($t->status == 'isolasi') ISOLASI @elseif($t->status == 'sakit') SAKIT @else AMAN @endif
                            </td>
                            <td style="border: 1px solid black; padding: 6px; text-align: center;">
                                {{ $t->status == 'isolasi' ? '0' : ($t->jatah_kunjungan ?? 2) }}x
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- TANDA TANGAN --}}
                <div class="mt-10 flex justify-end">
                    <div class="text-center" style="width: 200px;">
                        <p>Banjarmasin, {{ date('d F Y') }}</p>
                        <p>Petugas Jaga,</p>
                        <br><br><br>
                        <p style="font-weight: bold; text-decoration: underline;">{{ strtoupper(Auth::user()->name) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT PENTING --}}
    <script>
        // Buka Modal
        function openPreviewModal() {
            document.getElementById('previewModal').classList.remove('hidden');
        }

        // Cari Data di Tabel Utama
        function searchTable() {
            let input = document.getElementById("searchInput").value.toUpperCase();
            let rows = document.getElementById("mainTable").getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                let text = rows[i].textContent || rows[i].innerText;
                rows[i].style.display = text.toUpperCase().indexOf(input) > -1 ? "" : "none";
            }
        }

        // FUNGSI KHUSUS EXCEL (MEMBANGUN ULANG TABEL HTML AGAR RAPI)
        function downloadExcel() {
            // Ambil data dari tabel bersih
            let table = document.getElementById("tableForExport");

            // Konversi menjadi String HTML
            // Kita bungkus dengan html dasar agar Excel membaca charset dengan benar
            let html = `
                <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
                <head></head>
                <body>
                    <table border="0">
                        <tr><td colspan="6" align="center" style="font-size:14pt; font-weight:bold;">KEJAKSAAN REPUBLIK INDONESIA</td></tr>
                        <tr><td colspan="6" align="center" style="font-size:16pt; font-weight:bold;">KEJAKSAAN NEGERI BANJARMASIN</td></tr>
                        <tr><td colspan="6" align="center" style="font-style:italic;">Jl. Brig Jend. Hasan Basri No.3, Pangeran, Banjarmasin Utara</td></tr>
                        <tr><td colspan="6"></td></tr>
                        <tr><td colspan="6" align="center" style="font-size:12pt; font-weight:bold; text-decoration:underline;">LAPORAN DATA TAHANAN</td></tr>
                        <tr><td colspan="6" align="center">Per Tanggal: {{ date('d F Y') }}</td></tr>
                        <tr><td colspan="6"></td></tr>
                    </table>
                    ${table.outerHTML}
                </body></html>`;

            // Ganti spasi dengan kode URL agar tidak putus
            let blob = new Blob([html], {
                type: 'application/vnd.ms-excel'
            });
            let url = URL.createObjectURL(blob);
            let a = document.createElement('a');

            a.href = url;
            a.download = 'Laporan_Data_Tahanan.xls';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    </script>

    {{-- STYLE CETAK (FIX HEADER BROWSER) --}}
    <style>
        /* CSS INI YANG MENGHILANGKAN TULISAN 127.0.0.1 DI HEADER */
        @page {
            size: A4 portrait;
            margin: 0;
            /* HAPUS MARGIN DEFAULT BROWSER */
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
            }

            /* Sembunyikan semua elemen kecuali modal preview */
            body * {
                visibility: hidden;
            }

            #previewModal,
            #previewModal * {
                visibility: visible;
            }

            /* Posisikan Modal agar pas di kertas */
            #previewModal {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                background: white;
                overflow: visible;
            }

            /* Berikan Padding Halaman di dalam Print Area */
            #printArea {
                padding: 1.5cm;
                /* Padding kertas */
                width: 100%;
                box-sizing: border-box;
            }

            /* Hilangkan tombol close & action bar saat print */
            .no-print,
            button,
            .action-bar {
                display: none !important;
            }
        }
    </style>
</x-app-layout>