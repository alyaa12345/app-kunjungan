@php
// PERINTAH SAKTI UNTUK MEMAKSA BROWSER MENDOWNLOAD SEBAGAI FILE EXCEL
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pelayanan_Kunjungan_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
@endphp

<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th colspan="5" style="font-size: 16px; font-weight: bold; text-align: center; height: 40px;">
                REKAPITULASI LAPORAN PELAYANAN KUNJUNGAN
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center; height: 30px;">
                Periode: {{ strtoupper($filter_type) }} | Status: {{ strtoupper($status) }}
            </th>
        </tr>
        <tr>
            <th style="background-color: #f3f4f6; font-weight: bold; width: 50px;">No</th>
            <th style="background-color: #f3f4f6; font-weight: bold; width: 200px;">Nama Pengunjung</th>
            <th style="background-color: #f3f4f6; font-weight: bold; width: 150px;">Hubungan</th>
            <th style="background-color: #f3f4f6; font-weight: bold; width: 200px;">Nama Tahanan (Tujuan)</th>
            <th style="background-color: #f3f4f6; font-weight: bold; width: 150px;">Status Akhir</th>
        </tr>
    </thead>
    <tbody>
        @forelse($laporan_detail as $index => $ld)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $ld->nama_pengunjung }}</td>
            <td style="text-align: center;">{{ $ld->hubungan_tahanan }}</td>
            <td>{{ $ld->nama_tahanan }}</td>
            <td style="text-align: center; text-transform: uppercase;">{{ $ld->status }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align: center; font-style: italic;">Tidak ada data pada periode ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>