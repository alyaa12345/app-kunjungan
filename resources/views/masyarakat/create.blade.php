<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Formulir Pengajuan Kunjungan') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Isi data lengkap. Sistem otomatis mengecek ketersediaan kuota & status tahanan.</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERT ERROR --}}
            @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm animate-pulse">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-bold text-red-800">Mohon Periksa Kembali</h3>
                        <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('masyarakat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- BAGIAN 1: IDENTITAS PENGUNJUNG --}}
                <div class="bg-white shadow-lg sm:rounded-xl border border-slate-200 overflow-hidden mb-8">
                    <div class="bg-slate-800 px-6 py-4 border-b border-slate-700 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded bg-blue-500 text-white font-bold text-sm">1</span>
                        <h3 class="text-lg font-bold text-white">Identitas Pengunjung</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_pengunjung" value="{{ Auth::user()->name }}" class="w-full rounded-lg border-slate-300 bg-slate-100 text-slate-500 cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">NIK (16 Digit) <span class="text-red-500">*</span></label>
                            <input type="number" name="nik_pengunjung" value="{{ old('nik_pengunjung', Auth::user()->nik ?? '') }}" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required placeholder="Masukkan 16 Digit NIK">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>
                                <option value="">- Pilih -</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Hubungan dengan Tahanan <span class="text-red-500">*</span></label>
                            <select name="hubungan_tahanan" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>
                                <option value="">- Pilih Hubungan -</option>
                                <option value="Keluarga Inti" {{ old('hubungan_tahanan') == 'Keluarga Inti' ? 'selected' : '' }}>Keluarga Inti (Ayah/Ibu/Anak)</option>
                                <option value="Saudara" {{ old('hubungan_tahanan') == 'Saudara' ? 'selected' : '' }}>Saudara Kandung</option>
                                <option value="Kuasa Hukum" {{ old('hubungan_tahanan') == 'Kuasa Hukum' ? 'selected' : '' }}>Kuasa Hukum</option>
                                <option value="Teman" {{ old('hubungan_tahanan') == 'Teman' ? 'selected' : '' }}>Teman / Kerabat</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat_pengunjung" rows="2" class="w-full rounded-lg border-slate-300" required>{{ old('alamat_pengunjung', Auth::user()->alamat ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 2: DATA TAHANAN (AUTOFILL STRICT MODE) --}}
                <div class="bg-white shadow-lg sm:rounded-xl border border-slate-200 overflow-hidden mb-8">
                    <div class="bg-slate-800 px-6 py-4 border-b border-slate-700 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded bg-emerald-500 text-white font-bold text-sm">2</span>
                        <h3 class="text-lg font-bold text-white">Data Tahanan Tujuan</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- INPUT NOMOR TAHANAN (TANPA DROPDOWN) --}}
                        <div class="relative">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nomor Tahanan <span class="text-red-500">*</span></label>
                            <input type="text"
                                id="inputNoTahanan"
                                name="no_tahanan"
                                value="{{ old('no_tahanan') }}"
                                class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 transition duration-200"
                                placeholder="Ketik Nomor Lengkap (Contoh: T-6578)"
                                autocomplete="off"
                                onkeyup="cariTahanan(this.value)"
                                required>

                            {{-- PESAN VALIDASI --}}
                            <p id="pesanValidasi" class="text-xs mt-1 font-bold h-4 text-blue-500">Ketik nomor tahanan secara lengkap untuk mencari.</p>
                        </div>

                        {{-- NAMA TAHANAN (AUTOFILL) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nama Tahanan <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_tahanan" name="nama_tahanan" value="{{ old('nama_tahanan') }}" class="w-full rounded-lg border-slate-300 bg-gray-50 text-slate-600 transition-colors duration-300 pointer-events-none" placeholder="Akan terisi otomatis..." required readonly tabindex="-1">
                        </div>

                        {{-- LOKASI (AUTOFILL) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Lokasi Penahanan <span class="text-red-500">*</span></label>
                            <select name="lokasi_tahanan" id="lokasi_tahanan" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 bg-gray-50 transition-colors duration-300 pointer-events-none" required tabindex="-1">
                                <option value="">- Akan Terisi Otomatis -</option>
                                <option value="Lapas Teluk Dalam" {{ old('lokasi_tahanan') == 'Lapas Teluk Dalam' ? 'selected' : '' }}>Lapas Teluk Dalam</option>
                                <option value="LPP Martapura" {{ old('lokasi_tahanan') == 'LPP Martapura' ? 'selected' : '' }}>LPP Martapura (Wanita)</option>
                                <option value="LPKA Martapura" {{ old('lokasi_tahanan') == 'LPKA Martapura' ? 'selected' : '' }}>LPKA Martapura (Anak)</option>
                                <option value="Rutan Polresta" {{ old('lokasi_tahanan') == 'Rutan Polresta' ? 'selected' : '' }}>Rutan Polresta</option>
                                <option value="Lainnya" {{ old('lokasi_tahanan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        {{-- KASUS (AUTOFILL) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Perkara / Kasus <span class="text-red-500">*</span></label>
                            <input type="text"
                                name="kasus_tahanan"
                                id="kasus_tahanan"
                                value="{{ old('kasus_tahanan') }}"
                                class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 bg-gray-50 transition-colors duration-300 pointer-events-none"
                                placeholder="Akan terisi otomatis..."
                                required readonly tabindex="-1">
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 3: JADWAL & KUOTA --}}
                <div class="bg-white shadow-lg sm:rounded-xl border border-slate-200 overflow-hidden mb-8">
                    <div class="bg-slate-800 px-6 py-4 border-b border-slate-700 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded bg-purple-500 text-white font-bold text-sm">3</span>
                        <h3 class="text-lg font-bold text-white">Jadwal & Kuota (Realtime)</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Pilih Tanggal Kunjungan <span class="text-red-500">*</span></label>
                            <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}" class="w-full rounded-lg border-slate-300 focus:ring-purple-500" required>
                            <p id="loading-msg" class="text-xs text-blue-600 mt-2 hidden font-bold animate-pulse">
                                🔄 Sedang mengecek ketersediaan kuota...
                            </p>
                            <p id="libur-msg" class="text-xs text-red-600 mt-2 hidden font-bold bg-red-100 p-2 rounded">
                                ⛔ Maaf, hari Sabtu & Minggu pelayanan libur.
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Pilih Sesi (Sesuai Kuota) <span class="text-red-500">*</span></label>
                            <select id="jam_kunjungan" name="jam_kunjungan" class="w-full rounded-lg border-slate-300 focus:ring-purple-500 bg-gray-50 cursor-not-allowed" disabled required>
                                <option value="">-- Pilih Tanggal Dahulu --</option>
                            </select>
                            @error('jam_kunjungan')
                            <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Jumlah Pengikut <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_pengikut" min="0" max="5" value="{{ old('jumlah_pengikut', 0) }}" class="w-24 rounded-lg border-slate-300 text-center font-bold" required>
                            <span class="text-xs text-slate-500 ml-2">Maksimal 5 Orang</span>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Foto KTP Asli <span class="text-red-500">*</span></label>
                            <input type="file" name="foto_ktp" accept="image/*" class="block w-full text-sm text-slate-500 file:bg-purple-50 file:text-purple-700 file:rounded-full file:border-0 file:px-4 file:py-2 file:font-semibold" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Keperluan (Opsional)</label>
                            <textarea name="keperluan" rows="2" class="w-full rounded-lg border-slate-300">{{ old('keperluan') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                            <textarea name="catatan" rows="2" class="w-full rounded-lg border-slate-300" placeholder="Pesan khusus untuk petugas...">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pb-10">
                    <a href="{{ route('masyarakat.index') }}" class="px-6 py-3 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 flex items-center gap-2 transition-all transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Kirim Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT GABUNGAN --}}
    <script>
        const activePrisoners = @json($tahanans);
    </script>

    <script>
        // SCRIPT PENCARIAN & AUTOFILL STRICT (PRIVASI TERJAGA)
        function cariTahanan(keyword) {
            let pesan = document.getElementById('pesanValidasi');
            let inputNo = document.getElementById('inputNoTahanan');

            // Field yang akan diisi otomatis
            let namaInput = document.getElementById('nama_tahanan');
            let lokasiInput = document.getElementById('lokasi_tahanan');
            let kasusInput = document.getElementById('kasus_tahanan');

            // Reset warna input awal
            inputNo.classList.remove('border-green-500', 'ring-green-500', 'border-red-500');

            // Jika input kosong
            if (keyword.trim() === "") {
                pesan.innerHTML = "Ketik nomor tahanan secara lengkap untuk mencari.";
                pesan.className = "text-xs mt-1 text-blue-500 font-bold h-4";

                // Kosongkan form auto-fill
                if (namaInput) {
                    namaInput.value = "";
                    namaInput.classList.remove('bg-green-50');
                }
                if (lokasiInput) {
                    lokasiInput.value = "";
                    lokasiInput.classList.remove('bg-green-50');
                }
                if (kasusInput) {
                    kasusInput.value = "";
                    kasusInput.classList.remove('bg-green-50');
                }
                return;
            }

            // CARI PERSIS SAMA (EXACT MATCH) BERDASARKAN NOMOR TAHANAN SAJA
            let match = activePrisoners.find(t =>
                t.no_tahanan && t.no_tahanan.toLowerCase() === keyword.toLowerCase().trim()
            );

            if (match) {
                // JIKA COCOK 100%
                pesan.innerHTML = "✅ Nomor Ditemukan (Data Terisi)";
                pesan.className = "text-xs mt-1 text-green-600 font-bold h-4";
                inputNo.classList.add('border-green-500', 'ring-green-500');

                // 1. AUTOFILL NAMA TAHANAN
                if (namaInput && match.nama_tahanan) {
                    namaInput.value = match.nama_tahanan;
                    namaInput.classList.add('bg-green-50');
                }

                // 2. AUTOFILL LOKASI
                if (lokasiInput && match.lokasi_tahanan) {
                    lokasiInput.value = match.lokasi_tahanan;
                    lokasiInput.classList.add('bg-green-50');
                }

                // 3. AUTOFILL KASUS
                let dataKasus = match.pasal || match.kasus || match.perkara || match.kejahatan || "";
                if (kasusInput && dataKasus) {
                    kasusInput.value = dataKasus;
                    kasusInput.classList.add('bg-green-50');
                }

            } else {
                // JIKA BELUM COCOK ATAU SALAH
                pesan.innerHTML = "❌ Data tidak ditemukan. Pastikan ketik lengkap!";
                pesan.className = "text-xs mt-1 text-red-600 font-bold h-4";
                inputNo.classList.add('border-red-500');

                // Kosongkan form auto-fill
                if (namaInput) {
                    namaInput.value = "";
                    namaInput.classList.remove('bg-green-50');
                }
                if (lokasiInput) {
                    lokasiInput.value = "";
                    lokasiInput.classList.remove('bg-green-50');
                }
                if (kasusInput) {
                    kasusInput.value = "";
                    kasusInput.classList.remove('bg-green-50');
                }
            }
        }

        // SCRIPT CEK KUOTA (TIDAK BERUBAH)
        const dateInput = document.getElementById('tanggal_kunjungan');
        const sesiSelect = document.getElementById('jam_kunjungan');
        const loadingMsg = document.getElementById('loading-msg');
        const liburMsg = document.getElementById('libur-msg');

        dateInput.min = new Date().toISOString().split("T")[0];

        dateInput.addEventListener('change', function() {
            const dateVal = this.value;
            const dateObj = new Date(dateVal);
            const day = dateObj.getDay();

            sesiSelect.innerHTML = '<option value="">-- Cek Ketersediaan... --</option>';
            sesiSelect.disabled = true;
            sesiSelect.classList.add('bg-gray-50', 'cursor-not-allowed');
            liburMsg.classList.add('hidden');
            this.classList.remove('border-red-500');

            if (day === 0 || day === 6) {
                liburMsg.classList.remove('hidden');
                this.classList.add('border-red-500');
                this.value = '';
                return;
            }

            if (dateVal) {
                loadingMsg.classList.remove('hidden');

                fetch(`{{ route('cek.kuota') }}?date=${dateVal}`)
                    .then(response => response.json())
                    .then(data => {
                        loadingMsg.classList.add('hidden');
                        sesiSelect.disabled = false;
                        sesiSelect.classList.remove('bg-gray-50', 'cursor-not-allowed');
                        sesiSelect.innerHTML = '<option value="">-- Pilih Sesi Tersedia --</option>';

                        if (data.pagi_status === 'FULL') {
                            sesiSelect.innerHTML += `<option value="pagi" disabled class="text-red-500 bg-red-50 font-bold">🔴 Pagi (09:00 - 11:30) - PENUH</option>`;
                        } else {
                            sesiSelect.innerHTML += `<option value="pagi" class="text-green-700 font-bold">🟢 Pagi (09:00 - 11:30) - Sisa ${data.pagi_sisa} Kursi</option>`;
                        }

                        if (data.siang_status === 'FULL') {
                            sesiSelect.innerHTML += `<option value="siang" disabled class="text-red-500 bg-red-50 font-bold">🔴 Siang (13:30 - 15:00) - PENUH</option>`;
                        } else {
                            sesiSelect.innerHTML += `<option value="siang" class="text-green-700 font-bold">🟢 Siang (13:30 - 15:00) - Sisa ${data.siang_sisa} Kursi</option>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadingMsg.classList.add('hidden');
                        alert('Gagal mengambil data kuota.');
                    });
            }
        });
    </script>
</x-app-layout>