<x-app-layout>
    <style>
        body {
            background-color: #f1f5f9;
        }
    </style>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    {{ __('Verifikasi Permohonan') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Kelola permohonan kunjungan masyarakat</p>
            </div>

            <div class="flex gap-3">
                <div class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md flex flex-col items-center">
                    <span class="text-xs font-light uppercase tracking-wider opacity-80">Menunggu</span>
                    <span class="text-xl font-bold">{{ $kunjungans->count() }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-md shadow-sm flex items-start gap-3 animate-fade-in-down">
                <div class="text-emerald-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-emerald-800">Tindakan Berhasil</h3>
                    <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-slate-200">
                <div class="p-0">
                    @if($kunjungans->isEmpty())
                    <div class="flex flex-col items-center justify-center py-24 text-center bg-slate-50">
                        <div class="bg-white p-6 rounded-full shadow-sm mb-4 border border-slate-100">
                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-700">Tidak Ada Antrian</h3>
                        <p class="text-slate-500 mt-2 max-w-sm">Daftar permohonan kunjungan saat ini kosong. Silakan periksa kembali nanti.</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Jadwal</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Identitas Pengunjung</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tahanan Tujuan</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider min-w-[220px]">Aksi Petugas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach($kunjungans as $item)
                                <tr class="hover:bg-blue-50/50 transition duration-150">

                                    <td class="px-6 py-5 whitespace-nowrap align-top">
                                        <div class="flex flex-col">
                                            <span class="text-lg font-bold text-slate-800">
                                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d') }}
                                            </span>
                                            <span class="text-xs font-semibold text-slate-500 uppercase">
                                                {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('F Y') }}
                                            </span>
                                            <div class="mt-2 inline-flex items-center gap-1 px-2 py-1 rounded bg-slate-100 text-slate-700 text-xs font-bold w-fit border border-slate-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $item->jam_kunjungan }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 align-top">
                                        <div class="flex gap-3">
                                            <div>
                                                <div class="text-sm font-bold text-slate-900">{{ $item->nama_pengunjung }}</div>
                                                <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $item->nik_pengunjung }}</div>
                                                <div class="flex gap-2 mt-2">
                                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-[10px] font-bold uppercase rounded border border-blue-100">{{ $item->hubungan_tahanan }}</span>
                                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold uppercase rounded border border-slate-200">👥 {{ $item->jumlah_pengikut }} Orang</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 align-top">
                                        <div class="text-sm font-bold text-slate-900">{{ $item->nama_tahanan }}</div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            Kamar: <span class="font-bold text-slate-700">{{ $item->nomor_kamar }}</span>
                                        </div>
                                        <div class="mt-2 text-xs italic text-slate-600 bg-slate-50 p-2 rounded border border-slate-100 max-w-[200px]">
                                            "{{ $item->keperluan }}"
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-col gap-2">
                                            <form action="{{ route('petugas.update.status', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="disetujui">
                                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded shadow-sm text-xs font-bold uppercase tracking-wider transition-colors" onclick="return confirm('Izinkan kunjungan ini?')">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Izinkan
                                                </button>
                                            </form>

                                            <form action="{{ route('petugas.update.status', $item->id) }}" method="POST" class="relative group">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="ditolak">
                                                <div class="flex rounded shadow-sm">
                                                    <input type="text" name="keterangan_petugas" required placeholder="Alasan..." class="block w-full min-w-0 flex-1 rounded-l border-slate-300 py-1.5 text-slate-900 placeholder:text-slate-400 focus:ring-red-500 focus:border-red-500 sm:text-xs">
                                                    <button type="submit" class="inline-flex items-center rounded-r bg-red-600 px-3 text-white hover:bg-red-700 focus:outline-none" onclick="return confirm('Tolak kunjungan ini?')">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
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