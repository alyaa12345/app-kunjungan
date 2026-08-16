<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tanda Terima Titipan - #{{ $titipan->id }}</title>
    <style>
        /* Pengaturan layaknya tampilan kertas A4 di PDF */
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #525659;
            /* Warna abu-abu background layar */
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .kertas {
            background-color: white;
            width: 210mm;
            /* Lebar A4 */
            min-height: 297mm;
            /* Tinggi A4 */
            padding: 2cm;
            /* Margin dalam kertas */
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        /* --- KOP SURAT --- */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 4px solid black;
            /* Garis tebal bawah kop */
            padding-bottom: 10px;
            margin-bottom: 2px;
        }

        .garis-bawah {
            border-bottom: 1px solid black;
            /* Garis tipis bawah kop */
            margin-bottom: 30px;
        }

        .logo {
            width: 90px;
            height: auto;
            margin-right: 20px;
        }

        .teks-kop {
            text-align: center;
            flex-grow: 1;
            padding-right: 90px;
            /* Biar teksnya simetris ke tengah */
        }

        .teks-kop h1,
        .teks-kop h2,
        .teks-kop p {
            margin: 0;
            line-height: 1.3;
        }

        .teks-kop h2 {
            font-size: 20px;
            font-weight: normal;
        }

        .teks-kop h1 {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .teks-kop p {
            font-size: 13px;
        }

        /* --- ISI SURAT --- */
        .judul-surat {
            text-align: center;
            margin-bottom: 40px;
        }

        .judul-surat h3 {
            margin: 0;
            text-decoration: underline;
            font-size: 18px;
        }

        .judul-surat p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }

        .paragraf {
            text-align: justify;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .tabel-info {
            width: 90%;
            margin: 0 auto 30px auto;
            /* Posisi tabel simetris di tengah */
            border-collapse: collapse;
            font-size: 16px;
        }

        .tabel-info td {
            padding: 8px 5px;
            vertical-align: top;
        }

        .tabel-info td:first-child {
            width: 35%;
            font-weight: bold;
        }

        .tabel-info td:nth-child(2) {
            width: 5%;
            text-align: center;
        }

        /* --- TANDA TANGAN & QR --- */
        .footer-surat {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 50px;
        }

        .qr-code {
            text-align: center;
            border: 2px dashed #333;
            padding: 10px;
            border-radius: 8px;
        }

        .qr-code img {
            width: 100px;
            height: 100px;
        }

        .tanda-tangan {
            text-align: center;
            width: 250px;
        }

        .tanda-tangan p {
            margin: 0;
            font-size: 16px;
        }

        .nama-terang {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Mode Print: Menghilangkan bayangan dan menyesuaikan ukuran murni kertas */
        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .kertas {
                box-shadow: none;
                width: 100%;
                padding: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="kertas">
        <div class="kop-surat">
            <img src="{{ asset('assets/logo-kejari.png') }}" class="logo" alt="Logo">
            <div class="teks-kop">
                <h2>KEJAKSAAN REPUBLIK INDONESIA</h2>
                <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
                <p>Jl. Brigjen H. Hasan Basri No.3, Kayu Tangi, Banjarmasin, Kalimantan Selatan 70123</p>
                <p>Telp: (0511) 3301389 | Email: kejari.banjarmasin@kejaksaan.go.id</p>
            </div>
        </div>
        <div class="garis-bawah"></div>

        <div class="judul-surat">
            <h3>SURAT TANDA TERIMA TITIPAN BARANG</h3>
            <p>Nomor Registrasi: #{{ sprintf('%05d', $titipan->id) }}</p>
        </div>

        <div class="paragraf">
            Diberitahukan bahwa pada hari ini, tanggal <strong>{{ \Carbon\Carbon::parse($titipan->created_at)->translatedFormat('d F Y') }}</strong>, permohonan penitipan barang telah melalui tahapan verifikasi administratif dengan rincian data sebagai berikut:
        </div>

        <table class="tabel-info">
            <tr>
                <td>Nama Pengirim</td>
                <td>:</td>
                <td>{{ $titipan->user->name ?? 'Tidak diketahui' }}</td>
            </tr>
            <tr>
                <td>Nomor Kontak / WA</td>
                <td>:</td>
                <td>{{ $titipan->user->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tujuan (Nama Tahanan)</td>
                <td>:</td>
                <td><strong>{{ strtoupper($titipan->nama_tahanan) }}</strong></td>
            </tr>
            <tr>
                <td>Status Permohonan</td>
                <td>:</td>
                <td><strong>DISETUJUI (ADMINISTRATIF)</strong></td>
            </tr>
        </table>

        <div class="paragraf">
            Surat ini merupakan dokumen yang sah. Harap membawa surat atau menunjukkan kode QR di bawah ini beserta barang titipan ke Pos Penjagaan Rutan. Barang akan diserahkan kepada tahanan bersangkutan setelah melalui proses pengecekan wujud fisik (SOP Keamanan) oleh Petugas Sipir Lapas.
        </div>

        <div class="footer-surat">
            <div class="qr-code">
                <p style="font-size: 12px; margin-bottom: 8px; font-weight: bold;">Scan Validasi Gate Check</p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TITIPAN-{{ $titipan->id }}" alt="QR Code">
            </div>

            <div class="tanda-tangan">
                <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p>Petugas Verifikator,</p>
                <div class="nama-terang">.....................................................</div>
                <p>NIP. </p>
            </div>
        </div>

    </div>

</body>

</html>