<x-app-layout>

    <div class="web-view min-h-screen bg-slate-100 flex flex-col items-center py-10 px-4 font-sans">

        <div class="w-full max-w-3xl flex justify-between items-center mb-6">
            <a href="{{ route('masyarakat.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>

            @if($kunjungan->status == 'disetujui')
            <button onclick="printTiket()" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg hover:bg-[#F5C542] hover:text-slate-900 flex items-center gap-2 transition transform hover:-translate-y-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Tiket PDF
            </button>
            @endif
        </div>

        <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">

            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Detail Permohonan</h2>
                    <p class="text-sm text-slate-500">ID Tiket: <span class="font-mono font-bold">REQ-{{ $kunjungan->id }}</span></p>
                </div>
                <div>
                    @if($kunjungan->status == 'menunggu')
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 font-bold rounded-full text-sm border border-yellow-200 flex items-center gap-1">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span> Menunggu Verifikasi
                    </span>
                    @elseif($kunjungan->status == 'disetujui')
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 font-bold rounded-full text-sm border border-emerald-200 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Disetujui
                    </span>
                    @elseif($kunjungan->status == 'ditolak')
                    <span class="px-3 py-1 bg-red-100 text-red-700 font-bold rounded-full text-sm border border-red-200 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Ditolak
                    </span>
                    @endif
                </div>
            </div>

            @if($kunjungan->status == 'menunggu')
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                    <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Sedang Dalam Antrian</h3>
                <p class="text-slate-500 max-w-md mx-auto">
                    Data Anda sedang diperiksa oleh petugas piket. Harap cek kembali secara berkala dalam 10-15 menit.
                </p>
            </div>
            @elseif($kunjungan->status == 'ditolak')
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Permohonan Ditolak</h3>
                <div class="bg-red-50 border border-red-100 p-4 rounded-xl max-w-md mx-auto mt-4 text-left">
                    <p class="text-xs text-red-400 font-bold uppercase mb-1">Alasan Penolakan:</p>
                    <p class="text-red-700 font-medium">"{{ $kunjungan->alasan_penolakan ?? 'Data tidak sesuai / Kuota penuh.' }}"</p>
                </div>
                <p class="text-slate-500 text-sm mt-6">Silakan ajukan ulang dengan data yang benar.</p>
            </div>
            @else
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-2/3 p-8">
                    <h1 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">Informasi Kunjungan</h1>

                    <div class="space-y-4">
                        <div class="flex justify-between border-b border-dashed border-slate-200 pb-2">
                            <span class="text-slate-500 text-sm">Nama Pengunjung</span>
                            <span class="font-bold text-slate-800">{{ $kunjungan->user->name ?? $kunjungan->nama_pengunjung }}</span>
                        </div>
                        <div class="flex justify-between border-b border-dashed border-slate-200 pb-2">
                            <span class="text-slate-500 text-sm">Tahanan Tujuan</span>
                            <span class="font-bold text-slate-800">{{ $kunjungan->nama_tahanan }}</span>
                        </div>
                        <div class="flex justify-between border-b border-dashed border-slate-200 pb-2">
                            <span class="text-slate-500 text-sm">Tanggal Kunjungan</span>
                            <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex justify-between border-b border-dashed border-slate-200 pb-2">
                            <span class="text-slate-500 text-sm">Sesi Waktu</span>
                            <span class="font-bold text-slate-800 capitalize">{{ $kunjungan->sesi }} ({{ $kunjungan->jam_kunjungan }})</span>
                        </div>
                        <div class="flex justify-between border-b border-dashed border-slate-200 pb-2">
                            <span class="text-slate-500 text-sm">Jumlah Pengikut</span>
                            <span class="font-bold text-slate-800">{{ $kunjungan->jumlah_pengikut }} Orang</span>
                        </div>
                    </div>

                    <div class="mt-6 bg-blue-50 p-4 rounded-xl border border-blue-100 flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-blue-800 leading-relaxed">
                            Simpan QR Code di samping. Tunjukkan kepada petugas di gerbang masuk Rutan untuk proses Check-In.
                        </p>
                    </div>
                </div>

                <div class="w-full md:w-1/3 bg-slate-900 p-8 flex flex-col items-center justify-center text-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

                    <div class="relative z-10 bg-white p-3 rounded-xl shadow-2xl mb-4 transform hover:scale-105 transition duration-300">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=REQ-{{ $kunjungan->id }}" class="w-32 h-32">
                    </div>

                    <div class="relative z-10">
                        <p class="text-slate-400 text-xs uppercase tracking-widest font-bold mb-1">Kode Booking</p>
                        <p class="font-mono font-bold text-2xl text-[#F5C542]">REQ-{{ $kunjungan->id }}</p>
                        <div class="mt-4 px-3 py-1 bg-emerald-500 text-white text-[10px] font-bold rounded-full uppercase tracking-wider">
                            VALID / AKTIF
                        </div>
                    </div>
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
                <h3>E-TIKET KUNJUNGAN TAHANAN</h3>
                <p>NOMOR TIKET: <b>REQ-{{ $kunjungan->id }}</b></p>
            </div>

            <div class="isi">
                <p>Berdasarkan data permohonan yang masuk pada Sistem Informasi Pelayanan Rutan (SIP-RUTAN), menerangkan bahwa:</p>

                <table class="data-table" style="margin-top: 20px;">
                    <tr>
                        <td width="180px">Nama Pengunjung</td>
                        <td width="20px">:</td>
                        <td class="value">{{ strtoupper($kunjungan->user->name ?? $kunjungan->nama_pengunjung) }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td class="value">{{ $kunjungan->user->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Pengikut</td>
                        <td>:</td>
                        <td class="value">{{ $kunjungan->jumlah_pengikut }} Orang</td>
                    </tr>
                </table>

                <div style="background-color: #f0fdf4; border: 1px solid #16a34a; padding: 15px; margin: 20px 0;">
                    <p style="margin:0; font-weight:bold; color: #166534; text-align:center;">TELAH DISETUJUI UNTUK MENGUNJUNGI:</p>
                </div>

                <table class="data-table">
                    <tr>
                        <td width="180px">Nama Tahanan</td>
                        <td width="20px">:</td>
                        <td class="value" style="font-size: 14pt;">{{ strtoupper($kunjungan->nama_tahanan) }}</td>
                    </tr>
                    <tr>
                        <td>Jadwal Kunjungan</td>
                        <td>:</td>
                        <td class="value">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Sesi Waktu</td>
                        <td>:</td>
                        <td class="value">{{ ucfirst($kunjungan->sesi) }} ({{ $kunjungan->jam_kunjungan }} WITA)</td>
                    </tr>
                </table>
            </div>

            <div class="box-bawah">
                <table width="100%" border="1" cellspacing="0" cellpadding="15" style="border-collapse: collapse; border-color: #000;">
                    <tr>
                        <td width="30%" align="center" style="vertical-align: middle; background-color: #f8fafc;">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=REQ-{{ $kunjungan->id }}" style="width: 130px; height: 130px;">
                            <br>
                            <span style="font-family: monospace; font-size: 14pt; font-weight: bold; display: block; margin-top: 10px;">REQ-{{ $kunjungan->id }}</span>
                        </td>
                        <td width="70%" valign="top">
                            <b style="text-decoration: underline;">CATATAN PENTING:</b>
                            <ol style="margin-top: 5px; padding-left: 20px; font-size: 11pt; line-height: 1.6;">
                                <li>Tiket ini wajib dibawa (Cetak/Digital) saat berkunjung.</li>
                                <li>Datang <b>15 menit</b> sebelum jadwal untuk pemeriksaan barang.</li>
                                <li>Wajib membawa <b>KTP Asli</b> yang berlaku.</li>
                                <li>Dilarang keras membawa HP, Senjata, dan Narkoba.</li>
                                <li>Pelanggaran tata tertib akan dikenakan sanksi blacklist.</li>
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <p>Dokumen ini sah dan diterbitkan secara elektronik oleh Sistem Kejaksaan Negeri Banjarmasin.</p>
                <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }} WITA | Oleh: {{ Auth::user()->name }}</p>
                <div style="margin-top: 10px; border-top: 1px solid #ccc; padding-top: 5px; font-size: 8pt;">
                    Scan QR Code di atas untuk validasi keaslian dokumen.
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        function printTiket() {
            var originalTitle = document.title;
            document.title = "TIKET-{{ $kunjungan->id }}-{{ \Illuminate\Support\Str::slug($kunjungan->nama_tahanan) }}";
            window.print();
            document.title = originalTitle;
        }
    </script>

    <style>
        #print-overlay {
            display: none;
        }

        @media print {
            @page {
                margin: 0;
                size: A4 portrait;
            }

            body {
                visibility: hidden !important;
                background: white;
            }

            #print-overlay {
                display: block !important;
                visibility: visible !important;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 99999;
                background: white;
            }

            .paper {
                width: 210mm;
                padding: 15mm 20mm;
                font-family: 'Times New Roman', serif;
                color: black;
            }

            /* CSS KOP SURAT */
            .kop-table {
                width: 100%;
                border-collapse: collapse;
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
                text-transform: uppercase;
            }

            .kop-alamat {
                font-size: 10pt;
                font-style: italic;
                margin-top: 2px;
            }

            .judul {
                text-align: center;
                margin-bottom: 20px;
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

            .footer {
                margin-top: 40px;
                text-align: center;
                font-size: 10pt;
                font-style: italic;
                color: #555;
            }
        }
    </style>
</x-app-layout>