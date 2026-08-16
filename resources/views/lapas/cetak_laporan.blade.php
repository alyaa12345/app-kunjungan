<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Mutasi Lapas</title>
    <style>
        /* Pengaturan Dasar Kertas */
        @page {
            size: A4 portrait;
            margin: 2cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: black;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 2px;
        }

        .kop-garis-bawah {
            border-bottom: 1px solid black;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .teks-kop {
            flex: 1;
            text-align: center;
        }

        .teks-kop h1 {
            font-size: 14pt;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
        }

        .teks-kop h2 {
            font-size: 16pt;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
        }

        .teks-kop p {
            font-size: 10pt;
            margin: 5px 0 0 0;
        }

        /* Judul Laporan */
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-laporan h3 {
            font-size: 14pt;
            margin: 0;
            text-decoration: underline;
            font-weight: bold;
        }

        .judul-laporan p {
            font-size: 11pt;
            margin: 5px 0 0 0;
        }

        /* Ringkasan */
        .ringkasan {
            margin-bottom: 20px;
            text-align: justify;
            line-height: 1.5;
        }

        .table-ringkasan {
            width: auto;
            margin-top: 10px;
            margin-left: 20px;
            border: none;
        }

        .table-ringkasan td {
            padding: 2px 10px 2px 0;
            border: none;
            font-size: 11pt;
            font-weight: bold;
        }

        /* Tabel Rincian Data */
        h4 {
            margin-bottom: 8px;
            font-size: 12pt;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .table-data th,
        .table-data td {
            border: 1px solid black;
            padding: 8px;
            font-size: 11pt;
        }

        .table-data th {
            text-align: center;
            font-weight: bold;
            background-color: #f3f4f6;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .text-center {
            text-align: center;
        }

        .uppercase {
            text-transform: uppercase;
        }

        /* Tanda Tangan */
        .tanda-tangan {
            float: right;
            text-align: center;
            width: 250px;
        }

        .tanda-tangan p {
            margin: 0;
            line-height: 1.5;
        }

        .nama-terang {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 80px !important;
        }
    </style>
</head>

<body>

    <div class="kop-surat">
        <div>
            <img src="{{ asset('assets/logo-kejari.png') }}" class="logo" alt="Logo">
        </div>
        <div class="teks-kop">
            <h1>Kementerian Hukum dan Hak Asasi Manusia RI</h1>
            <h2>Rumah Tahanan Negara Kelas IIA Banjarmasin</h2>
            <p>Jl. Letjen Suprapto No.1, Antasan Besar, Kec. Banjarmasin Tengah, Kalimantan Selatan 70114</p>
        </div>
        <div style="width: 80px;"></div>
    </div>
    <div class="kop-garis-bawah"></div>

    <div class="judul-laporan">
        <h3>LAPORAN HARIAN MUTASI PINTU UTAMA</h3>
        <p>Tanggal Laporan: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
    </div>

    <div class="ringkasan">
        <p>Berdasarkan data operasional registrasi pos penjagaan utama pada tanggal <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</strong>, berikut adalah rincian rekapitulasi data mutasi layanan kunjungan tatap muka dan penitipan barang Warga Binaan Pemasyarakatan (WBP):</p>

        <table class="table-ringkasan">
            <tr>
                <td>Total Kunjungan Hadir (Selesai)</td>
                <td>: {{ $checkInBerhasil }} Pengunjung</td>
            </tr>
            <tr>
                <td>Kunjungan Belum Hadir</td>
                <td>: {{ $belumHadir }} Pengunjung</td>
            </tr>
            <tr>
                <td>Barang Titipan Diserahkan</td>
                <td>: {{ $titipanSelesai }} Transaksi</td>
            </tr>
            <tr>
                <td>Barang Titipan Belum Diambil</td>
                <td>: {{ $titipanBelum }} Transaksi</td>
            </tr>
        </table>
    </div>

    <h4>Daftar Rincian Pemohon:</h4>
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Jenis Layanan</th>
                <th style="width: 30%;">Nama Pemohon</th>
                <th style="width: 30%;">Warga Binaan (Tujuan)</th>
                <th style="width: 15%;">Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @php $noPrint = 1; @endphp
            @foreach($dataKunjungan as $k)
            <tr>
                <td class="text-center">{{ $noPrint++ }}</td>
                <td>Kunjungan Fisik</td>
                <td>{{ $k->nama_pengunjung }}</td>
                <td>{{ $k->nama_tahanan }}</td>
                <td class="text-center uppercase">{{ $k->status }}</td>
            </tr>
            @endforeach
            @foreach($dataTitipan as $t)
            <tr>
                <td class="text-center">{{ $noPrint++ }}</td>
                <td>Titipan Barang</td>
                <td>{{ $t->user->name ?? 'Anonim' }}</td>
                <td>{{ $t->nama_tahanan }}</td>
                <td class="text-center uppercase">{{ $t->status }}</td>
            </tr>
            @endforeach

            @if($dataKunjungan->isEmpty() && $dataTitipan->isEmpty())
            <tr>
                <td colspan="5" class="text-center" style="font-style: italic; color: #666;">Tidak ada rekam jejak operasional untuk tanggal ini.</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="tanda-tangan">
        <p>Banjarmasin, {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
        <p>Petugas Jaga Pos Utama</p>
        <p class="nama-terang">( __________________________ )</p>
        <p>NIP. ........................................</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>