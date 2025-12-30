<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] font-sans pb-20">

        <div class="bg-white border-b border-gray-200 shadow-sm relative z-10 print:hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-[#F5C542] uppercase tracking-widest bg-[#0f172a] px-2 py-0.5 rounded">Executive Report</span>
                        </div>
                        <h1 class="text-3xl font-serif font-bold text-gray-900">Rekapitulasi Data</h1>
                        <p class="text-sm text-gray-500 mt-1">Laporan statistik kunjungan rutan secara real-time.</p>
                    </div>

                    <button onclick="window.print()" class="group flex items-center gap-2 px-5 py-2.5 bg-[#0f172a] text-white font-bold rounded-lg shadow hover:bg-[#F5C542] hover:text-[#0f172a] transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span>Cetak Laporan</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 print:mt-0">

            <div class="hidden print:block text-center mb-8 border-b-2 border-black pb-4">
                <h1 class="text-2xl font-bold uppercase">Laporan Kunjungan Rutan</h1>
                <p class="text-sm">Kejaksaan Negeri Banjarmasin</p>
                <p class="text-xs mt-1">Dicetak pada: {{ date('d F Y, H:i') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 print:grid-cols-3 print:gap-4">

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-blue-600 print:border print:shadow-none">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Masuk</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalTotal }}</h3>
                            <p class="text-xs text-gray-400 mt-2">Semua Riwayat</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg text-blue-600 print:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-emerald-500 print:border print:shadow-none">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Disetujui</p>
                            <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $totalDisetujui }}</h3>
                            <p class="text-xs text-gray-400 mt-2">Verifikasi Sukses</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-lg text-emerald-600 print:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-red-500 print:border print:shadow-none">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ditolak</p>
                            <h3 class="text-3xl font-bold text-red-600 mt-1">{{ $totalDitolak }}</h3>
                            <p class="text-xs text-gray-400 mt-2">Tidak Valid</p>
                        </div>
                        <div class="p-3 bg-red-50 rounded-lg text-red-600 print:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 print:grid-cols-2 print:gap-4">

                <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden print:shadow-none print:border-gray-400">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2 print:bg-gray-100">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <h3 class="font-bold text-gray-700">Aktivitas Harian (7 Hari Terakhir)</h3>
                    </div>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-white text-gray-500 font-bold border-b border-gray-100 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                                <th class="px-6 py-3 w-1/3 print:hidden">Grafik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($harian as $h)
                            <tr>
                                <td class="px-6 py-3 font-medium text-gray-800">{{ \Carbon\Carbon::parse($h->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-3 text-right font-bold">{{ $h->total }}</td>
                                <td class="px-6 py-3 print:hidden">
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden w-full">
                                        <div class="h-full bg-blue-500 rounded-full" style="width: {{ ($h->total / ($harian->max('total') > 0 ? $harian->max('total') : 1)) * 100 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden print:shadow-none print:border-gray-400">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2 print:bg-gray-100">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                        <h3 class="font-bold text-gray-700">Rekap Bulanan (Tahun Ini)</h3>
                    </div>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-white text-gray-500 font-bold border-b border-gray-100 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">Bulan</th>
                                <th class="px-6 py-3 text-right">Total Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($bulanan as $b)
                            <tr>
                                <td class="px-6 py-3 font-medium text-gray-800">
                                    {{ \Carbon\Carbon::create()->month($b->bulan)->translatedFormat('F') }}
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs font-bold border border-purple-100">
                                        {{ $b->total }} Orang
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="hidden print:flex justify-end mt-16 px-8">
                <div class="text-center">
                    <p class="text-sm">Banjarmasin, {{ date('d F Y') }}</p>
                    <p class="text-sm font-bold mb-16">Petugas Jaga Rutan</p>
                    <p class="text-sm border-t border-black px-4 inline-block font-bold">({{ Auth::user()->name }})</p>
                </div>
            </div>

        </div>
    </div>

    <style>
        @media print {
            @page {
                margin: 2cm;
                size: A4;
            }

            body {
                background: white;
                -webkit-print-color-adjust: exact;
            }

            nav,
            button,
            footer {
                display: none !important;
            }

            /* Sembunyikan Navbar & Tombol */
            .shadow-sm,
            .shadow {
                box-shadow: none !important;
            }
        }
    </style>
</x-app-layout>