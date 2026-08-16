<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Resmi CSI</title>
    <!-- Tailwind CSS (Bisa print otomatis) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Khusus agar hasil print rapi (A4) dan berformat surat resmi */
        @media print {
            @page { margin: 2cm; size: A4; }
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
        body {
            /* Surat resmi biasanya menggunakan Times New Roman */
            font-family: 'Times New Roman', Times, serif;
            color: black;
        }
        /* Membuat garis ganda untuk Kop Surat */
        .garis-kop {
            border-bottom: 3px solid black;
            margin-bottom: 2px;
        }
        .garis-kop-bawah {
            border-bottom: 1px solid black;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-white text-black text-sm md:text-base">

    <!-- Tombol Print (Akan hilang saat kertas dicetak) -->
    <div class="no-print p-4 bg-slate-100 border-b border-slate-200 text-center mb-8 flex justify-center gap-4 font-sans">
        <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition-all">
            🖨️ Print Laporan (CTRL + P)
        </button>
        <button onclick="window.close()" class="bg-slate-500 hover:bg-slate-600 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition-all">
            Tutup Tab
        </button>
    </div>

    <!-- Halaman Dokumen A4 -->
    <div class="max-w-4xl mx-auto px-8 pb-12">
        
        <!-- KOP SURAT RESMI -->
        <div class="flex items-center justify-between pb-2">
            <!-- LOGO KIRI -->
            <div class="w-24">
                <!-- Ganti src dengan path logo asli Kejaksaan Anda -->
                <img src="{{ asset('images/logo-kejaksaan.png') }}" alt="Logo" class="w-24 h-auto" onerror="this.style.display='none'">
                <!-- Placeholder tampil jika logo di atas belum dipasang/error -->
                <div class="w-20 h-20 border-2 border-black flex items-center justify-center rounded-full text-xs text-center font-bold" style="display: {{ asset('images/logo-kejaksaan.png') ? 'none' : 'flex' }}">
                    LOGO<br>SINI
                </div>
            </div>
            
            <!-- TEKS KOP -->
            <div class="text-center flex-1 px-4">
                <h1 class="text-xl font-bold uppercase tracking-wide">Kejaksaan Republik Indonesia</h1>
                <h2 class="text-2xl font-bold uppercase tracking-wide mt-1">Kejaksaan Negeri Banjarmasin</h2>
                <p class="text-[11pt] mt-1">>Jl. Brigjen H. Hasan Basri No.3, Banjarmasin Utara, Kota Banjarmasin, Kalimantan Selatan 70124</p>
                <p class="text-[11pt]">Telp: (0511) 3301389  | Email: email@kejaksaan.go.id</p>
            </div>
            
            <!-- SPACER (Agar teks rata tengah simetris dengan logo di kiri) -->
            <div class="w-24"></div>
        </div>
        
        <!-- GARIS KOP SURAT (Garis Ganda) -->
        <div class="garis-kop"></div>
        <div class="garis-kop-bawah"></div>

        <!-- JUDUL LAPORAN -->
        <div class="text-center mb-6 mt-6">
            <h3 class="text-lg font-bold uppercase underline">Laporan Indeks Kepuasan Masyarakat (CSI)</h3>
            <p class="text-[11pt] mt-1">Periode Unduh: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>

        <!-- PARAGRAF PEMBUKA -->
        <p class="text-justify mb-4 leading-relaxed indent-8 text-[11pt]">
            Berdasarkan hasil survei yang telah dilakukan melalui sistem pelayanan kunjungan pada Kejaksaan Negeri (Nama Daerah), berikut adalah ringkasan data Indeks Kepuasan Masyarakat (CSI) beserta ulasan dan masukan yang diberikan oleh masyarakat:
        </p>

        <!-- STATISTIK (Dibuat format list formal, bukan kotak modern) -->
        <div class="mb-6 pl-8">
            <table class="text-[11pt]">
                <tr>
                    <td class="w-48 font-bold pb-1">1. Total Responden</td>
                    <td class="w-4 pb-1">:</td>
                    <td class="pb-1 font-bold">{{ $totalResponden }} Orang</td>
                </tr>
                <tr>
                    <td class="w-48 font-bold">2. Rata-rata Kepuasan</td>
                    <td class="w-4">:</td>
                    <td class="font-bold">{{ number_format($rataRataBintang, 1) }} / 5.0 (Skala Bintang)</td>
                </tr>
            </table>
        </div>

        <!-- TABEL RINCIAN DATA RESMI -->
        <h4 class="font-bold text-[11pt] mb-2">3. Rincian Ulasan & Masukan:</h4>
        <table class="w-full border-collapse border border-black mb-8 text-[11pt]">
            <thead>
                <tr>
                    <th class="border border-black p-2 w-12 text-center font-bold">No</th>
                    <th class="border border-black p-2 w-1/4 text-center font-bold">Nama Responden</th>
                    <th class="border border-black p-2 w-32 text-center font-bold">Penilaian</th>
                    <th class="border border-black p-2 text-center font-bold">Kritik & Saran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($semuaUlasan as $index => $u)
                <tr>
                    <td class="border border-black p-2 text-center align-top">{{ $index + 1 }}</td>
                    <td class="border border-black p-2 align-top">{{ $u->user->name ?? 'Masyarakat Umum' }}</td>
                    <td class="border border-black p-2 text-center align-top">{{ $u->bintang }} Bintang</td>
                    <td class="border border-black p-2 align-top text-justify">{{ $u->ulasan ?? $u->komentar ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="border border-black p-4 text-center italic">Belum ada data ulasan dari masyarakat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PARAGRAF PENUTUP -->
        <p class="text-justify mb-12 leading-relaxed indent-8 text-[11pt]">
            Demikian laporan evaluasi ini dibuat untuk dapat dipergunakan dan menjadi bahan pertimbangan peningkatan mutu pelayanan publik pada Kejaksaan Negeri (Nama Daerah).
        </p>

        <!-- BAGIAN TANDA TANGAN PENGESAHAN -->
        <div class="flex justify-end">
            <div class="text-center w-72">
                <p class="mb-24 text-[11pt]">Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Mengetahui / Mengesahkan,</p>
                <p class="font-bold underline text-[11pt] uppercase">NAMA KEPALA / PEJABAT</p>
                <p class="text-[11pt]">NIP. 198XXXXXXXXXXXXX</p>
            </div>
        </div>

    </div>

</body>
</html>