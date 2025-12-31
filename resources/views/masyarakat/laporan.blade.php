<x-app-layout>
    <div class="min-h-screen bg-[#F4F6F8] pb-12">

        <div class="bg-[#1E3A5F] text-white py-8 px-4 sm:px-6 lg:px-8 shadow-md no-print">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-2xl tracking-tight">{{ $judul }}</h2>
                    <p class="text-blue-200 text-sm mt-1">Sistem Informasi Pelayanan Kunjungan Rutan</p>
                </div>
                <button onclick="window.print()" class="px-5 py-2 bg-[#F5C542] text-[#1E3A5F] font-bold text-sm rounded-lg hover:bg-yellow-400 shadow-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Dokumen
                </button>
            </div>
        </div>

        <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-[8px] border border-gray-200 overflow-hidden p-8 min-h-[600px]">

                {{-- KOP SURAT (Hanya saat print) --}}
                <div class="hidden print:block text-center mb-8 border-b-4 border-double border-black pb-4">
                    <h1 class="text-2xl font-serif font-bold uppercase tracking-wider">Kementerian Hukum dan HAM RI</h1>
                    <h2 class="text-xl font-bold uppercase">Kantor Wilayah Pelayanan Rutan</h2>
                    <p class="text-sm mt-1 italic">Jl. Pelayanan Publik No. 1, Jakarta Selatan</p>
                    <hr class="mt-4 border-black">
                </div>

                <h3 class="text-center font-bold text-xl text-[#1E3A5F] mb-8 underline decoration-2 underline-offset-4 print:text-black">{{ $judul }}</h3>

                @if($jenis == 'jadwal' || $jenis == 'dokumen')
                <table class="w-full text-sm text-left border-collapse border border-gray-300">
                    <thead class="bg-[#1E3A5F] text-white print:bg-gray-200 print:text-black">
                        <tr>
                            <th class="px-4 py-3 border border-gray-300">Tanggal</th>
                            <th class="px-4 py-3 border border-gray-300">Nama Tahanan</th>
                            <th class="px-4 py-3 border border-gray-300 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border border-gray-300 font-semibold">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 border border-gray-300">{{ $item->nama_tahanan }}</td>
                            <td class="px-4 py-3 border border-gray-300 text-center">
                                {{ strtoupper($item->status) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @elseif($jenis == 'statistik')
                <div class="grid grid-cols-2 gap-4 mb-8 print:grid-cols-4">
                    <div class="border p-4 text-center rounded bg-gray-50">
                        <div class="text-3xl font-bold text-[#1E3A5F]">{{ $data->count() }}</div>
                        <div class="text-xs uppercase">Total</div>
                    </div>
                    <div class="border p-4 text-center rounded bg-yellow-50">
                        <div class="text-3xl font-bold text-yellow-600">{{ $data->where('status', 'menunggu')->count() }}</div>
                        <div class="text-xs uppercase">Proses</div>
                    </div>
                    <div class="border p-4 text-center rounded bg-green-50">
                        <div class="text-3xl font-bold text-green-600">{{ $data->where('status', 'disetujui')->count() }}</div>
                        <div class="text-xs uppercase">Disetujui</div>
                    </div>
                    <div class="border p-4 text-center rounded bg-red-50">
                        <div class="text-3xl font-bold text-red-600">{{ $data->where('status', 'ditolak')->count() }}</div>
                        <div class="text-xs uppercase">Ditolak</div>
                    </div>
                </div>
                @else
                <ul class="space-y-4">
                    @foreach($data as $item)
                    <li class="border-b pb-4">
                        <div class="font-bold text-[#1E3A5F]">Pengajuan #{{ $item->id }}</div>
                        <div class="text-sm text-gray-600">Tanggal: {{ $item->tanggal_kunjungan }} - Status: {{ $item->status }}</div>
                    </li>
                    @endforeach
                </ul>
                @endif

                <div class="hidden print:block mt-20 float-right text-center w-1/3">
                    <p>Mengetahui,</p>
                    <p class="mb-20">Kepala Bagian Pelayanan</p>
                    <p class="font-bold underline">NIP. 198237123 2023 1 002</p>
                </div>

            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                font-family: 'Times New Roman', serif;
            }

            .shadow-xl {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</x-app-layout>