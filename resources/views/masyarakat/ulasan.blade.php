<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Beri Penilaian Layanan') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm">
            <p class="font-bold">Terima Kasih!</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="font-bold text-lg mb-4">Daftar Kunjungan Belum Dinilai</h3>

                @forelse($belumDinilai as $item)
                <div class="border rounded-xl p-6 mb-6 shadow-sm bg-gray-50">
                    <div class="flex justify-between items-start mb-4 border-b pb-4">
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Kunjungan</p>
                            <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d F Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Tahanan Tujuan</p>
                            <p class="font-bold text-gray-800 uppercase">{{ $item->nama_tahanan }}</p>
                        </div>
                    </div>

                    <form action="{{ route('masyarakat.survei.simpan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kunjungan_id" value="{{ $item->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                            <div class="bg-white p-4 rounded-lg border text-center">
                                <label class="block font-bold text-gray-700 mb-2">👮 Pelayanan Petugas</label>
                                <p class="text-xs text-gray-400 mb-3">Ramah & Cepat?</p>
                                <div class="flex justify-center gap-2">
                                    @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer">
                                        <input type="radio" name="skor_pelayanan" value="{{ $i }}" class="peer sr-only" required>
                                        <div class="w-8 h-8 rounded-full border-2 border-gray-300 peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white flex items-center justify-center font-bold text-gray-400 hover:bg-blue-50 transition">
                                            {{ $i }}
                                        </div>
                                        </label>
                                        @endfor
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-lg border text-center">
                                <label class="block font-bold text-gray-700 mb-2">🧹 Kebersihan Area</label>
                                <p class="text-xs text-gray-400 mb-3">Bersih & Rapi?</p>
                                <div class="flex justify-center gap-2">
                                    @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer">
                                        <input type="radio" name="skor_kebersihan" value="{{ $i }}" class="peer sr-only" required>
                                        <div class="w-8 h-8 rounded-full border-2 border-gray-300 peer-checked:bg-green-600 peer-checked:border-green-600 peer-checked:text-white flex items-center justify-center font-bold text-gray-400 hover:bg-green-50 transition">
                                            {{ $i }}
                                        </div>
                                        </label>
                                        @endfor
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-lg border text-center">
                                <label class="block font-bold text-gray-700 mb-2">🏢 Fasilitas Rutan</label>
                                <p class="text-xs text-gray-400 mb-3">Nyaman & Memadai?</p>
                                <div class="flex justify-center gap-2">
                                    @for($i=1; $i<=5; $i++)
                                        <label class="cursor-pointer">
                                        <input type="radio" name="skor_fasilitas" value="{{ $i }}" class="peer sr-only" required>
                                        <div class="w-8 h-8 rounded-full border-2 border-gray-300 peer-checked:bg-orange-500 peer-checked:border-orange-500 peer-checked:text-white flex items-center justify-center font-bold text-gray-400 hover:bg-orange-50 transition">
                                            {{ $i }}
                                        </div>
                                        </label>
                                        @endfor
                                </div>
                            </div>

                        </div>

                        <div class="mb-4">
                            <label class="block font-bold text-gray-700 mb-2">Kritik & Saran</label>
                            <textarea name="komentar" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tulis masukan Anda di sini..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-slate-800 text-white font-bold py-3 rounded-lg hover:bg-slate-900 transition">
                            Kirim Penilaian
                        </button>
                    </form>
                </div>
                @empty
                <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                    <p class="text-gray-500">Tidak ada kunjungan yang perlu dinilai saat ini.</p>
                    <a href="{{ route('masyarakat.index') }}" class="text-blue-600 font-bold hover:underline text-sm mt-2 block">Kembali ke Dashboard</a>
                </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>