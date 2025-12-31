<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] pb-20 font-sans">

        <div class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Arsip Riwayat</h1>
                    <p class="text-sm text-slate-500">Data kunjungan yang telah selesai diproses.</p>
                </div>
                <a href="{{ route('petugas.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-bold transition flex items-center gap-2">
                    &larr; Kembali ke Verifikasi
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-100 text-slate-500 uppercase text-xs font-bold border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">Waktu Proses</th>
                                <th class="px-6 py-4">Pengunjung</th>
                                <th class="px-6 py-4">Tujuan</th>
                                <th class="px-6 py-4">Status Akhir</th>
                                <th class="px-6 py-4">Catatan Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($riwayat as $item)
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-700">{{ $item->updated_at->format('d M Y') }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $item->updated_at->format('H:i') }} WITA</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $item->nama_pengunjung }}</div>
                                    <div class="text-xs text-slate-500">NIK: {{ $item->nik_pengunjung }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-600">Membesuk:</span>
                                    <span class="font-bold text-slate-800">{{ $item->nama_tahanan }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'disetujui')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        DISETUJUI
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        DITOLAK
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-500 italic">
                                    {{ $item->keterangan_petugas ?? '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                    Belum ada data riwayat kunjungan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>