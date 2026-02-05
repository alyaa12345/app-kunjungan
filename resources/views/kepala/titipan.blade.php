<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Monitoring Titipan Barang') }}
            </h2>

            <div class="flex gap-2">
                <form method="GET" action="{{ route('kepala.titipan') }}">
                    <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>

                <a href="{{ route('kepala.titipan.cetak', ['status' => request('status')]) }}" target="_blank" class="bg-[#0f172a] hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rekap
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Statistik Ringkas --}}
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Data Tampil</p>
                    <h3 class="text-2xl font-black text-gray-800">{{ $data->total() }}</h3>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#0f172a] text-white uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Pengirim</th>
                                <th class="px-6 py-4">Tahanan Tujuan</th>
                                {{-- KOLOM BARU: PENGGANTI DETAIL --}}
                                <th class="px-6 py-4">Bukti & Keterangan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($data as $item)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $item->created_at->format('d M Y') }}<br>
                                    <span class="text-xs font-bold">{{ $item->created_at->format('H:i') }} WITA</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800 text-base capitalize">
                                        {{ $item->user->name ?? $item->nama_pengirim ?? 'Tanpa Nama' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Hub: {{ $item->hubungan ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded font-bold uppercase text-xs">
                                        {{ $item->nama_tahanan }}
                                    </span>
                                </td>

                                {{-- ISI KOLOM BARU --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        {{-- 1. Jumlah Barang --}}
                                        <div class="flex items-center gap-2 text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <span class="font-bold">{{ $item->jumlah ?? 1 }} Item</span>
                                        </div>

                                        {{-- 2. Link Foto Barang (Jika Ada) --}}
                                        @if($item->foto_barang)
                                        <a href="{{ asset('storage/'.$item->foto_barang) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Lihat Foto Bukti
                                        </a>
                                        @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada foto</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($item->status == 'diterima')
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm">DITERIMA</span>
                                    @elseif($item->status == 'ditolak')
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200 shadow-sm">DITOLAK</span>
                                    @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200 shadow-sm">MENUNGGU</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data titipan barang.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4">
                    {{ $data->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>