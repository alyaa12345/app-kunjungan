<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Verifikasi Permohonan') }}
            </h2>
            <div class="flex items-center gap-3">
                <span class="bg-white border border-gray-200 text-gray-600 px-4 py-1.5 rounded-full text-sm shadow-sm">
                    📅 {{ date('d M Y') }}
                </span>
                <span class="bg-indigo-600 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-md animate-pulse">
                    {{ $kunjungans->count() }} Menunggu
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-start gap-3">
                <div class="p-1 bg-green-200 rounded-full text-green-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-green-800">Berhasil!</h3>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100">
                <div class="p-0">
                    @if($kunjungans->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center bg-gray-50/50">
                        <div class="bg-white p-6 rounded-full shadow-sm mb-4">
                            <svg class="w-16 h-16 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Semua Beres!</h3>
                        <p class="text-gray-500 mt-2 max-w-sm">Tidak ada permohonan kunjungan yang perlu diverifikasi saat ini. Silakan cek lagi nanti.</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu Kunjungan</th>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Identitas Pengunjung</th>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tahanan Tujuan</th>
                                    <th scope="col" class="px-6 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider min-w-[240px]">Aksi Petugas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($kunjungans as $item)
                                <tr class="hover:bg-indigo-50/30 transition-colors duration-200 group">

                                    <td class="px-6 py-5 whitespace-nowrap align-top">
                                        <div class="flex flex-col">
                                            <span class="text-base font-bold text-gray-800">
                                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                            </span>
                                            <div class="mt-2 inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-100 text-blue-700 w-fit">
                                                🕑 {{ $item->jam_kunjungan }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 align-top">
                                        <div class="flex items-start gap-3">
                                            <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg mt-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $item->nama_pengunjung }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5 font-mono">NIK: {{ $item->nik_pengunjung }}</div>
                                                <div class="flex items-center gap-2 mt-2">
                                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded border border-gray-200 font-medium">
                                                        {{ $item->hubungan_tahanan }}
                                                    </span>
                                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded border border-gray-200 font-medium flex items-center gap-1">
                                                        👥 {{ $item->jumlah_pengikut }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 align-top">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->nama_tahanan }}</div>
                                        <div class="text-xs text-gray-500 mt-1">Kamar: <span class="font-bold text-gray-700">{{ $item->nomor_kamar }}</span></div>
                                        <div class="mt-2 text-sm text-gray-600 italic border-l-2 border-indigo-300 pl-3 bg-gray-50 py-1 rounded-r">
                                            "{{ $item->keperluan }}"
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-col gap-3">
                                            <form action="{{ route('petugas.update.status', $item->id) }}" method="POST" class="w-full">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="disetujui">
                                                <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white rounded-lg shadow-sm text-xs font-bold uppercase tracking-wide transform active:scale-95 transition-all duration-200" onclick="return confirm('Yakin ingin menerima kunjungan ini?')">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Terima Izin
                                                </button>
                                            </form>

                                            <form action="{{ route('petugas.update.status', $item->id) }}" method="POST" class="w-full">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="ditolak">
                                                <div class="flex shadow-sm rounded-lg overflow-hidden ring-1 ring-gray-200 focus-within:ring-2 focus-within:ring-red-500 transition-all">
                                                    <input type="text" name="keterangan_petugas" required placeholder="Alasan tolak..." class="block w-full border-0 bg-gray-50 py-2 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-xs">
                                                    <button type="submit" class="bg-white px-3 py-2 text-xs font-bold text-red-600 hover:bg-red-50 border-l border-gray-200 transition-colors" onclick="return confirm('Tolak kunjungan ini?')">
                                                        TOLAK
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