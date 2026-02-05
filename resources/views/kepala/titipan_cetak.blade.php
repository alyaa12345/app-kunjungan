<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Titipan Barang</title>
    <style>
        /* CSS KHUSUS CETAK PDF */
        @media print {
            @page {
                margin: 0;
                size: A4 portrait;
            }

            body {
                margin: 2cm;
            }

            .no-print {
                display: none !important;
            }
        }

        /* TAMPILAN UMUM */
        body {
            font-family: 'Times New Roman', serif;
            color: black;
            background: white;
            font-size: 12pt;
        }

        /* KOP SURAT */
        .kop-surat {
            width: 100%;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-surat td {
            vertical-align: middle;
        }

        .logo {
            width: 90px;
            height: auto;
        }

        .kop-text {
            text-align: center;
        }

        .kop-instansi {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-alamat {
            font-size: 10pt;
            margin-top: 5px;
        }

        /* JUDUL LAPORAN */
        .judul-laporan {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 12pt;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* TABEL DATA */
        .table-data {
            width: 100%;
            border-collapse: collapse;
        }

        .table-data th,
        .table-data td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: top;
        }

        .table-data th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        /* TANDA TANGAN */
        .ttd-container {
            width: 100%;
            margin-top: 50px;
        }

        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        /* TOMBOL MENU (Hanya tampil di Layar) */
        .action-bar {
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-family: sans-serif;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-back {
            background: #64748b;
            color: white;
        }

        .btn-print {
            background: #0f172a;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

    <div class="action-bar no-print">
        <a href="{{ route('kepala.titipan') }}" class="btn btn-back">
            <span>&larr;</span> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-print">
            <span>&#128424;</span> Simpan PDF / Cetak
        </button>
    </div>

    <table class="kop-surat">
        <tr>
            <td width="15%" align="center">
                <img src="{{ asset('assets/logo-kejari.png') }}" class="logo" alt="Logo">
            </td>
            <td width="85%" align="center">
                <div class="kop-text">
                    <div class="kop-instansi">KEJAKSAAN REPUBLIK INDONESIA</div>
                    <div class="kop-instansi">KEJAKSAAN NEGERI BANJARMASIN</div>
                    <div class="kop-alamat">
                        Jl. Brig Jend. Hasan Basri No.3, Pangeran, Kec. Banjarmasin Utara,<br>
                        Kota Banjarmasin, Kalimantan Selatan 70124 | Telp. (0511)-3300402
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="judul-laporan">
        LAPORAN REKAPITULASI TITIPAN BARANG
    </div>
    <p style="text-align: center; margin-bottom: 20px;">
        Laporan per Tanggal: {{ date('d F Y') }}
    </p>

    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal</th>
                <th width="35%">Pengirim</th>
                <th width="25%">Tahanan Tujuan</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="center">{{ $item->created_at->format('d/m/Y') }}<br><small>{{ $item->created_at->format('H:i') }}</small></td>
                <td>
                    <strong>{{ $item->user->name ?? $item->nama_pengirim ?? 'Tanpa Nama' }}</strong>
                    @if($item->hubungan)
                    <br><small>Hub: {{ $item->hubungan }}</small>
                    @endif
                </td>
                <td class="center" style="text-transform: uppercase;">{{ $item->nama_tahanan }}</td>
                <td class="center" style="font-weight: bold;">
                    {{ strtoupper($item->status) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="center" style="padding: 20px;">Tidak ada data titipan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Banjarmasin, {{ date('d F Y') }}</p>
            <p>Mengetahui,</p>
            <p><b>Kepala Kesatuan Pengamanan</b></p>
            <br><br><br><br>
            <p style="text-decoration: underline; font-weight: bold;">{{ Auth::user()->name }}</p>
            <p>NIP. ...........................</p>
        </div>
    </div>

</body>

</html>