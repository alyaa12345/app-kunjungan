@if(!isset($is_download) || !$is_download)
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Preview Laporan Excel</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f3f4f6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-group {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            text-decoration: none;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-back {
            background: #64748b;
        }

        .btn-download {
            background: #166534;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="btn-group">
            <a href="{{ route('petugas.laporan.index') }}" class="btn btn-back">&larr; Kembali</a>
            <a href="{{ route('petugas.laporan.excel', ['action' => 'download']) }}" class="btn btn-download">Download File Excel &darr;</a>
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th colspan="7" style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-align: center;">
                        KEJAKSAAN REPUBLIK INDONESIA
                    </th>
                </tr>
                <tr>
                    <th colspan="7" style="font-family: Arial, sans-serif; font-size: 16px; font-weight: bold; text-align: center;">
                        KEJAKSAAN TINGGI KALIMANTAN SELATAN
                    </th>
                </tr>
                <tr>
                    <th colspan="7" style="font-family: Arial, sans-serif; font-size: 20px; font-weight: 900; text-align: center; color: #000000;">
                        KEJAKSAAN NEGERI BANJARMASIN
                    </th>
                </tr>
                <tr>
                    <th colspan="7" style="font-family: Arial, sans-serif; font-size: 10px; font-style: italic; text-align: center;">
                        Jl. Brig Jend. Hasan Basri No.3, Rw.02, Pangeran, Kec. Banjarmasin Utara, Kota Banjarmasin
                    </th>
                </tr>
                <tr>
                    <th colspan="7" style="font-family: Arial, sans-serif; font-size: 10px; font-style: italic; text-align: center; border-bottom: 3px double #000;">
                        Kalimantan Selatan 70124 | Telp. (0511)-3300402 www.kejari-banjarmasin.go.id
                    </th>
                </tr>

                <tr>
                    <th colspan="7"></th>
                </tr>

                <tr>
                    <th colspan="7" style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-align: center; text-decoration: underline;">
                        LAPORAN REKAPITULASI KUNJUNGAN TAHANAN
                    </th>
                </tr>
                <tr>
                    <th colspan="7" style="font-family: Arial, sans-serif; font-size: 11px; text-align: center;">
                        Dicetak Pada: {{ date('d F Y') }}
                    </th>
                </tr>
                <tr>
                    <th colspan="7"></th>
                </tr>

                <tr>
                    <th style="border: 1px solid #000; background: #d1d5db; width: 40px; text-align: center; font-weight: bold;">NO</th>
                    <th style="border: 1px solid #000; background: #d1d5db; width: 100px; text-align: center; font-weight: bold;">TANGGAL</th>
                    <th style="border: 1px solid #000; background: #d1d5db; width: 250px; text-align: center; font-weight: bold;">NAMA PENGUNJUNG</th>
                    <th style="border: 1px solid #000; background: #d1d5db; width: 150px; text-align: center; font-weight: bold;">TAHANAN TUJUAN</th>
                    <th style="border: 1px solid #000; background: #d1d5db; width: 250px; text-align: center; font-weight: bold;">KEPERLUAN</th>
                    <th style="border: 1px solid #000; background: #d1d5db; width: 100px; text-align: center; font-weight: bold;">STATUS</th>
                    <th style="border: 1px solid #000; background: #fef08a; width: 150px; text-align: center; font-weight: bold;">VERIFIKATOR</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $item)
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">{{ $index + 1 }}</td>
                    <td style="border: 1px solid #000; text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                    <td style="border: 1px solid #000;">{{ $item->user->name ?? $item->nama_pengunjung }}</td>
                    <td style="border: 1px solid #000; text-transform: uppercase;">{{ $item->nama_tahanan }}</td>
                    <td style="border: 1px solid #000;">{{ $item->keperluan }}</td>
                    <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ strtoupper($item->status) }}</td>
                    <td style="border: 1px solid #000; text-align: center; font-style: italic;">{{ $item->petugas->name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2" style="text-align: center; font-family: Arial, sans-serif; font-size: 11px;">
                        Banjarmasin, {{ date('d F Y') }} <br> Petugas Pelayanan,
                    </td>
                </tr>
                <tr>
                    <td colspan="7" style="height: 60px;"></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2" style="text-align: center; font-family: Arial, sans-serif; font-weight: bold; text-decoration: underline;">
                        {{ Auth::user()->name }}
                    </td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2" style="text-align: center; font-family: Arial, sans-serif; font-size: 10px;">
                        NIP. ...........................
                    </td>
                </tr>
            </tfoot>
        </table>

        @if(!isset($is_download) || !$is_download)
    </div>
</body>

</html>
@endif