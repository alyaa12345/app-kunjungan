<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Kunjungan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($kunjungans->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-gray-500 text-lg">Belum ada permohonan kunjungan baru.</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pengunjung</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tahanan Tujuan</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Keperluan</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($kunjungans as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-blue-600 font-semibold bg-blue-100 inline-block px-2 py-0.5 rounded mt-1">
                                            Jam: {{ $item->jam_kunjungan }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->nama_pengunjung }}</div>
                                        <div class="text-xs text-gray-500">NIK: {{ $item->nik_pengunjung }}</div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            <span class="font-bold">Hubungan:</span> {{ $item->hubungan_tahanan }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900 font-medium">{{ $item->nama_tahanan }}</div>
                                        <div class="text-xs text-gray-500">Kamar: {{ $item->nomor_kamar }}</div>
                                        <div class="text-xs text-gray-500">Kasus: {{ $item->kasus_tahanan }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        {{ $item->keperluan }} <br>
                                        <span class="text-xs text-gray-400">Pengikut: {{ $item->jumlah_pengikut }} org</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <div class="flex flex-col space-y-2 items-center">

                                            <form action="{{ route('petugas.update.status', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menerima kunjungan ini?')">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="disetujui">
                                                <button type="submit" class="w-24 bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs shadow">
                                                    ✔ TERIMA
                                                </button>
                                            </form>

                                            <form action="{{ route('petugas.update.status', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="ditolak">
                                                <div class="flex items-center">
                                                    <input type="text" name="keterangan_petugas" placeholder="Alasan tolak..." class="w-24 text-xs border-gray-300 rounded-l focus:ring-red-500 focus:border-red-500 py-1" required>
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 rounded-r text-xs shadow">
                                                        ✕
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
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
    </div>
</x-app-layout>