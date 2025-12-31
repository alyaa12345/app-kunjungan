<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] font-sans pb-20">

        <div class="bg-white border-b border-slate-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="text-2xl font-bold text-slate-800">Riwayat Kunjungan Saya</h1>
                <p class="text-sm text-slate-500">Daftar semua permohonan kunjungan yang pernah Anda ajukan.</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">

                @if($kunjungans->isEmpty())
                <div class="p-10 text-center">
                    <div class="inline-block p-4 rounded-full bg-slate-50 mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">Belum Ada Riwayat</h3>
                    <p class="text-slate-500 text-sm mt-1 mb-6">Anda belum pernah mengajukan kunjungan.</p>
                    <a href="{{ route('masyarakat.create') }}" class="px-6 py-2 bg-[#0f172a] text-white rounded-lg font-bold text-sm hover:bg-slate-800 transition">
                        Ajukan Sekarang
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">Tanggal Kunjungan</th>
                                <th class="px-6 py-4">Nama Tahanan</th>
                                <th class="px-6 py-4">Keperluan</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($kunjungans as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}
                                    <div class="text-xs text-slate-400 font-normal mt-0.5">{{ $item->jam_kunjungan }}</div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    {{ $item->nama_tahanan }}
                                    <div class="text-[10px] bg-slate-100 inline-block px-1.5 rounded border border-slate-200 mt-1">
                                        Kamar: {{ $item->nomor_kamar }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600 max-w-xs truncate">
                                    {{ $item->keperluan }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'disetujui')
                                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold border border-emerald-200">Disetujui</span>
                                    @elseif($item->status == 'ditolak')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">Ditolak</span>
                                    @else
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold border border-amber-200">Menunggu</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('masyarakat.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-bold hover:underline">
                                        Lihat Tiket
                                    </a>
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