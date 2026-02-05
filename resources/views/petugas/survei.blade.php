<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Survei Kepuasan Masyarakat') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl shadow-lg p-6 text-white flex items-center justify-between relative overflow-hidden">
                <div class="z-10">
                    <p class="text-yellow-100 font-bold uppercase text-sm tracking-wider">Indeks Kepuasan (IKM)</p>
                    <div class="flex items-end gap-3 mt-2">
                        <h1 class="text-6xl font-black">{{ number_format($rataRataBintang, 1) }}</h1>
                        <span class="text-2xl font-bold mb-2">/ 5.0</span>
                    </div>
                    <div class="mt-2 text-xl text-yellow-200">
                        @for($i=1; $i<=5; $i++)
                            {{ $i <= round($rataRataBintang) ? '★' : '☆' }}
                            @endfor
                            </div>
                    </div>
                    <div class="absolute right-4 bottom-[-20px] text-9xl text-white opacity-20 rotate-12">🏆</div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-8 border-blue-600 flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 font-bold uppercase text-sm">Total Responden</p>
                        <h1 class="text-5xl font-black text-gray-800 mt-2">{{ $totalResponden }}</h1>
                        <p class="text-gray-400 text-sm mt-1">Orang Masyarakat</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-full text-blue-600">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">💬 Ulasan & Masukan Terbaru</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-white uppercase bg-slate-800">
                                <tr>
                                    <th class="px-6 py-3 w-40">Tanggal</th>
                                    <th class="px-6 py-3 w-48">Nama Pengunjung</th>
                                    <th class="px-6 py-3 w-32 text-center">Rating</th>
                                    <th class="px-6 py-3">Komentar / Saran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($semuaUlasan as $ulasan)
                                <tr class="bg-white hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        {{ $ulasan->created_at->format('d M Y') }}<br>
                                        <span class="text-xs text-gray-400">{{ $ulasan->created_at->format('H:i') }} WITA</span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $ulasan->user->name ?? 'Anonim' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-bold inline-flex items-center gap-1">
                                            <span>{{ $ulasan->bintang }}</span> <span class="text-xs">★</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 italic text-gray-600">
                                        "{{ $ulasan->komentar }}"
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                        Belum ada data survei yang masuk.
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