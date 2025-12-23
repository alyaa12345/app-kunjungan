<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Proses Kunjungan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tgl Kunjungan</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pengunjung</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tahanan</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status Akhir</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Ket. Petugas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($kunjungans as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        {{ $item->nama_pengunjung }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        {{ $item->nama_tahanan }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        @if($item->status == 'disetujui')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            DISETUJUI
                                        </span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            DITOLAK
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-500 italic">
                                        {{ $item->keterangan_petugas ?? '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($kunjungans->isEmpty())
                        <p class="text-center text-gray-500 mt-4">Belum ada riwayat proses.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>