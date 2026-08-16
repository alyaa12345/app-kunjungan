<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Pesan Error Validasi -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h4 class="font-bold text-red-800 text-sm">Terdapat Kesalahan!</h4>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ========================================================================= --}}
            {{-- BLOK 1: FORM EDIT KUNJUNGAN --}}
            {{-- ========================================================================= --}}
            @if(isset($kunjungan))
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Edit Permohonan Kunjungan</h2>
                        <p class="text-sm text-slate-500 mt-1">Perbarui data tiket kunjungan Anda (#REQ-{{ $kunjungan->id }})</p>
                    </div>
                    <a href="{{ route('masyarakat.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800 bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm transition">
                        Kembali
                    </a>
                </div>

                <form action="{{ route('masyarakat.update', $kunjungan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                        <div class="bg-slate-900 px-6 py-4 border-b border-slate-800">
                            <h3 class="font-bold text-white flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-[#F5C542] text-[#0f172a] flex items-center justify-center text-xs">1</span>
                                Data Pengunjung
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_pengunjung" value="{{ old('nama_pengunjung', $kunjungan->nama_pengunjung) }}" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">NIK <span class="text-red-500">*</span></label>
                                <input type="number" name="nik_pengunjung" value="{{ old('nik_pengunjung', $kunjungan->nik_pengunjung) }}" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="jenis_kelamin" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" required>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $kunjungan->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $kunjungan->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Hubungan dengan Tahanan <span class="text-red-500">*</span></label>
                                <select name="hubungan_tahanan" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" required>
                                    @php $hubs = ['Suami/Istri', 'Orang Tua', 'Anak', 'Kakak/Adik', 'Keluarga Lainnya', 'Teman', 'Kuasa Hukum']; @endphp
                                    @foreach($hubs as $hub)
                                        <option value="{{ $hub }}" {{ old('hubungan_tahanan', $kunjungan->hubungan_tahanan) == $hub ? 'selected' : '' }}>{{ $hub }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat_pengunjung" rows="3" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" required>{{ old('alamat_pengunjung', $kunjungan->alamat_pengunjung) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                        <div class="bg-slate-900 px-6 py-4 border-b border-slate-800">
                            <h3 class="font-bold text-white flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-[#F5C542] text-[#0f172a] flex items-center justify-center text-xs">2</span>
                                Tujuan Kunjungan (Data Tahanan)
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="mb-6 bg-blue-50 p-4 rounded-xl border border-blue-100 flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-xs text-blue-800">Ketik <b>Nomor Tahanan</b> untuk merubah data tahanan tujuan (otomatis terisi). Jika tidak ingin diubah, biarkan data seperti saat ini.</p>
                            </div>

                            <div class="mb-5 relative">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Tahanan <span class="text-red-500">*</span></label>
                                <input type="text" id="inputNoTahanan" name="no_tahanan" value="{{ old('no_tahanan', $kunjungan->no_tahanan) }}" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm font-mono border-green-500 ring-1 ring-green-500 bg-green-50" autocomplete="off" onkeyup="cariTahanan(this.value)" required>
                                <p id="pesanValidasi" class="text-[11px] mt-1 font-bold h-4 text-green-600">✅ Nomor Ditemukan (Data Saat Ini)</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Tahanan <span class="text-red-500">*</span></label>
                                    <input type="text" id="nama_tahanan" name="nama_tahanan" value="{{ old('nama_tahanan', $kunjungan->nama_tahanan) }}" class="w-full rounded-xl border-slate-300 bg-slate-100 text-slate-600 focus:ring-0 shadow-sm transition-colors text-sm font-bold" required readonly tabindex="-1">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Penahanan</label>
                                    <input type="text" id="lokasi_tahanan" name="lokasi_tahanan" value="{{ old('lokasi_tahanan', $kunjungan->lokasi_tahanan) }}" class="w-full rounded-xl border-slate-300 bg-slate-100 text-slate-600 focus:ring-0 shadow-sm transition-colors text-sm font-bold" readonly tabindex="-1">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Perkara / Kasus (Bila Ada)</label>
                                    <input type="text" id="kasus_tahanan" name="kasus_tahanan" value="{{ old('kasus_tahanan', $kunjungan->kasus_tahanan) }}" class="w-full rounded-xl border-slate-300 bg-slate-100 text-slate-600 focus:ring-0 shadow-sm transition-colors text-sm font-bold" readonly tabindex="-1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                        <div class="bg-slate-900 px-6 py-4 border-b border-slate-800">
                            <h3 class="font-bold text-white flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-[#F5C542] text-[#0f172a] flex items-center justify-center text-xs">3</span>
                                Jadwal & Dokumen
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', $kunjungan->tanggal_kunjungan) }}" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Sesi Waktu <span class="text-red-500">*</span></label>
                                <select name="jam_kunjungan" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" required>
                                    <option value="pagi" {{ old('jam_kunjungan', $kunjungan->jam_kunjungan) == 'pagi' ? 'selected' : '' }}>Sesi Pagi (09:00 - 11:30 WITA)</option>
                                    <option value="siang" {{ old('jam_kunjungan', $kunjungan->jam_kunjungan) == 'siang' ? 'selected' : '' }}>Sesi Siang (13:30 - 15:00 WITA)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Pengikut Tambahan</label>
                                <select name="jumlah_pengikut" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] focus:border-[#0f172a] text-sm" required>
                                    @for($i = 0; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('jumlah_pengikut', $kunjungan->jumlah_pengikut) == $i ? 'selected' : '' }}>{{ $i }} Orang</option>
                                    @endfor
                                </select>
                                <p class="text-[11px] text-slate-500 mt-1">*Maksimal 5 orang. Pilih 0 jika Anda sendirian.</p>
                            </div>
                            <div class="md:row-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Foto KTP / Identitas</label>
                                <div class="bg-slate-50 p-4 rounded-xl border border-dashed border-slate-300 flex gap-4">
                                    @if($kunjungan->foto_ktp)
                                        <div class="w-24 h-16 shrink-0 bg-slate-200 rounded-lg overflow-hidden relative group">
                                            <img src="{{ asset('storage/'.$kunjungan->foto_ktp) }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                    <div>
                                        <input type="file" name="foto_ktp" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#0f172a] file:text-white hover:file:bg-slate-700">
                                        <p class="text-[10px] text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto KTP sebelumnya.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-8">
                        <a href="{{ route('masyarakat.index') }}" class="px-6 py-3 rounded-xl bg-white border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-xl bg-[#0f172a] text-white font-bold text-sm hover:bg-[#F5C542] hover:text-[#0f172a] shadow-lg transition transform hover:-translate-y-1">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <!-- Script Autofill Tahanan Khusus Form Edit Kunjungan -->
                <script>
                    const dataTahanan = @json($tahanans ?? []);
                    function cariTahanan(keyword) {
                        let pesan = document.getElementById('pesanValidasi');
                        let inputNo = document.getElementById('inputNoTahanan');
                        let namaInput = document.getElementById('nama_tahanan');
                        let lokasiInput = document.getElementById('lokasi_tahanan');
                        let kasusInput = document.getElementById('kasus_tahanan');

                        inputNo.classList.remove('border-green-500', 'ring-green-500', 'border-red-500', 'bg-green-50');
                        namaInput.classList.remove('bg-green-100', 'text-green-800');
                        lokasiInput.classList.remove('bg-green-100', 'text-green-800');
                        if(kasusInput) kasusInput.classList.remove('bg-green-100', 'text-green-800');

                        if (keyword.trim() === "") {
                            pesan.innerHTML = "Ketik nomor tahanan secara lengkap untuk mencari.";
                            pesan.className = "text-[11px] mt-1 text-slate-500 font-bold h-4";
                            namaInput.value = ""; lokasiInput.value = ""; if(kasusInput) kasusInput.value = "";
                            return;
                        }

                        let match = dataTahanan.find(t => t.no_tahanan && t.no_tahanan.toLowerCase() === keyword.toLowerCase().trim());

                        if (match) {
                            pesan.innerHTML = "✅ Nomor Ditemukan (Data Terisi)";
                            pesan.className = "text-[11px] mt-1 text-green-600 font-bold h-4";
                            inputNo.classList.add('border-green-500', 'ring-green-500', 'bg-green-50');
                            namaInput.value = match.nama_tahanan || ""; namaInput.classList.add('bg-green-100', 'text-green-800');
                            lokasiInput.value = match.lokasi_tahanan || ""; lokasiInput.classList.add('bg-green-100', 'text-green-800');
                            if(kasusInput) {
                                kasusInput.value = match.perkara || match.kasus_tahanan || "-";
                                kasusInput.classList.add('bg-green-100', 'text-green-800');
                            }
                        } else {
                            pesan.innerHTML = "❌ Data tidak ditemukan. Pastikan ketik lengkap!";
                            pesan.className = "text-[11px] mt-1 text-red-600 font-bold h-4";
                            inputNo.classList.add('border-red-500');
                            namaInput.value = ""; lokasiInput.value = ""; if(kasusInput) kasusInput.value = "";
                        }
                    }
                </script>

            {{-- ========================================================================= --}}
            {{-- BLOK 2: FORM EDIT TITIPAN --}}
            {{-- ========================================================================= --}}
            @elseif(isset($titipan))
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">Edit Titipan Barang</h2>
                        <p class="text-sm text-slate-500 mt-1">Perbarui data titipan Anda (#TTP-{{ $titipan->id }})</p>
                    </div>
                    <a href="{{ route('masyarakat.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800 bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm transition">
                        Kembali
                    </a>
                </div>

                <form action="{{ route('masyarakat.titipan.update', $titipan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8 mb-6">
                        
                        <div class="mb-6 relative">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Tahanan <span class="text-red-500">*</span></label>
                            <input type="text" id="inputNoTahananTitipan" name="no_tahanan" value="{{ old('no_tahanan', $titipan->no_tahanan) }}" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] text-sm bg-green-50 border-green-500 ring-1 ring-green-500" autocomplete="off" onkeyup="cariTahananTitipan(this.value)" required>
                            <p id="pesanValidasiTitipan" class="text-[11px] mt-1 font-bold h-4 text-green-600">✅ Data Saat Ini</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Tahanan <span class="text-red-500">*</span></label>
                                <input type="text" id="nama_tahanan_titipan" name="nama_tahanan" value="{{ old('nama_tahanan', $titipan->nama_tahanan) }}" class="w-full rounded-xl border-slate-300 bg-slate-100 text-slate-600 text-sm font-bold" required readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Penahanan</label>
                                <input type="text" id="lokasi_tahanan_titipan" name="lokasi_tahanan" value="{{ old('lokasi_tahanan', $titipan->lokasi_tahanan) }}" class="w-full rounded-xl border-slate-300 bg-slate-100 text-slate-600 text-sm font-bold" readonly>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Barang <span class="text-red-500">*</span></label>
                            <select name="jenis_titipan" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] text-sm" required>
                                @php $jenis = ['Makanan', 'Pakaian', 'Uang', 'Obat-obatan', 'Lainnya']; @endphp
                                @foreach($jenis as $j)
                                    <option value="{{ $j }}" {{ old('jenis_titipan', $titipan->jenis_titipan) == $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Rincian Barang <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi_barang" rows="3" class="w-full rounded-xl border-slate-300 focus:ring-[#0f172a] text-sm" required>{{ old('deskripsi_barang', $titipan->deskripsi_barang) }}</textarea>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Foto Barang</label>
                            <div class="bg-slate-50 p-4 rounded-xl border border-dashed border-slate-300 flex flex-col sm:flex-row gap-4">
                                @if($titipan->foto_barang)
                                    <div class="w-24 h-24 shrink-0 bg-slate-200 rounded-lg overflow-hidden border border-slate-300">
                                        <img src="{{ asset('storage/'.$titipan->foto_barang) }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <div>
                                    <input type="file" name="foto_barang" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#0f172a] file:text-white hover:file:bg-slate-700">
                                    <p class="text-[11px] text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto barang saat ini.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('masyarakat.index') }}" class="px-6 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50">Batal</a>
                            <button type="submit" class="px-8 py-2.5 rounded-xl bg-[#0f172a] text-white font-bold text-sm hover:bg-[#F5C542] hover:text-[#0f172a] shadow-lg">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>

                <!-- Script Autofill Tahanan Khusus Form Edit Titipan -->
                <script>
                    const activePrisonersTitipan = @json($tahanans ?? []);
                    function cariTahananTitipan(keyword) {
                        let pesan = document.getElementById('pesanValidasiTitipan');
                        let inputNo = document.getElementById('inputNoTahananTitipan');
                        let namaInput = document.getElementById('nama_tahanan_titipan');
                        let lokasiInput = document.getElementById('lokasi_tahanan_titipan');

                        inputNo.classList.remove('border-green-500', 'ring-green-500', 'border-red-500', 'bg-green-50');

                        if (keyword.trim() === "") {
                            pesan.innerHTML = "Ketik nomor tahanan secara lengkap untuk mencari.";
                            pesan.className = "text-[11px] mt-1 text-slate-500 font-bold h-4";
                            namaInput.value = ""; lokasiInput.value = "";
                            return;
                        }

                        let match = activePrisonersTitipan.find(t => t.no_tahanan && t.no_tahanan.toLowerCase() === keyword.toLowerCase().trim());

                        if (match) {
                            pesan.innerHTML = "✅ Nomor Ditemukan";
                            pesan.className = "text-[11px] mt-1 text-green-600 font-bold h-4";
                            inputNo.classList.add('border-green-500', 'ring-green-500', 'bg-green-50');
                            namaInput.value = match.nama_tahanan || "";
                            lokasiInput.value = match.lokasi_tahanan || "";
                        } else {
                            pesan.innerHTML = "❌ Data tidak ditemukan.";
                            pesan.className = "text-[11px] mt-1 text-red-600 font-bold h-4";
                            inputNo.classList.add('border-red-500');
                            namaInput.value = ""; lokasiInput.value = "";
                        }
                    }
                </script>
            @endif

        </div>
    </div>
</x-app-layout>