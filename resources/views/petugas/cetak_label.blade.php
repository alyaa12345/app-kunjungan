<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Titipan #{{ $titipan->id }}</title>
    <style>
        /* RESET DEFAULT BROWSER STYLES FOR PRINTING */
        @page {
            margin: 0;
            /* Ini KUNCI untuk menghilangkan header/footer bawaan browser (tanggal, URL, dll) */
            size: A4 portrait;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            color: #000;
            background: #eee;
            /* Background abu di layar biar kelihatan batas kertasnya */
        }

        /* KONTAINER UTAMA A4 */
        .container {
            width: 210mm;
            min-height: 297mm;
            /* Tinggi A4 */
            margin: 20px auto;
            /* Margin di layar */
            background: white;
            padding: 20mm;
            /* Padding dalam kertas A4 */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            position: relative;
        }

        /* HEADER KOP SURAT (PERBAIKAN LOGO RATA TENGAH) */
        .header {
            display: flex;
            /* Menggunakan Flexbox */
            align-items: center;
            /* Sejajarkan item secara vertikal di tengah */
            justify-content: center;
            /* Sejajarkan item secara horizontal di tengah */
            border-bottom: 3px double #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
            position: relative;
        }

        .logo-container {
            position: absolute;
            left: 0;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .header img {
            width: 90px;
            /* Ukuran logo sedikit diperbesar biar gagah */
            height: auto;
        }

        .header-text {
            text-align: center;
            /* Memberi margin kiri agar teks benar-benar di tengah kertas, tidak terdorong logo */
            margin-left: 40px;
        }

        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .header p {
            font-size: 11pt;
            font-style: italic;
            margin: 0;
        }

        /* JUDUL DOKUMEN */
        .judul {
            text-align: center;
            margin-bottom: 30px;
        }

        .judul h3 {
            font-size: 16pt;
            text-decoration: underline;
            margin: 0;
            text-transform: uppercase;
            font-weight: 900;
        }

        .judul p {
            font-size: 12pt;
            margin: 10px 0;
        }

        /* TABEL INFO */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12pt;
        }

        .info-table td {
            padding: 8px 5px;
            vertical-align: top;
        }

        .label {
            width: 180px;
            font-weight: bold;
        }

        .sep {
            width: 20px;
            text-align: center;
        }

        /* KOTAK BARANG */
        .box-barang {
            border: 2px solid #000;
            padding: 15px;
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 40px;
            background-color: #f9f9f9;
        }

        /* TANDA TANGAN */
        .ttd-wrapper {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            padding: 0 30px;
            page-break-inside: avoid;
        }

        .ttd {
            text-align: center;
            width: 220px;
        }

        .ttd p {
            margin-bottom: 90px;
            font-weight: bold;
            font-size: 12pt;
        }

        .ttd span {
            font-weight: bold;
            text-decoration: underline;
            display: block;
            font-size: 12pt;
        }

        /* BAGIAN LABEL TEMPEL (BAWAH) */
        .label-tempel-wrapper {
            position: absolute;
            bottom: 20mm;
            left: 20mm;
            right: 20mm;
            page-break-inside: avoid;
        }

        .label-tempel {
            border-top: 2px dashed #000;
            padding-top: 15px;
        }

        .gunting-icon {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 15px;
            font-style: italic;
            font-weight: bold;
        }

        .qr-box {
            border: 3px solid #000;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        /* TOMBOL PRINT */
        .no-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #000;
            color: #fff;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* CSS KHUSUS SAAT PRINT */
        @media print {
            .no-print {
                display: none;
            }

            body {
                background: none;
            }

            .container {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                /* Padding dikontrol oleh margin @page */
                box-shadow: none;
                border: none;
            }

            /* Penyesuaian posisi saat print agar pas */
            .container {
                padding: 20mm;
            }

            .label-tempel-wrapper {
                bottom: 20mm;
                left: 20mm;
                right: 20mm;
            }

            .logo-container {
                left: 0;
            }
        }
    </style>
</head>

<body>

    <button onclick="window.print()" class="no-print">🖨 CETAK DOKUMEN (A4)</button>

    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('assets/logo-kejari.png') }}" alt="Logo">
            </div>
            <div class="header-text">
                <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
                <h2>LAYANAN KUNJUNGAN & TITIPAN TAHANAN</h2>
                <p>Jl. Brig Jend. Hasan Basri No.3, Kota Banjarmasin, Kalimantan Selatan</p>
            </div>
        </div>

        <div class="judul">
            <h3>BUKTI TANDA TERIMA TITIPAN</h3>
            <p>NOMOR REGISTRASI: <strong>#TRX-{{ $titipan->id }}</strong></p>
        </div>

        <table class="info-table">
            <tr>
                <td class="label">TANGGAL & WAKTU</td>
                <td class="sep">:</td>
                <td>{{ \Carbon\Carbon::parse($titipan->created_at)->translatedFormat('l, d F Y - H:i') }} WITA</td>
            </tr>
            <tr>
                <td class="label">NAMA PENGIRIM</td>
                <td class="sep">:</td>
                <td>{{ strtoupper($titipan->user->name ?? 'Anonim') }}</td>
            </tr>
            <tr>
                <td class="label">TUJUAN TAHANAN</td>
                <td class="sep">:</td>
                <td><strong>{{ strtoupper($titipan->nama_tahanan) }}</strong></td>
            </tr>
            <tr>
                <td class="label">JENIS TITIPAN</td>
                <td class="sep">:</td>
                <td>{{ strtoupper($titipan->jenis_titipan) }}</td>
            </tr>
        </table>

        <div style="font-weight: bold; margin-bottom: 10px; font-size: 12pt;">DETAIL ISI BARANG:</div>
        <div class="box-barang">
            {{ $titipan->deskripsi_barang }}
        </div>

        <div class="ttd-wrapper">
            <div class="ttd">
                <p>Banjarmasin, {{ date('d F Y') }}<br>Pengirim,</p>
                <span>{{ strtoupper($titipan->user->name ?? '....................') }}</span>
            </div>
            <div class="ttd">
                <p>Petugas Pemeriksa,</p>
                <span>{{ strtoupper(Auth::user()->name) }}</span>
            </div>
        </div>

        <div class="label-tempel-wrapper">
            <div class="label-tempel">
                <div class="gunting-icon">✂ --- Potong di garis ini untuk label barang --- ✂</div>

                <div class="qr-box">
                    <div style="margin-right: 20px;">
                        {{-- Gunakan API QR Code yang lebih stabil (Google Chart API sudah deprecated, ganti ke goqr.me atau sejenisnya) --}}
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ 'TITIPAN-ID-'.$titipan->id }}" width="100" height="100">
                    </div>
                    <div style="flex-grow: 1;">
                        <span style="font-size: 11pt; font-weight: bold;">UNTUK TAHANAN:</span><br>
                        <span style="font-size: 20pt; font-weight: 900; display: block; margin: 5px 0;">{{ strtoupper($titipan->nama_tahanan) }}</span>
                        <span style="font-size: 11pt;">DARI: {{ strtoupper(\Illuminate\Support\Str::limit($titipan->user->name ?? 'Anonim', 25)) }}</span>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 16pt; font-weight: 900;">#{{ $titipan->id }}</span><br>
                        <span style="font-size: 12pt; font-weight: bold; background: #eee; padding: 2px 5px;">{{ strtoupper($titipan->jenis_titipan) }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>