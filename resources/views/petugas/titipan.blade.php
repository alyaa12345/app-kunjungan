<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white pt-2 pb-4">
            <div>
                <span class="bg-amber-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-md tracking-widest uppercase shadow-sm">
                    Mode Kejaksaan
                </span>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight mt-2">
                    Verifikasi Titipan Barang
                </h2>
                <p class="text-sm text-slate-500 font-medium mt-1">
                    Pemeriksaan administratif dan persetujuan penitipan barang/makanan.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-emerald-400 mr-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- FILTER / SARING DATA DIPINDAH KE ATAS AGAR LEBIH RAPI -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-3">
                    <div class="w-8 h-8 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wide">Penyaringan Data</h3>
                </div>

                <form action="{{ route('petugas.titipan.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-5/12">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Cari Kata Kunci</label>
                        <input type="text" name="cari" value="{{ request('cari') }}" class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-amber-400 focus:border-amber-400" placeholder="Ketik Nama / ID Titipan...">
                    </div>

                    <div class="w-full md:w-4/12">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Status Administrasi</label>
                        <select name="status" class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-amber-400 focus:border-amber-400">
                            <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Tampilkan Semua</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Menunggu Verifikasi Baru</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Telah Disetujui (ACC)</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak Kejaksaan</option>
                        </select>
                    </div>

                    <div class="w-full md:w-3/12 flex gap-2">
                        <button type="submit" class="flex-1 bg-[#0f172a] hover:bg-slate-800 text-[#F5C542] font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm text-sm flex items-center justify-center gap-2">
                            Terapkan
                        </button>
                        
                        @if(request('cari') || request('status'))
                        <a href="{{ route('petugas.titipan.index') }}" class="w-11 h-11 shrink-0 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl border border-red-100 flex items-center justify-center transition-all shadow-sm" title="Bersihkan Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- TABEL DATA -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="text-[15px] font-extrabold text-slate-800 tracking-wide">Daftar Permohonan Titipan</h3>
                        <p class="text-xs text-slate-500 mt-1 font-medium">Data barang yang perlu divalidasi dan dicetak labelnya.</p>
                    </div>
                </div>

                @if($titipans->isEmpty())
                <div class="p-20 flex flex-col items-center justify-center text-center bg-slate-50/50">
                    <div class="w-20 h-20 bg-white shadow-sm border border-slate-100 rounded-full flex items-center justify-center mb-5">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h4 class="font-black text-slate-700 text-xl tracking-wide">Meja Kerja Bersih!</h4>
                    <p class="text-sm text-slate-500 mt-2 max-w-md">Tidak ada data titipan yang sesuai dengan penyaringan Anda atau belum ada permohonan baru.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="bg-slate-50 text-slate-400 text-xs uppercase font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">ID & Pengirim</th>
                                <th class="px-6 py-4">Warga Binaan</th>
                                <th class="px-6 py-4">Foto & Rincian Barang</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi Administrasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($titipans as $t)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-amber-600 mb-1">#TTP-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    <div class="font-bold text-slate-800">{{ $t->user->name ?? 'Tidak Diketahui' }}</div>
                                    <div class="text-[11px] text-slate-500">{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg bg-blue-50 text-blue-700 font-bold border border-blue-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $t->nama_tahanan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        @if(!empty($t->foto_barang))
                                        <a href="{{ asset('storage/' . $t->foto_barang) }}" target="_blank" class="shrink-0">
                                            <img src="{{ asset('storage/' . $t->foto_barang) }}" alt="Foto Barang" class="w-14 h-14 object-cover rounded-xl border border-slate-200 shadow-sm hover:scale-105 transition-transform">
                                        </a>
                                        @else
                                        <div class="w-14 h-14 shrink-0 bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        @endif
                                        <div class="font-medium text-slate-700 leading-tight">{{ $t->deskripsi_barang ?? 'Tidak ada rincian.' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($t->status == 'diajukan' || $t->status == 'menunggu')
                                    <span class="bg-amber-100 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider">Perlu Cek</span>
                                    @elseif($t->status == 'disetujui' || $t->status == 'diterima' || $t->status == 'selesai')
                                    <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider">Disetujui</span>
                                    @elseif($t->status == 'ditolak')
                                    <span class="bg-red-100 text-red-700 border border-red-200 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($t->status == 'diajukan' || $t->status == 'menunggu')
                                        <form action="{{ route('petugas.titipan.update', $t->id) }}" method="POST" onsubmit="return confirm('Setujui berkas titipan ini?');">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white p-2.5 rounded-xl transition-colors shadow-sm" title="Setujui Titipan">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        </form>

                                        <button type="button" onclick="bukaModalTolak({{ $t->id }})" class="bg-red-500 hover:bg-red-600 text-white p-2.5 rounded-xl transition-colors shadow-sm" title="Tolak Titipan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        @elseif($t->status == 'disetujui' || $t->status == 'diterima' || $t->status == 'selesai')
                                        <a href="{{ route('petugas.titipan.cetak', $t->id) }}" target="_blank" class="inline-flex items-center gap-1.5 bg-slate-800 hover:bg-slate-900 text-[#F5C542] px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                            Cetak Label
                                        </a>
                                        @elseif($t->status == 'ditolak')
                                        <span class="text-[11px] font-bold text-red-500 bg-red-50 px-2 py-1 rounded border border-red-100 text-center">Ditolak:<br>{{ $t->alasan_penolakan ?? 'Melanggar aturan' }}</span>
                                        @endif
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

    <!-- MODAL PENOLAKAN -->
    <div id="modalTolak" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="tutupModalTolak()"></div>
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md relative z-10 overflow-hidden transform transition-all">
            <div class="p-5 border-b border-slate-100 bg-red-50 flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-black text-red-800 text-lg">Tolak Titipan Barang</h3>
                    <p class="text-xs text-red-600 font-medium mt-0.5">Beritahu masyarakat alasan penolakannya.</p>
                </div>
            </div>
            <form id="formTolak" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="ditolak">
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Pilih Alasan Utama</label>
                        <select id="pilihanAlasan" class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-red-400 focus:border-red-400 py-3" onchange="toggleAlasanLainnya(this.value)">
                            <option value="">-- Silakan Pilih Alasan --</option>
                            <option value="Barang termasuk dalam kategori terlarang (Sajam, Narkoba, dsb).">Barang termasuk kategori dilarang.</option>
                            <option value="Jumlah titipan barang/makanan melebihi batas maksimal yang diizinkan.">Jumlah melebihi batas ketentuan.</option>
                            <option value="Bungkusan/Kemasan tidak transparan atau mencurigakan.">Kemasan tidak sesuai SOP.</option>
                            <option value="Pengajuan di luar jam operasional kunjungan Lapas.">Pengajuan di luar jam operasional.</option>
                            <option value="lainnya">Lainnya (Ketik sendiri di bawah)...</option>
                        </select>
                    </div>
                    <div id="wadahAlasanCustom" class="hidden transition-all">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span> Ketik Alasan Spesifik
                        </label>
                        <textarea id="alasanCustom" rows="3" class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-red-400 focus:border-red-400" placeholder="Ketik alasan spesifik penolakan Anda di sini..."></textarea>
                    </div>
                    <input type="hidden" name="alasan" id="alasanFinal">
                </div>
                <div class="p-5 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                    <button type="button" onclick="tutupModalTolak()" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-100 transition-colors">Batalkan</button>
                    <button type="submit" onclick="siapkanAlasanFinal()" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Logika Modal Tolak
        function bukaModalTolak(id) {
            const baseUrl = "{{ url('petugas/titipan') }}";
            document.getElementById('formTolak').action = baseUrl + '/' + id;
            document.getElementById('modalTolak').classList.remove('hidden');
            document.getElementById('pilihanAlasan').value = '';
            document.getElementById('wadahAlasanCustom').classList.add('hidden');
            document.getElementById('alasanCustom').value = '';
        }

        function tutupModalTolak() {
            document.getElementById('modalTolak').classList.add('hidden');
        }

        function toggleAlasanLainnya(value) {
            if (value === 'lainnya') {
                document.getElementById('wadahAlasanCustom').classList.remove('hidden');
            } else {
                document.getElementById('wadahAlasanCustom').classList.add('hidden');
            }
        }

        function siapkanAlasanFinal() {
            const pilihan = document.getElementById('pilihanAlasan').value;
            const custom = document.getElementById('alasanCustom').value;
            const finalInput = document.getElementById('alasanFinal');

            if (pilihan === 'lainnya') {
                finalInput.value = custom;
            } else if (pilihan === '') {
                finalInput.value = "Ditolak oleh Kejaksaan (Berkas tidak memenuhi syarat).";
            } else {
                finalInput.value = pilihan;
            }
        }
    </script>
</x-app-layout>