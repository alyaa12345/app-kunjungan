<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] pb-20">

        <div class="bg-white border-b border-gray-200 py-8 px-6 shadow-sm">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold text-[#0f172a] font-serif">Arsip Digital Kunjungan</h1>
                <button onclick="window.print()" class="px-4 py-2 bg-slate-100 border border-slate-300 rounded text-slate-700 text-sm font-bold hover:bg-slate-200">
                    Cetak Halaman
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

            <div class="bg-white rounded-xl shadow-md border-t-4 border-emerald-500 overflow-hidden">
                <div class="px-6 py-4 bg-emerald-50 border-b border-emerald-100 flex justify-between items-center">
                    <h3 class="font-bold text-emerald-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        RIWAYAT DISETUJUI (BERHASIL)
                    </h3>
                    <span class="bg-emerald-200 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $kunjungans->where('status', 'disetujui')->count() }} Data
                    </span>
                </div>

                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Tahanan</th>
                            <th class="px-6 py-3">Pengunjung</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($kunjungans->where('status', 'disetujui') as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-bold text-[#0f172a]">
                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}
                                <div class="text-xs font-normal text-slate-400">#REQ-{{ $item->id }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $item->nama_tahanan }}</td>
                            <td class="px-6 py-4">{{ $item->nama_pengunjung }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-bold">SUKSES</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-xl shadow-md border-t-4 border-red-500 overflow-hidden">
                <div class="px-6 py-4 bg-red-50 border-b border-red-100 flex justify-between items-center">
                    <h3 class="font-bold text-red-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        RIWAYAT DITOLAK
                    </h3>
                    <span class="bg-red-200 text-red-800 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $kunjungans->where('status', 'ditolak')->count() }} Data
                    </span>
                </div>

                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Tahanan</th>
                            <th class="px-6 py-3">Pengunjung</th>
                            <th class="px-6 py-3">Alasan Penolakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($kunjungans->where('status', 'ditolak') as $item)
                        <tr class="hover:bg-red-50/20 transition">
                            <td class="px-6 py-4 font-bold text-[#0f172a]">
                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}
                                <div class="text-xs font-normal text-slate-400">#REQ-{{ $item->id }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $item->nama_tahanan }}</td>
                            <td class="px-6 py-4">{{ $item->nama_pengunjung }}</td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-red-600 bg-red-100 p-2 rounded border border-red-200">
                                    "{{ $item->keterangan_petugas ?? '-' }}"
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>