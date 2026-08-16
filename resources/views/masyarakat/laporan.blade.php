<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Laporan & Bukti') }}
        </h2>
    </x-slot>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        /* TAMPILAN LAYAR (NORMAL) */
        #print-container {
            display: none;
        }

        /* TAMPILAN CETAK (SAAT DI-PRINT) */
        @media print {

            /* 1. Reset Halaman: Hilangkan Header/Footer Browser (URL, Tanggal) */
            @page {
                margin: 0;
                size: auto;
            }

            html,
            body {
                margin: 0;
                padding: 0;
                height: 100%;
            }

            /* 2. Sembunyikan SEMUA elemen website asli */
            body * {
                visibility: hidden;
            }

            /* 3. Tampilkan HANYA Wadah Cetak */
            #print-container,
            #print-container * {
                visibility: visible;
            }

            #print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 2cm;
                display: block !important;
                background: white;
                font-family: 'Times New Roman', Times, serif;
                color: black;
            }

            .no-print {
                display: none !important;
            }
        }

        /* KOP SURAT (TABEL) */
        .table-kop {
            width: 100%;
            border-bottom: 3px double black;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .table-kop td {
            vertical-align: middle;
            text-align: center;
        }

        /* Style Logo agar pas di kertas */
        .img-kop {
            width: 90px;
            height: auto;
        }

        .kop-title h4 {
            margin: 0;
            font-size: 14px;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-title h3 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-title h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .kop-title p {
            margin: 0;
            font-size: 12px;
            font-style: italic;
        }

        /* TABEL DATA */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12pt;
        }

        .table-data th,
        .table-data td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .table-data th {
            background-color: #e5e5e5 !important;
            text-align: center;
            font-weight: bold;
            -webkit-print-color-adjust: exact;
        }
    </style>

    <div class="py-12 bg-[#F8FAFC] min-h-screen font-sans no-print">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h3 class="text-3xl font-bold text-[#0f172a]">Laporan Saya</h3>
                    <p class="text-slate-500 mt-1">Unduh bukti tiket kunjungan atau tanda terima titipan.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="bg-white p-1.5 rounded-xl shadow-sm border border-slate-200 flex gap-1">
                        <a href="{{ route('masyarakat.laporan', ['kategori' => 'kunjungan']) }}"
                            class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all {{ $kategori == 'kunjungan' ? 'bg-[#0f172a] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">
                            Laporan Kunjungan
                        </a>
                        <a href="{{ route('masyarakat.laporan', ['kategori' => 'titipan']) }}"
                            class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all {{ $kategori == 'titipan' ? 'bg-[#0f172a] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">
                            Laporan Titipan
                        </a>
                    </div>

                    <button onclick="cetakRekap()" class="px-6 py-2.5 bg-white border-2 border-[#0f172a] text-[#0f172a] font-bold rounded-xl hover:bg-slate-50 transition shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Rekapitulasi
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200">
                @if(($kategori == 'kunjungan' && $data_kunjungan->isEmpty()) || ($kategori == 'titipan' && $data_titipan->isEmpty()))
                <div class="p-16 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h5 class="text-slate-800 font-bold text-lg">Tidak Ada Data Valid</h5>
                    <p class="text-slate-500 text-sm">Belum ada data {{ $kategori }} yang disetujui petugas.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-white uppercase bg-[#0f172a]">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Penerima</th>
                                <th class="px-6 py-4">Detail</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @if($kategori == 'kunjungan')
                            @foreach($data_kunjungan as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-bold">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</td>
                                <td class="px-6 py-4">{{ $item->nama_tahanan }}</td>
                                <td class="px-6 py-4">Sesi: {{ $item->jam_kunjungan }} | {{ $item->jumlah_pengikut }} Orang</td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="siapkanTiket('{{ $item->id }}', '{{ addslashes($item->nama_tahanan) }}', '{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') }}', '{{ $item->jam_kunjungan }}', '{{ $item->jumlah_pengikut }} Orang', '{{ addslashes(Auth::user()->name) }}', 'kunjungan')" class="bg-[#0f172a] text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-slate-800">Cetak Tiket</button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            @foreach($data_titipan as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-bold">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">{{ $item->nama_tahanan }}</td>
                                <td class="px-6 py-4">{{ $item->jenis_titipan }} - {{ Str::limit($item->deskripsi_barang, 20) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="siapkanTiket('{{ $item->id }}', '{{ addslashes($item->nama_tahanan) }}', '{{ $item->created_at->format('d F Y') }}', '-', '{{ $item->jenis_titipan }}', '{{ addslashes(Auth::user()->name) }}', 'titipan')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg text-xs font-bold hover:bg-slate-50">Unduh Bukti</button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div id="print-container">

        <table class="table-kop">
            <tr>
                <td width="15%">
                    <img src="{{ asset('assets/logo-kejari.png') }}" class="img-kop" alt="Logo">
                </td>
                <td width="85%" class="kop-title">
                    <h4>KEJAKSAAN REPUBLIK INDONESIA</h4>
                    <h3>KEJAKSAAN TINGGI KALIMANTAN SELATAN</h3>
                    <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
                    <p>Jl. Brigjend H. Hasan Basri No. 4, Banjarmasin Utara - Kalimantan Selatan</p>
                    <p>Telp: (0511) 3301234 | Email: kn.banjarmasin@kejaksaan.go.id</p>
                </td>
            </tr>
        </table>

        <div id="print-content"></div>

        <div style="margin-top: 50px; text-align: right;">
            <div style="width: 250px; text-align: center; float: right;">
                <p style="margin-bottom: 5px;">Banjarmasin, {{ date('d F Y') }}</p>
                <p style="margin-bottom: 70px; font-weight: bold;">Petugas Pelayanan</p>
                <p style="font-weight: bold; text-decoration: underline;">ADMINISTRATOR</p>
            </div>
        </div>
    </div>

    <script>
        // A. FUNGSI CETAK REKAPITULASI
        function cetakRekap() {
            var contentHTML = '';

            // Judul
            contentHTML += '<h3 style="text-align:center; text-decoration:underline; text-transform:uppercase; margin-bottom:20px;">LAPORAN REKAPITULASI {{ $kategori == "kunjungan" ? "KUNJUNGAN" : "TITIPAN BARANG" }}</h3>';
            contentHTML += '<p><strong>Nama Pengunjung:</strong> {{ addslashes(Auth::user()->name) }}</p>';

            // Buat Tabel
            contentHTML += '<table class="table-data">';
            contentHTML += '<thead><tr><th>No</th><th>Tanggal</th><th>Nama Tahanan</th><th>{{ $kategori == "kunjungan" ? "Sesi / Pengikut" : "Barang / Rincian" }}</th><th>Status</th></tr></thead>';
            contentHTML += '<tbody>';

            @if($kategori == 'kunjungan')
            // MENGGUNAKAN VARIABEL YANG BENAR
            @foreach($data_kunjungan as $index => $item)
            contentHTML += '<tr>';
            contentHTML += '<td style="text-align:center">{{ $index + 1 }}</td>';
            contentHTML += '<td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format("d/m/Y") }}</td>';
            contentHTML += '<td>{{ addslashes($item->nama_tahanan) }}</td>';
            contentHTML += '<td>Sesi {{ $item->jam_kunjungan }} ({{ $item->jumlah_pengikut }} Org)</td>';
            contentHTML += '<td style="text-align:center">DISETUJUI</td>';
            contentHTML += '</tr>';
            @endforeach
            @else
            // MENGGUNAKAN VARIABEL YANG BENAR
            @foreach($data_titipan as $index => $item)
            contentHTML += '<tr>';
            contentHTML += '<td style="text-align:center">{{ $index + 1 }}</td>';
            contentHTML += '<td>{{ $item->created_at->format("d/m/Y") }}</td>';
            contentHTML += '<td>{{ addslashes($item->nama_tahanan) }}</td>';
            contentHTML += '<td>{{ $item->jenis_titipan }}</td>';
            contentHTML += '<td style="text-align:center">DITERIMA</td>';
            contentHTML += '</tr>';
            @endforeach
            @endif

            contentHTML += '</tbody></table>';

            // Masukkan ke wadah cetak & Print
            document.getElementById('print-content').innerHTML = contentHTML;
            window.print();
        }

        // B. FUNGSI CETAK TIKET SATUAN (QR CODE)
        function siapkanTiket(id, tahanan, tanggal, sesi, detail, pengunjung, tipe) {
            var title = (tipe == 'kunjungan') ? 'SURAT IZIN KUNJUNGAN' : 'TANDA TERIMA TITIPAN';
            var noReg = 'REG/' + id + '/{{ date("Y") }}';

            var contentHTML = '';
            contentHTML += '<div style="text-align:center; margin-bottom:30px;">';
            contentHTML += '<h2 style="text-decoration:underline; margin:0;">' + title + '</h2>';
            contentHTML += '<p style="margin:5px 0;">Nomor: ' + noReg + '</p>';
            contentHTML += '</div>';

            contentHTML += '<table style="width:100%; margin-bottom:20px; font-size:14pt;">';
            contentHTML += '<tr><td width="150"><strong>Nama Pengunjung</strong></td><td>: ' + pengunjung + '</td></tr>';
            contentHTML += '<tr><td><strong>Nama Tahanan</strong></td><td>: ' + tahanan + '</td></tr>';
            contentHTML += '<tr><td><strong>Tanggal</strong></td><td>: ' + tanggal + '</td></tr>';
            contentHTML += '<tr><td><strong>Detail</strong></td><td>: ' + detail + '</td></tr>';
            contentHTML += '</table>';

            // QR Code Container
            contentHTML += '<div style="margin-top:30px; border:1px dashed #000; padding:10px; display:inline-block;">';
            contentHTML += '<div id="qr-target"></div>';
            contentHTML += '<p style="font-size:10px; margin:5px 0 0 0;">Scan Validasi Sistem</p>';
            contentHTML += '</div>';

            document.getElementById('print-content').innerHTML = contentHTML;

            // Generate QR Code
            document.getElementById("qr-target").innerHTML = "";
            new QRCode(document.getElementById("qr-target"), {
                text: "VALID-" + tipe.toUpperCase() + "-" + id,
                width: 100,
                height: 100
            });

            // Delay sedikit biar QR Code jadi gambar, baru print
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</x-app-layout>