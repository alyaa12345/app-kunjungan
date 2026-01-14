<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] font-sans pb-20 p-4 md:p-8">
        <div class="max-w-7xl mx-auto print:hidden mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Laporan Evaluasi</h1>
                <p class="text-slate-500 text-sm">Monitoring kinerja dan status verifikasi.</p>
            </div>
            <button onclick="window.print()" class="bg-[#0f172a] hover:bg-[#F5C542] hover:text-[#0f172a] text-white px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Laporan
            </button>
        </div>

        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden print:shadow-none print:border-none">

            <div class="hidden print:block p-8 pb-4 text-center border-b-4 border-double border-black mb-6">
                <h3 class="text-xl font-bold uppercase tracking-widest">KEJAKSAAN REPUBLIK INDONESIA</h3>
                <h2 class="text-3xl font-black uppercase tracking-wider text-[#166534] print-color-force">KEJAKSAAN NEGERI BANJARMASIN</h2>
                <p class="text-sm italic mt-2">Jl. Brigjen H. Hasan Basri No. 4, Pangeran, Kota Banjarmasin</p>
                <div class="mt-8 border-t border-black pt-4">
                    <h2 class="text-lg font-bold uppercase underline decoration-1 underline-offset-4">LAPORAN MONITORING & EVALUASI</h2>
                    <p class="text-xs mt-1 uppercase">{{ $title ?? 'Semua Data' }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold border-b border-slate-200 print:bg-gray-200 print:text-black print:border-black">
                        <tr>
                            <th class="px-6 py-4 w-10 text-center border-r border-slate-100 print:border-black">No</th>
                            <th class="px-6 py-4 w-32 print:border-black">Tanggal</th>
                            <th class="px-6 py-4 print:border-black">Pemohon</th>
                            <th class="px-6 py-4 w-32 text-center print:border-black">Status</th>
                            <th class="px-6 py-4 bg-yellow-50/50 text-slate-700 print:bg-gray-100 print:border-black w-48">Diproses Oleh (Verifikator)</th>
                            <th class="px-6 py-4 w-32 print:border-black">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 print:divide-black">
                        @forelse($data as $index => $item)
                        <tr class="hover:bg-slate-50 transition print:hover:bg-transparent">
                            <td class="px-6 py-4 text-center border-r border-slate-100 print:border-black">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 print:border-black">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-bold uppercase print:border-black">{{ $item->user->name ?? '-' }}</td>

                            <td class="px-6 py-4 text-center print:border-black">
                                @if($item->status == 'disetujui')
                                <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-[10px] font-bold uppercase print:bg-transparent print:text-black print:border print:border-black">Disetujui</span>
                                @elseif($item->status == 'ditolak')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-[10px] font-bold uppercase print:bg-transparent print:text-black print:border print:border-black">Ditolak</span>
                                @else
                                <span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-[10px] font-bold uppercase print:bg-transparent print:text-black">Menunggu</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 bg-yellow-50/30 print:bg-transparent print:border-black font-bold text-slate-700 uppercase italic">
                                {{ $item->petugas->name ?? '- Belum Ada -' }}
                            </td>

                            <td class="px-6 py-4 text-xs text-slate-500 print:border-black">{{ $item->updated_at->format('H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic print:border-black">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="hidden print:flex justify-end mt-16 px-12 break-inside-avoid">
                <div class="text-center w-72">
                    <p class="text-sm mb-1">Banjarmasin, {{ date('d F Y') }}</p>
                    <p class="text-sm font-bold">Kepala Kejaksaan Negeri</p>
                    <div class="h-24"></div>
                    <p class="text-sm font-bold underline uppercase">H. FULAN, SH., MH.</p>
                    <p class="text-xs">NIP. 19800101 200001 1 001</p>
                </div>
            </div>
        </div>
    </div>
    <style>
        @media print {
            body {
                background: white !important;
            }

            .print\:hidden {
                display: none !important;
            }

            table {
                width: 100%;
                border: 1px solid black;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid black !important;
                padding: 5px;
            }

            .print-color-force {
                color: #166534 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</x-app-layout>