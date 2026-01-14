<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] font-sans pb-20 p-4 md:p-8">

        <div class="max-w-7xl mx-auto print:hidden">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Laporan Permohonan</h1>
                <p class="text-slate-500 mt-1 text-sm">Rekapitulasi data masuk dan status verifikasi kunjungan.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">

                <div class="flex items-center gap-3">
                    <div class="bg-blue-50 text-blue-600 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Data</p>
                        <p class="text-lg font-bold text-slate-800">{{ $data->count() }} Permohonan</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('petugas.laporan.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                    <div class="relative w-full sm:w-64">
                        <select name="status" class="w-full appearance-none bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-4 pr-8 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F5C542] focus:border-transparent text-sm font-bold cursor-pointer transition-all hover:bg-slate-100" onchange="this.form.submit()">
                            <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>📂 Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅ Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <button type="button" onclick="window.print()" class="w-full sm:w-auto bg-[#0f172a] hover:bg-[#F5C542] hover:text-[#0f172a] text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-slate-900/10 flex items-center justify-center gap-2 transform active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Laporan
                    </button>
                </form>
            </div>
        </div>

        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden print:shadow-none print:border-none print:rounded-none">

            <div class="hidden print:block p-8 pb-4 text-center border-b-4 border-double border-black mb-6">
                <div class="flex justify-center items-center gap-6 mb-4">
                    <img src="{{ asset('assets/logo-kejari.png') }}" class="h-24 w-auto object-contain">
                    <div class="text-center">
                        <h3 class="text-xl font-bold uppercase tracking-widest font-serif">KEJAKSAAN REPUBLIK INDONESIA</h3>
                        <h2 class="text-3xl font-black uppercase tracking-wider scale-y-110 text-[#166534] print-color-force font-serif mt-1">KEJAKSAAN NEGERI BANJARMASIN</h2>
                        <p class="text-sm italic mt-2 font-serif">Jl. Brigjen H. Hasan Basri No. 4, Pangeran, Kota Banjarmasin</p>
                    </div>
                </div>
                <div class="mt-6">
                    <h2 class="text-lg font-bold uppercase underline decoration-1 underline-offset-4">LAPORAN REKAPITULASI PERMOHONAN</h2>
                    <p class="text-xs mt-1 font-mono uppercase">Filter Data: {{ request('status') ? request('status') : 'SEMUA DATA' }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold border-b border-slate-200 print:bg-gray-200 print:text-black print:border-black">
                        <tr>
                            <th class="px-6 py-4 w-12 text-center border-r border-slate-100 print:border-black">No</th>
                            <th class="px-6 py-4 w-32 print:border-black">Tanggal</th>
                            <th class="px-6 py-4 print:border-black">Nama Pemohon</th>
                            <th class="px-6 py-4 print:border-black">Tahanan Tujuan</th>
                            <th class="px-6 py-4 w-20 text-center print:border-black">Jml</th>
                            <th class="px-6 py-4 w-32 text-center print:border-black">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 print:divide-black">
                        @forelse($data as $index => $item)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200 group print:hover:bg-transparent">
                            <td class="px-6 py-4 text-center font-mono text-slate-400 group-hover:text-blue-500 border-r border-slate-100 print:border-black print:text-black">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-600 print:border-black print:text-black">
                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 print:border-black">
                                <div class="font-bold text-slate-800 uppercase print:text-black">{{ $item->user->name ?? 'Guest' }}</div>
                                <div class="text-[10px] text-slate-400 print:hidden">NIK: {{ $item->nik_pengunjung ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 uppercase text-slate-700 print:border-black print:text-black">
                                {{ $item->nama_tahanan }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-slate-600 print:border-black print:text-black">
                                {{ $item->jumlah_pengikut }}
                            </td>
                            <td class="px-6 py-4 text-center print:border-black">
                                @if($item->status == 'disetujui')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700 border border-emerald-200 print:border-none print:bg-transparent print:text-black print:p-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 print:hidden"></span> Disetujui
                                </span>
                                @elseif($item->status == 'ditolak')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700 border border-red-200 print:border-none print:bg-transparent print:text-black print:p-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 print:hidden"></span> Ditolak
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-100 text-amber-700 border border-amber-200 print:border-none print:bg-transparent print:text-black print:p-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse print:hidden"></span> Menunggu
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic bg-slate-50/50 print:border-black">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p>Tidak ada data permohonan ditemukan untuk filter ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="hidden print:flex justify-end mt-16 px-12 break-inside-avoid">
                <div class="text-center w-64">
                    <p class="text-sm font-serif mb-1">Banjarmasin, {{ date('d F Y') }}</p>
                    <p class="text-sm font-serif">Petugas Pelayanan,</p>
                    <div class="h-24"></div>
                    <p class="text-sm font-bold underline uppercase">{{ Auth::user()->name }}</p>
                    <p class="text-xs uppercase">NIP. ...........................</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-8 print:hidden">
            <p class="text-xs text-slate-400 font-medium">SIP-RUTAN &copy; {{ date('Y') }} Kejaksaan Negeri Banjarmasin</p>
        </div>

    </div>

    <style>
        @media print {
            @page {
                margin: 1cm;
                size: A4 portrait;
            }

            body {
                background: white !important;
                font-family: 'Times New Roman', serif !important;
                -webkit-print-color-adjust: exact;
                padding: 0 !important;
            }

            .print\:hidden {
                display: none !important;
            }

            .print\:shadow-none {
                box-shadow: none !important;
            }

            .print\:border-none {
                border: none !important;
            }

            .print\:rounded-none {
                border-radius: 0 !important;
            }

            /* Paksa border hitam saat print */
            table {
                width: 100%;
                border: 1px solid black;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid black !important;
                padding: 8px !important;
                font-size: 11pt;
            }

            /* Warna khusus print */
            .print-color-force {
                color: #166534 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</x-app-layout>