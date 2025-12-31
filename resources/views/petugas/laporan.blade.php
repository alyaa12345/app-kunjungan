<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] font-sans pb-20">

        <div class="bg-white border-b border-gray-200 shadow-sm relative z-10 print:hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-[#F5C542] uppercase tracking-widest bg-[#0f172a] px-2 py-0.5 rounded">Arsip Digital</span>
                        </div>
                        <h1 class="text-3xl font-serif font-bold text-gray-900">Pusat Laporan</h1>
                        <p class="text-sm text-gray-500 mt-1">{{ $title }}</p> {{-- Judul Dinamis --}}
                    </div>

                    <div class="flex gap-2">
                        <button onclick="document.getElementById('filterModal').classList.remove('hidden')" class="bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 px-5 py-2.5 rounded-xl font-bold shadow-sm transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter Laporan
                        </button>

                        <button onclick="window.print()" class="bg-[#0f172a] hover:bg-[#F5C542] hover:text-[#0f172a] text-white px-5 py-2.5 rounded-xl font-bold shadow-lg transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak (PDF)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="filterModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-100 transition-all">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-slate-800">Pilih Jenis Laporan</h3>
                    <button onclick="document.getElementById('filterModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('petugas.laporan') }}" method="GET" class="p-6">
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Laporan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="filter_type" value="harian" class="peer sr-only" checked onchange="toggleInputs()">
                                <div class="bg-white border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 rounded-lg p-3 text-center transition-all">
                                    <span class="font-bold text-sm">Harian</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="filter_type" value="mingguan" class="peer sr-only" onchange="toggleInputs()">
                                <div class="bg-white border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 rounded-lg p-3 text-center transition-all">
                                    <span class="font-bold text-sm">Mingguan (Rentang)</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="filter_type" value="bulanan" class="peer sr-only" onchange="toggleInputs()">
                                <div class="bg-white border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 rounded-lg p-3 text-center transition-all">
                                    <span class="font-bold text-sm">Bulanan</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="filter_type" value="tahunan" class="peer sr-only" onchange="toggleInputs()">
                                <div class="bg-white border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 rounded-lg p-3 text-center transition-all">
                                    <span class="font-bold text-sm">Tahunan</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="input-container" class="space-y-4">
                        <div id="input-harian">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pilih Tanggal</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div id="input-mingguan" class="hidden grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                                <input type="date" name="start_date" class="w-full rounded-lg border-slate-300">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                                <input type="date" name="end_date" class="w-full rounded-lg border-slate-300">
                            </div>
                        </div>

                        <div id="input-bulanan" class="hidden grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Bulan</label>
                                <select name="bulan" class="w-full rounded-lg border-slate-300">
                                    @for($i=1; $i<=12; $i++)
                                        <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                        @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tahun</label>
                                <select name="tahun" class="w-full rounded-lg border-slate-300 year-select"></select>
                            </div>
                        </div>

                        <div id="input-tahunan" class="hidden">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pilih Tahun</label>
                            <select name="tahun" class="w-full rounded-lg border-slate-300 year-select"></select>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-[#0f172a] hover:bg-blue-900 text-white font-bold py-3 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Tampilkan Data
                    </button>
                </form>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 print:mt-0 print:px-0 print:max-w-none">

            <div class="print:hidden grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-600">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Data (Terfilter)</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalTotal }}</h3>
                </div>
                <div class="bg-white p-6 rounded-xl shadow border-l-4 border-emerald-500">
                    <p class="text-xs font-bold text-gray-400 uppercase">Disetujui</p>
                    <h3 class="text-3xl font-bold text-emerald-600">{{ $totalDisetujui }}</h3>
                </div>
                <div class="bg-white p-6 rounded-xl shadow border-l-4 border-red-500">
                    <p class="text-xs font-bold text-gray-400 uppercase">Ditolak</p>
                    <h3 class="text-3xl font-bold text-red-600">{{ $totalDitolak }}</h3>
                </div>
            </div>

            <div class="hidden print:block bg-white">
                <div class="flex items-center justify-center relative border-b-4 border-double border-black pb-2 mb-6">
                    <div class="absolute left-0 top-0">
                        <img src="{{ asset('assets/logo-kejari.png') }}" class="h-24 w-auto object-contain print-color">
                    </div>
                    <div class="text-center w-full pl-24 pr-4">
                        <h4 class="text-md font-bold uppercase tracking-wide text-black">KEJAKSAAN REPUBLIK INDONESIA</h4>
                        <h2 class="text-xl font-black uppercase tracking-wider scale-y-110 text-[#166534] print-color">KEJAKSAAN NEGERI BANJARMASIN</h2>
                        <p class="text-xs italic mt-1 text-black">Jl. Brigjen H. Hasan Basri No. 4, Pangeran, Banjarmasin Utara, Kalimantan Selatan</p>
                        <p class="text-[10px] text-black">Telp: (0511) 3300000 | Email: kn.banjarmasin@kejaksaan.go.id</p>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <h1 class="text-lg font-bold uppercase underline decoration-1 underline-offset-2">LAPORAN REGISTER KUNJUNGAN</h1>
                    <p class="text-xs mt-1 font-bold uppercase">{{ $title }}</p>
                </div>

                <table class="w-full text-[10px] text-left border-collapse border border-black">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-black px-1 py-1 text-center w-6">No</th>
                            <th class="border border-black px-1 py-1 w-16">Tanggal</th>
                            <th class="border border-black px-2 py-1">Nama Pengunjung</th>
                            <th class="border border-black px-1 py-1 w-16">NIK</th>
                            <th class="border border-black px-1 py-1 w-6 text-center">Jml</th>
                            <th class="border border-black px-2 py-1">Tahanan Tujuan</th>
                            <th class="border border-black px-2 py-1">Keperluan</th>
                            <th class="border border-black px-1 py-1 w-12 text-center">Ket.</th>
                            <th class="border border-black px-1 py-1 w-12 text-center">Paraf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan_detail as $index => $item)
                        <tr class="break-inside-avoid">
                            <td class="border border-black px-1 py-1 text-center align-top">{{ $index + 1 }}</td>
                            <td class="border border-black px-1 py-1 text-center align-top">
                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/y') }}<br>
                                <span class="text-[9px]">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}</span>
                            </td>
                            <td class="border border-black px-2 py-1 align-top font-bold uppercase">{{ $item->nama_pengunjung }}</td>
                            <td class="border border-black px-1 py-1 align-top">{{ $item->nik_pengunjung }}</td>
                            <td class="border border-black px-1 py-1 text-center align-top">{{ $item->jumlah_pengikut }}</td>
                            <td class="border border-black px-2 py-1 align-top uppercase">
                                {{ $item->nama_tahanan }}<br>
                                <span class="text-[9px] italic">Kmr: {{ $item->nomor_kamar }}</span>
                            </td>
                            <td class="border border-black px-2 py-1 align-top italic">{{ $item->keperluan ?? '-' }}</td>
                            <td class="border border-black px-1 py-1 text-center align-top font-bold">
                                @if($item->status == 'disetujui') ACC @elseif($item->status == 'ditolak') TOLAK @else - @endif
                            </td>
                            <td class="border border-black px-1 py-1"></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="border border-black p-4 text-center italic">Tidak ada data kunjungan pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex justify-between mt-8 px-8 break-inside-avoid">
                    <div class="text-center w-64">
                        <p class="text-xs">Mengetahui,</p>
                        <p class="text-xs font-bold uppercase mb-16">Kasi Pelayanan Tahanan</p>
                        <p class="text-xs font-bold underline">..........................................</p>
                        <p class="text-[10px]">NIP. ..............................</p>
                    </div>
                    <div class="text-center w-64">
                        <p class="text-xs">Banjarmasin, {{ date('d F Y') }}</p>
                        <p class="text-xs font-bold uppercase mb-16">Petugas Verifikator</p>
                        <p class="text-xs font-bold underline">{{ Auth::user()->name }}</p>
                        <p class="text-[10px]">NIP. ..............................</p>
                    </div>
                </div>
            </div>

            <div class="print:hidden bg-white rounded-xl shadow border border-gray-200 mt-8 overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Preview Data ({{ $laporan_detail->count() }} Item)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Pengunjung</th>
                                <th class="px-6 py-3">Tahanan</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($laporan_detail->take(10) as $item)
                            <tr>
                                <td class="px-6 py-3">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</td>
                                <td class="px-6 py-3 font-bold">{{ $item->nama_pengunjung }}</td>
                                <td class="px-6 py-3">{{ $item->nama_tahanan }}</td>
                                <td class="px-6 py-3 font-bold text-xs">{{ strtoupper($item->status) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-400">Tidak ada data. Silakan pilih filter lain.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleInputs() {
            const type = document.querySelector('input[name="filter_type"]:checked').value;

            // Sembunyikan semua dulu
            document.getElementById('input-harian').classList.add('hidden');
            document.getElementById('input-mingguan').classList.add('hidden');
            document.getElementById('input-bulanan').classList.add('hidden');
            document.getElementById('input-tahunan').classList.add('hidden');

            // Tampilkan yang dipilih
            if (type === 'harian') document.getElementById('input-harian').classList.remove('hidden');
            if (type === 'mingguan') document.getElementById('input-mingguan').classList.remove('hidden');
            if (type === 'bulanan') document.getElementById('input-bulanan').classList.remove('hidden');
            if (type === 'tahunan') document.getElementById('input-tahunan').classList.remove('hidden');
        }

        // Isi Tahun Otomatis (5 Tahun Terakhir)
        document.addEventListener("DOMContentLoaded", function() {
            const yearSelects = document.querySelectorAll('.year-select');
            const currentYear = new Date().getFullYear();
            yearSelects.forEach(select => {
                for (let i = currentYear; i >= currentYear - 5; i--) {
                    let option = document.createElement('option');
                    option.value = i;
                    option.text = i;
                    select.appendChild(option);
                }
            });
            toggleInputs(); // Jalankan sekali saat load
        });
    </script>

    <style>
        @media print {
            @page {
                margin: 1.5cm;
                size: A4 portrait;
            }

            body {
                background: white !important;
                font-family: 'Times New Roman', serif !important;
                color: black !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            nav,
            header,
            button,
            footer {
                display: none !important;
            }

            img {
                filter: none !important;
            }

            .text-[#166534] {
                color: #166534 !important;
            }
        }
    </style>
</x-app-layout>