<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Formulir Pengajuan Kunjungan') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Mohon isi data di bawah ini dengan lengkap dan benar.</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Harap periksa kembali isian Anda:</h3>
                        <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('masyarakat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white shadow-lg sm:rounded-xl border border-slate-200 overflow-hidden mb-8">
                    <div class="bg-slate-800 px-6 py-4 border-b border-slate-700 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded bg-blue-500 text-white font-bold text-sm">1</span>
                        <h3 class="text-lg font-bold text-white">Identitas Pengunjung</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" name="nama_pengunjung" value="{{ Auth::user()->name }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-slate-700 mb-1">NIK (16 Digit)</label>
                            <input type="number" name="nik_pengunjung" value="{{ Auth::user()->nik }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                                <option value="">- Pilih -</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Hubungan dengan Tahanan</label>
                            <select name="hubungan_tahanan" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                                <option value="">- Pilih Hubungan -</option>
                                <option value="Ayah/Ibu">Ayah/Ibu</option>
                                <option value="Suami/Istri">Suami/Istri</option>
                                <option value="Anak">Anak</option>
                                <option value="Saudara Kandung">Saudara Kandung</option>
                                <option value="Kuasa Hukum">Kuasa Hukum</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat_pengunjung" rows="2" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>{{ Auth::user()->alamat }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-lg sm:rounded-xl border border-slate-200 overflow-hidden mb-8">
                    <div class="bg-slate-800 px-6 py-4 border-b border-slate-700 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded bg-emerald-500 text-white font-bold text-sm">2</span>
                        <h3 class="text-lg font-bold text-white">Data Tahanan Tujuan</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nama Tahanan</label>
                            <input type="text" name="nama_tahanan" placeholder="Contoh: Budi Santoso" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nomor Kamar/Blok</label>
                            <input type="text" name="nomor_kamar" placeholder="Contoh: Blok A-12" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Kasus Tahanan</label>
                            <input type="text" name="kasus_tahanan" placeholder="Contoh: Narkoba/Pencurian" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-lg sm:rounded-xl border border-slate-200 overflow-hidden mb-8">
                    <div class="bg-slate-800 px-6 py-4 border-b border-slate-700 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded bg-purple-500 text-white font-bold text-sm">3</span>
                        <h3 class="text-lg font-bold text-white">Detail Kunjungan</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Rencana Tanggal</label>
                            <input type="date" name="tanggal_kunjungan" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Sesi Kunjungan</label>
                            <select name="jam_kunjungan" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                                <option value="">- Pilih Sesi -</option>
                                <option value="09:00 - 11:30">Pagi (09:00 - 11:30)</option>
                                <option value="13:00 - 15:00">Siang (13:00 - 15:00)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Jumlah Pengikut (Orang)</label>
                            <input type="number" name="jumlah_pengikut" min="0" max="5" value="0" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                            <p class="text-xs text-slate-500 mt-1">*Maksimal 5 orang.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Foto KTP/Identitas</label>
                            <input type="file" name="foto_ktp" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                            <p class="text-xs text-slate-500 mt-1">*Format: JPG/PNG, Max 2MB.</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-1">Keperluan Kunjungan</label>
                            <textarea name="keperluan" rows="3" placeholder="Jelaskan keperluan Anda..." class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pb-10">
                    <a href="{{ route('masyarakat.index') }}" class="px-6 py-3 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 hover:-translate-y-0.5 transition-all transform flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Permohonan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>