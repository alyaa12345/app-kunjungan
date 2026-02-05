<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Kepuasan Masyarakat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SCORE CARD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-2xl p-6 text-white shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold opacity-80 uppercase tracking-widest mb-1">Indeks Kepuasan (IKM)</p>
                        <h1 class="text-5xl font-black">{{ number_format($average, 1) }} <span class="text-2xl font-medium">/ 5.0</span></h1>
                        <div class="flex mt-2 text-yellow-200">
                            @for($i=1; $i<=5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($average) ? 'fill-current' : 'text-orange-300' }}" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                                @endfor
                        </div>
                    </div>
                    <div class="opacity-30">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg border-l-8 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Responden</p>
                        <h1 class="text-5xl font-black text-gray-800">{{ $data->total() }}</h1>
                        <p class="text-sm text-gray-500 mt-1">Orang Masyarakat</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-full text-blue-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- LIST KOMENTAR --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    Ulasan & Masukan Terbaru
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800 text-white uppercase text-xs">
                            <tr>
                                <th class="p-4 rounded-tl-lg">Tanggal</th>
                                <th class="p-4">Nama Pengunjung</th>
                                <th class="p-4 text-center">Rating</th>
                                <th class="p-4 rounded-tr-lg">Komentar / Saran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($data as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 text-gray-500 text-sm">
                                    {{ $item->updated_at->format('d M Y') }}<br>
                                    <span class="text-xs">{{ $item->updated_at->format('H:i') }} WITA</span>
                                </td>
                                <td class="p-4 font-bold text-gray-800">{{ $item->nama_pengunjung }}</td>
                                <td class="p-4 text-center">
                                    <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $item->rating }} <span class="ml-1 text-yellow-600">★</span>
                                    </div>
                                </td>
                                <td class="p-4 italic text-gray-600">"{{ $item->komentar ?? '-' }}"</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400">Belum ada ulasan yang masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>