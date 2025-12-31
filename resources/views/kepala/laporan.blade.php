<x-app-layout>
    <div class="min-h-screen bg-[#F8FAFC] pb-20 pt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Arsip & Laporan</h1>
                    <p class="text-sm text-slate-500">{{ $title }}</p>
                </div>

                <div class="flex bg-white rounded-lg shadow-sm border border-slate-200 p-1">
                    <a href="{{ route('kepala.laporan', ['periode' => 'hari_ini']) }}" class="px-4 py-2 text-xs font-bold rounded-md {{ request('periode') == 'hari_ini' ? 'bg-[#0f172a] text-white' : 'text-slate-600 hover:bg-slate-50' }}">Hari Ini</a>
                    <a href="{{ route('kepala.laporan', ['periode' => 'minggu_ini']) }}" class="px-4 py-2 text-xs font-bold rounded-md {{ request('periode') == 'minggu_ini' ? 'bg-[#0f172a] text-white' : 'text-slate-600 hover:bg-slate-50' }}">Minggu Ini</a>
                    <a href="{{ route('kepala.laporan', ['periode' => 'bulan_ini']) }}" class="px-4 py-2 text-xs font-bold rounded-md {{ request('periode') == 'bulan_ini' ? 'bg-[#0f172a] text-white' : 'text-slate-600 hover:bg-slate-50' }}">Bulan Ini</a>
                    <a href="{{ route('kepala.laporan') }}" class="px-4 py-2 text-xs font-bold rounded-md {{ !request('periode') ? 'bg-[#0f172a] text-white' : 'text-slate-600 hover:bg-slate-50' }}">Semua</a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
                <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <button onclick="window.print()" class="flex items-center gap-2 text-slate-600 hover:text-[#0f172a] text-xs font-bold uppercase transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Laporan
                    </button>
                    <div class="text-xs text-slate-400 italic">
                        Total Data: {{ $laporan->count() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#0f172a] text-[#F5C542] uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Tanggal Kunjungan</th>
                                <th class="px-6 py-4">Pengunjung</th>
                                <th class="px-6 py-4">Tahanan</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Catatan Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($laporan as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <span class="block font-bold text-slate-700">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</span>
                                    <span class="text-xs text-slate-400">{{ $item->jam_kunjungan }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $item->nama_pengunjung }}</div>
                                    <div class="text-xs text-slate-500">NIK: {{ $item->nik_pengunjung }}</div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $item->nama_tahanan }}
                                    <span class="text-xs bg-slate-100 px-1 rounded ml-1">Kamar {{ $item->nomor_kamar }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'disetujui')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-800">
                                        DISETUJUI
                                    </span>
                                    @elseif($item->status == 'ditolak')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        DITOLAK
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        PENDING
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->keterangan_petugas)
                                    <div class="text-xs italic text-slate-600 bg-yellow-50 p-2 rounded border border-yellow-100">
                                        "{{ $item->keterangan_petugas }}"
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-1 text-right">
                                        Diproses: {{ $item->updated_at->format('d/m H:i') }}
                                    </div>
                                    @else
                                    <span class="text-slate-300">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Tidak ada data laporan untuk periode ini.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="hidden print:block mt-12 break-inside-avoid">
                <div class="flex justify-end">
                    <div class="text-center">
                        <p class="text-sm">Banjarmasin, {{ date('d F Y') }}</p>
                        <p class="font-bold uppercase mt-1">Kepala Rutan</p>
                        <div class="h-20"></div>
                        <p class="font-bold underline">{{ Auth::user()->name }}</p>
                        <p class="text-sm">NIP. ........................</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        @media print {
            body {
                background: white;
            }

            .no-print,
            nav,
            header {
                display: none !important;
            }
        }
    </style>
</x-app-layout>