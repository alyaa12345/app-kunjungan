<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Kunjungan Resmi</title>
    <style>
        /* A. STYLE UMUM (AGAR RAPI DI EXCEL & BROWSER) */
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            color: #000;
        }

        /* Table Styling Standar */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* B. STYLE KHUSUS MODE PREVIEW (TAMPILAN WEB) */
        @if(isset($isPreview) && $isPreview) body {
            background-color: #f3f4f6;
            /* Abu-abu muda */
            margin: 0;
            padding-bottom: 50px;
        }

        /* Navbar (Floating Header) */
        .nav-bar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #e5e7eb;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* Tombol-tombol */
        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-back {
            background-color: white;
            color: #374151;
            border-color: #d1d5db;
        }

        .btn-back:hover {
            background-color: #f3f4f6;
        }

        .btn-download {
            background-color: #16a34a;
            color: white;
            box-shadow: 0 2px 4px rgba(22, 163, 74, 0.2);
        }

        .btn-download:hover {
            background-color: #15803d;
        }

        /* Kertas A4 (Container Laporan) */
        .paper-container {
            width: 210mm;
            /* Lebar A4 Standar */
            min-height: 297mm;
            /* Tinggi A4 */
            margin: 0 auto;
            background: white;
            padding: 15mm 20mm;
            /* Margin Kertas */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border: 1px solid #d1d5db;
            position: relative;
        }

        @endif

        /* C. STYLE UNTUK TABEL DATA (BORDER) */
        .data-table th, .data-table td {
            border: 1px solid #000000;
            padding: 8px 6px;
            /* Padding biar lega */
            vertical-align: middle;
            /* Pastikan teks di tengah vertikal */
        }

        .data-table th {
            background-color: #e5e7eb;
            /* Abu-abu Excel */
            text-align: center;
            font-weight: bold;
            height: 35px;
        }

        /* Helper Classes */
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .font-serif {
            font-family: 'Times New Roman', serif;
        }

        .no-border {
            border: none !important;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>

    {{-- 1. BAGIAN NAVIGASI (HANYA MUNCUL DI PREVIEW) --}}
    @if(isset($isPreview) && $isPreview)
    <div class="nav-bar">
        <div>
            <h1 style="margin: 0; font-size: 18px; color: #111827;">Preview Laporan</h1>
            <p style="margin: 0; font-size: 13px; color: #6b7280;">Silakan periksa tampilan sebelum mengunduh.</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('kepala.laporan.index') }}" class="btn btn-back">
                &larr; Kembali
            </a>
            <a href="{{ route('kepala.laporan.download', request()->all()) }}" class="btn btn-download">
                Download .XLS
            </a>
        </div>
    </div>

    <div class="paper-container">
        @endif


        {{-- 2. KONTEN LAPORAN (KOP, TABEL, TTD) --}}

        <table style="width: 100%; margin-bottom: 25px;">
            <tr>
                <td colspan="6" class="no-border text-center font-serif font-bold" style="font-size: 12pt;">
                    KEJAKSAAN REPUBLIK INDONESIA
                </td>
            </tr>
            <tr>
                <td colspan="6" class="no-border text-center font-serif font-bold" style="font-size: 14pt;">
                    KEJAKSAAN TINGGI KALIMANTAN SELATAN
                </td>
            </tr>
            <tr>
                <td colspan="6" class="no-border text-center font-serif font-bold" style="font-size: 16pt; color: #166534;">
                    KEJAKSAAN NEGERI BANJARMASIN
                </td>
            </tr>
            <tr>
                <td colspan="6" class="no-border text-center font-serif" style="font-size: 10pt; font-style: italic; border-bottom: 3px double #000 !important; padding-bottom: 12px;">
                    Jl. Brig Jend. Hasan Basri No.3, Pangeran, Kota Banjarmasin, Kalimantan Selatan 70124
                </td>
            </tr>
            <tr>
                <td colspan="6" class="no-border" style="height: 15px;"></td>
            </tr>
        </table>

        <table style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td colspan="6" class="no-border text-center font-bold" style="font-size: 12pt; text-decoration: underline;">
                    LAPORAN REKAPITULASI KUNJUNGAN
                </td>
            </tr>
            <tr>
                <td colspan="6" class="no-border text-center" style="font-size: 10pt;">
                    Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WITA
                </td>
            </tr>
            <tr>
                <td colspan="6" class="no-border" style="height: 10px;"></td>
            </tr>
        </table>

        <table class="data-table" border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th style="width: 40px;">NO</th>
                    <th style="width: 110px;">TANGGAL</th>
                    <th style="width: 220px;">NAMA PENGUNJUNG</th>
                    <th style="width: 160px;">TAHANAN TUJUAN</th>
                    <th style="width: 100px;">STATUS</th>
                    <th style="width: 80px;">WAKTU</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}
                    </td>

                    <td class="text-left" style="padding-left: 8px;">
                        {{ strtoupper($item->user->name ?? $item->nama_pengunjung) }}
                    </td>

                    <td class="text-left" style="padding-left: 8px;">
                        {{ strtoupper($item->nama_tahanan) }}
                    </td>

                    <td class="text-center font-bold">
                        {{ strtoupper($item->status) }}
                    </td>

                    <td class="text-center">
                        {{ $item->updated_at->format('H:i') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table style="width: 100%; margin-top: 30px;">
            <tr>
                <td colspan="6" class="no-border" style="height: 20px;"></td>
            </tr>
            <tr>
                <td colspan="3" class="no-border"></td>

                <td colspan="3" class="no-border text-center font-serif" style="font-size: 11pt;">
                    Banjarmasin, {{ date('d F Y') }} <br>
                    Kepala Kejaksaan Negeri,
                    <br><br><br><br><br>
                    <b style="text-decoration: underline;">H. FULAN, SH., MH.</b><br>
                    NIP. 19800101 200001 1 001
                </td>
            </tr>
        </table>


        {{-- 3. TUTUP WRAPPER PREVIEW --}}
        @if(isset($isPreview) && $isPreview)
    </div> @endif

</body>

</html>