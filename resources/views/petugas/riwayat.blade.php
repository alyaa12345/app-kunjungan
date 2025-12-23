<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Arsip Riwayat') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Data historis kunjungan yang telah diproses</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-xl border border-slate-200 overflow-hidden">

                @if($kunjungans->isEmpty())
                <div class="text-center py-20 bg-slate-50">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-bold text-slate-700">Arsip Kosong</h3>
                    <p class="mt-1 text-sm text-slate-500">Belum ada data kunjungan yang selesai diproses.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-800 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Pengunjung</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tahanan</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @foreach($kunjungans as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-900">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">Pukul {{ $item->jam_kunjungan }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-800">{{ $item->nama_pengunjung }}</div>
                                    <div class="text-xs text-slate-500">{{ $item->hubungan_tahanan }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-800">{{ $item->nama_tahanan }}</div>
                                    <div class="text-xs text-slate-500">Kamar: {{ $item->nomor_kamar }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($item->status == 'disetujui')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        ✅ DISETUJUI
                                    </span>
                                    @elseif($item->status == 'ditolak')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">
                                        ❌ DITOLAK
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 italic border-l-2 border-transparent">
                                    {{ $item->keterangan_petugas ?? '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>