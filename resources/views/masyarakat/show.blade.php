<x-app-layout>

    <div class="web-view min-h-screen bg-slate-100 flex flex-col items-center py-10 px-4 font-sans">

        <div class="w-full max-w-3xl flex justify-between items-center mb-6">
            <a href="{{ route('masyarakat.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold">
                &larr; Kembali
            </a>

            @if($kunjungan->status == 'disetujui')
            <button onclick="printTiket()" class="bg-slate-900 text-white px-5 py-2 rounded-lg font-bold shadow hover:bg-black flex items-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Tiket
            </button>
            @endif
        </div>

        <div class="w-full max-w-3xl bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
            @if($kunjungan->status == 'menunggu' || $kunjungan->status == 'verifikasi')
            <div class="p-10 text-center">
                <h2 class="text-2xl font-bold text-amber-500 mb-2">Sedang Diverifikasi</h2>
                <p class="text-slate-500">Mohon tunggu petugas memverifikasi data Anda.</p>
            </div>
            @elseif($kunjungan->status == 'ditolak')
            <div class="p-10 text-center">
                <h2 class="text-2xl font-bold text-red-500 mb-2">Permohonan Ditolak</h2>
                <p class="text-slate-500">Silakan ajukan ulang dengan data yang benar.</p>
            </div>
            @else
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-2/3 p-8">
                    <h1 class="text-xl font-bold text-slate-800 uppercase mb-6 border-b pb-2">Bukti Pendaftaran</h1>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <small class="text-slate-400 font-bold uppercase">Kode Booking</small>
                            <p class="text-xl font-mono font-bold text-blue-600">REQ-{{ $kunjungan->id }}</p>
                        </div>
                        <div>
                            <small class="text-slate-400 font-bold uppercase">Status</small>
                            <p class="text-emerald-600 font-bold uppercase">SIAP DIKUNJUNGI</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between border-b border-dashed pb-1">
                            <span class="text-slate-500">Pengunjung</span>
                            <span class="font-bold uppercase">{{ $kunjungan->user->name ?? $kunjungan->nama_pengunjung }}</span>
                        </div>
                        <div class="flex justify-between border-b border-dashed pb-1">
                            <span class="text-slate-500">Tahanan Tujuan</span>
                            <span class="font-bold uppercase">{{ $kunjungan->nama_tahanan }}</span>
                        </div>
                        <div class="flex justify-between border-b border-dashed pb-1">
                            <span class="text-slate-500">Jadwal</span>
                            <span class="font-bold">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 bg-slate-800 p-8 flex flex-col items-center justify-center text-white">
                    <div class="bg-white p-2 rounded mb-2">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=REQ-{{ $kunjungan->id }}" class="w-24 h-24">
                    </div>
                    <p class="font-mono font-bold text-lg">REQ-{{ $kunjungan->id }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($kunjungan->status == 'disetujui')
    <div id="print-overlay">
        <div class="paper">

            <table class="kop-table">
                <tr>
                    <td style="width: 15%; text-align: center; vertical-align: top;">
                        <img src="{{ asset('assets/logo-kejari.png') }}" style="width: 90px;">
                    </td>
                    <td style="width: 85%; text-align: center;">
                        <div class="kop-1">KEJAKSAAN REPUBLIK INDONESIA</div>
                        <div class="kop-2">KEJAKSAAN TINGGI KALIMANTAN SELATAN</div>
                        <div class="kop-3">KEJAKSAAN NEGERI BANJARMASIN</div>
                        <div class="kop-alamat">Jl. Brig Jend. Hasan Basri No.3, Pangeran, Kota Banjarmasin, Kalimantan Selatan 70124</div>
                    </td>
                </tr>
            </table>
            <div style="border-bottom: 3px double black; margin-bottom: 25px; margin-top: 5px;"></div>

            <div class="judul">
                <h3>BUKTI REGISTRASI KUNJUNGAN ONLINE</h3>
                <p>NOMOR TIKET: <b>REQ-{{ $kunjungan->id }}</b></p>
            </div>

            <div class="isi">
                <p>Berdasarkan data pada Sistem Informasi Kunjungan Digital, dengan ini menerangkan bahwa:</p>

                <table class="data-table">
                    <tr>
                        <td width="200px">Nama Pengunjung</td>
                        <td width="20px">:</td>
                        <td class="value">{{ strtoupper($kunjungan->user->name ?? $kunjungan->nama_pengunjung) }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td class="value">{{ $kunjungan->nik_pengunjung ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td class="value">{{ $kunjungan->alamat_pengunjung ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Pengikut</td>
                        <td>:</td>
                        <td class="value">{{ $kunjungan->jumlah_pengikut }} Orang</td>
                    </tr>
                </table>

                <p style="margin-top: 15px;">Telah <b>DISETUJUI</b> untuk melakukan kunjungan kepada:</p>

                <table class="data-table">
                    <tr>
                        <td width="200px">Nama Tahanan</td>
                        <td width="20px">:</td>
                        <td class="value"><strong>{{ strtoupper($kunjungan->nama_tahanan) }}</strong></td>
                    </tr>
                    <tr>
                        <td>Lokasi / Kamar</td>
                        <td>:</td>
                        <td class="value">{{ strtoupper($kunjungan->nomor_kamar ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td>Jadwal Kunjungan</td>
                        <td>:</td>
                        <td class="value">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Sesi Waktu</td>
                        <td>:</td>
                        <td class="value">{{ $kunjungan->jam_kunjungan }} WITA</td>
                    </tr>
                </table>
            </div>

            <div class="box-bawah">
                <table width="100%" border="1" cellspacing="0" cellpadding="10" style="border-collapse: collapse;">
                    <tr>
                        <td width="30%" align="center" style="vertical-align: middle;">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=REQ-{{ $kunjungan->id }}" style="width: 140px; height: 140px;">
                            <br>
                            <b style="font-size: 14pt; font-family: monospace; display: block; margin-top: 5px;">REQ-{{ $kunjungan->id }}</b>
                        </td>
                        <td width="70%" valign="top">
                            <b style="text-decoration: underline;">INSTRUKSI PENGUNJUNG:</b>
                            <ol>
                                <li>Simpan bukti ini (Cetak atau Screenshot).</li>
                                <li>Datang <b>15 menit</b> sebelum jadwal kunjungan.</li>
                                <li>Tunjukkan bukti ini dan <b>KTP Asli</b> kepada petugas loket.</li>
                                <li>Dilarang membawa HP, Senjata, Narkoba, dan Barang Terlarang.</li>
                                <li>Patuhi seluruh tata tertib yang berlaku.</li>
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <p>Dokumen ini diterbitkan secara elektronik oleh Sistem Informasi Kejaksaan Negeri Banjarmasin.</p>
                <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }} WITA</p>
            </div>
        </div>
    </div>
    @endif

    <script>
        function printTiket() {
            var originalTitle = document.title;
            document.title = "";
            window.print();
            document.title = originalTitle;
        }
    </script>

    <style>
        /* Sembunyikan Overlay saat mode layar biasa */
        #print-overlay {
            display: none;
        }

        @media print {

            /* 1. KUNCI UTAMA: HILANGKAN HEADER BROWSER */
            @page {
                margin: 0;
                size: A4 portrait;
            }

            /* 2. SEMBUNYIKAN 'TUBUH' WEB TAPI JANGAN 'DISPLAY: NONE' */
            /* Kita pakai 'visibility: hidden' agar anak elemennya bisa 'visible' */
            body {
                visibility: hidden !important;
                background: white;
            }

            /* 3. TAMPILKAN HANYA TIKET KITA */
            #print-overlay {
                display: block !important;
                visibility: visible !important;
                /* INI KUNCINYA */
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 99999;
                background: white;
            }

            /* Container Kertas */
            .paper {
                width: 210mm;
                padding: 15mm 20mm;
                /* Margin aman */
                font-family: 'Times New Roman', serif;
                color: black;
            }

            /* STYLE SURAT */
            .kop-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 0px;
            }

            .kop-1 {
                font-size: 12pt;
                font-weight: bold;
            }

            .kop-2 {
                font-size: 14pt;
                font-weight: bold;
            }

            .kop-3 {
                font-size: 16pt;
                font-weight: 900;
                color: #166534;
                -webkit-print-color-adjust: exact;
                text-transform: uppercase;
            }

            .kop-alamat {
                font-size: 10pt;
                font-style: italic;
                margin-top: 2px;
            }

            .judul {
                text-align: center;
                margin-bottom: 25px;
            }

            .judul h3 {
                font-size: 16pt;
                text-decoration: underline;
                margin: 0;
                font-weight: bold;
            }

            .judul p {
                font-size: 12pt;
                margin: 5px 0;
            }

            .isi {
                font-size: 12pt;
                line-height: 1.5;
                margin-bottom: 20px;
            }

            .data-table {
                width: 100%;
                margin-left: 10px;
                margin-bottom: 10px;
            }

            .data-table td {
                padding: 4px 0;
                vertical-align: top;
            }

            .value {
                font-weight: bold;
                font-size: 12pt;
            }

            .box-bawah {
                width: 100%;
                margin-top: 20px;
            }

            .box-bawah ol {
                margin: 5px 0 0 0;
                padding-left: 20px;
            }

            .box-bawah li {
                margin-bottom: 5px;
            }

            .footer {
                margin-top: 30px;
                text-align: center;
                font-size: 10pt;
                font-style: italic;
                color: #555;
                border-top: 1px solid #ccc;
                padding-top: 5px;
            }
        }
    </style>
</x-app-layout>