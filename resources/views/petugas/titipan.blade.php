<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Titipan Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <form method="GET" action="{{ route('petugas.titipan.index') }}">
                            <div class="flex gap-2">
                                <div class="relative w-full max-w-md">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="cari" value="{{ request('cari') }}"
                                        class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Scan QR di sini atau ketik ID / Nama Tahanan..." autofocus>
                                </div>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2">
                                    Cari
                                </button>
                                @if(request('cari'))
                                <a href="{{ route('petugas.titipan.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-4 py-2 flex items-center">
                                    Reset
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-white uppercase bg-slate-800">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Pengirim</th>
                                    <th class="px-6 py-3">Tujuan</th>
                                    <th class="px-6 py-3">Barang</th>
                                    <th class="px-6 py-3">Foto Barang</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($titipans as $item)
                                <tr class="bg-white border-b hover:bg-gray-50 align-top">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold block text-gray-800">{{ $item->user->name ?? 'User Hapus' }}</span>
                                    </td>
                                    <td class="px-6 py-4 uppercase font-bold text-gray-700">{{ $item->nama_tahanan }}</td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-0.5 rounded">{{ strtoupper($item->jenis_titipan) }}</span>
                                        <p class="mt-2 text-gray-600 text-xs leading-relaxed">{{ $item->deskripsi_barang }}</p>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($item->foto_barang)
                                        <div class="relative group w-20 h-20">
                                            <img src="{{ asset('storage/' . $item->foto_barang) }}" class="w-full h-full object-cover rounded shadow border border-gray-200" alt="Foto Barang">
                                            <a href="{{ asset('storage/'.$item->foto_barang) }}" target="_blank" class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 flex items-center justify-center transition rounded cursor-zoom-in">
                                                <span class="text-white opacity-0 group-hover:opacity-100 text-xs font-bold">🔍 Zoom</span>
                                            </a>
                                        </div>
                                        @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada foto</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'diajukan')
                                        <div class="flex flex-col gap-2 items-center">
                                            <form action="{{ route('petugas.titipan.update', $item->id) }}" method="POST" class="w-full">
                                                @csrf @method('PUT')
                                                <button name="status" value="diterima" class="w-full bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-xs font-bold transition shadow" onclick="return confirm('Yakin terima barang ini?')">
                                                    ✓ TERIMA
                                                </button>
                                            </form>

                                            <button onclick="bukaModalTolak({{ $item->id }})" class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-xs font-bold transition shadow">
                                                ✕ TOLAK
                                            </button>
                                        </div>
                                        @else
                                        <div class="flex flex-col gap-2 items-center w-full">
                                            <span class="px-3 py-1 rounded-full text-xs text-white font-bold w-full shadow {{ $item->status == 'diterima' ? 'bg-green-500' : 'bg-red-500' }}">
                                                {{ strtoupper($item->status) }}
                                            </span>

                                            @if($item->status == 'diterima')
                                            <a href="{{ route('petugas.titipan.cetak', $item->id) }}" target="_blank" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-bold flex items-center justify-center gap-1 transition shadow border-b-4 border-blue-800 active:border-0 active:mt-1">
                                                <span>🖨</span> Cetak Label
                                            </a>
                                            @endif

                                            @if($item->status == 'ditolak')
                                            <div class="mt-1 p-2 bg-red-50 text-red-700 text-xs text-left rounded border border-red-100 w-full">
                                                <strong>Alasan:</strong> <br> {{ $item->alasan_penolakan }}
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-400 bg-gray-50 italic">
                                        Data tidak ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalTolak" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all scale-100">

            <div class="bg-red-600 px-4 py-3 flex justify-between items-center shadow">
                <h3 class="text-white font-bold text-lg flex items-center gap-2">
                    🚫 Tolak Titipan
                </h3>
                <button onclick="tutupModal()" class="text-white hover:text-gray-200 text-2xl font-bold leading-none">&times;</button>
            </div>

            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">Mengapa barang ini ditolak? Pilih alasan yang sesuai:</p>

                <form id="formTolakUtama" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="ditolak">
                    <input type="hidden" name="alasan" id="inputAlasanFinal">

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Alasan Umum:</label>
                        <select id="pilihanAlasan" onchange="cekPilihan()" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="" disabled selected>-- Pilih Alasan --</option>
                            <option value="Barang Terlarang (Narkoba/Sajam)">Barang Terlarang (Narkoba/Sajam)</option>
                            <option value="Makanan Tidak Higienis/Basi">Makanan Tidak Higienis/Basi</option>
                            <option value="Kemasan Rusak/Terbuka">Kemasan Rusak/Terbuka</option>
                            <option value="Bukan Jam Pelayanan Titipan">Bukan Jam Pelayanan Titipan</option>
                            <option value="Identitas Pengirim Tidak Jelas">Identitas Pengirim Tidak Jelas</option>
                            <option value="Lainnya">Lainnya (Ketik Sendiri)</option>
                        </select>
                    </div>

                    <div class="mb-4" id="boxManual">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Keterangan Tambahan:</label>
                        <textarea id="textManual" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 text-sm" placeholder="Tambahkan detail alasan..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" onclick="tutupModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-bold transition">Batal</button>
                        <button type="button" onclick="kirimPenolakan()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-bold shadow transition">Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let formActionTemplate = "{{ route('petugas.titipan.update', ':id') }}";

        function bukaModalTolak(id) {
            let url = formActionTemplate.replace(':id', id);
            document.getElementById('formTolakUtama').action = url;
            document.getElementById('pilihanAlasan').value = "";
            document.getElementById('textManual').value = "";
            cekPilihan();
            document.getElementById('modalTolak').classList.remove('hidden');
        }

        function tutupModal() {
            document.getElementById('modalTolak').classList.add('hidden');
        }

        function cekPilihan() {
            let pilihan = document.getElementById('pilihanAlasan').value;
            let boxManual = document.getElementById('boxManual');
            let textManual = document.getElementById('textManual');

            if (pilihan === 'Lainnya') {
                boxManual.style.display = 'block';
                textManual.placeholder = "Wajib diisi: Jelaskan alasan spesifik penolakan...";
                textManual.focus();
            } else {
                boxManual.style.display = 'block';
                textManual.placeholder = "Tambahkan detail jika perlu (Opsional)...";
            }
        }

        function kirimPenolakan() {
            let pilihan = document.getElementById('pilihanAlasan').value;
            let manual = document.getElementById('textManual').value;
            let finalReason = "";

            if (!pilihan) {
                alert("Harap pilih alasan penolakan terlebih dahulu!");
                return;
            }

            if (pilihan === 'Lainnya') {
                if (!manual.trim()) {
                    alert("Untuk pilihan 'Lainnya', Anda wajib mengisi keterangan tambahan!");
                    return;
                }
                finalReason = manual;
            } else {
                if (manual.trim()) {
                    finalReason = pilihan + " - " + manual;
                } else {
                    finalReason = pilihan;
                }
            }
            document.getElementById('inputAlasanFinal').value = finalReason;
            document.getElementById('formTolakUtama').submit();
        }

        window.onclick = function(event) {
            let modal = document.getElementById('modalTolak');
            if (event.target == modal) {
                tutupModal();
            }
        }
    </script>
</x-app-layout>