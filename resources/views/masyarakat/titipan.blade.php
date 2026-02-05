<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Layanan Titipan Barang') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Formulir khusus penitipan makanan/barang tanpa tatap muka.</p>
    </x-slot>

    <div class="py-8 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('masyarakat.index') }}" class="text-slate-500 hover:text-[#0f172a] font-bold text-sm flex items-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

            @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Ada kesalahan pada isian form:</h3>
                        <ul class="mt-1 list-disc list-inside text-xs text-red-700">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('titipan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white shadow-xl sm:rounded-2xl border border-slate-200 overflow-hidden">

                    <div class="bg-[#0f172a] px-6 py-5 border-b border-slate-700 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="bg-white/10 p-2 rounded-lg text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Data Barang Titipan</h3>
                                <p class="text-xs text-slate-400">Pengirim: {{ Auth::user()->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div class="space-y-6">
                            <h4 class="text-sm uppercase tracking-wider text-slate-500 font-bold border-b border-slate-100 pb-2">Tujuan Pengiriman</h4>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Tahanan Penerima <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_tahanan" class="w-full rounded-xl border-slate-300 focus:border-[#0f172a] focus:ring-[#0f172a] shadow-sm transition" placeholder="Contoh: Budi Bin Suparman" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Blok / Kamar (Opsional)</label>
                                <input type="text" name="blok_kamar" class="w-full rounded-xl border-slate-300 focus:border-[#0f172a] focus:ring-[#0f172a] shadow-sm transition" placeholder="Contoh: Blok A - 12">
                                <p class="text-[10px] text-slate-400 mt-1">Isi jika Anda mengetahui posisi kamar tahanan.</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h4 class="text-sm uppercase tracking-wider text-slate-500 font-bold border-b border-slate-100 pb-2">Rincian Barang</h4>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Titipan <span class="text-red-500">*</span></label>
                                <select name="jenis_titipan" class="w-full rounded-xl border-slate-300 focus:border-[#0f172a] focus:ring-[#0f172a] shadow-sm transition" required>
                                    <option value="">-- Pilih Jenis Barang --</option>
                                    <option value="Makanan">🍔 Makanan / Minuman</option>
                                    <option value="Pakaian">👕 Pakaian / Baju</option>
                                    <option value="Uang">💸 Uang Tunai</option>
                                    <option value="Obat-obatan">💊 Obat-obatan (Wajib Resep)</option>
                                    <option value="Lainnya">📦 Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Foto Barang <span class="text-red-500">*</span></label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 hover:border-blue-800 transition group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-2 text-slate-400 group-hover:text-[#0f172a] transition" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="text-xs text-slate-500 group-hover:text-[#0f172a]"><span class="font-bold">Klik untuk upload</span> atau drag foto</p>
                                            <p class="text-[10px] text-slate-400">JPG, PNG (Max. 2MB)</p>
                                        </div>
                                        <input id="dropzone-file" name="foto_barang" type="file" class="hidden" accept="image/*" required />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Rincian Isi Barang (Detail) <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi_barang" rows="3" class="w-full rounded-xl border-slate-300 focus:border-[#0f172a] focus:ring-[#0f172a] shadow-sm transition" placeholder="Contoh: Nasi Goreng 2 Bungkus, Rokok Sampoerna 1 Bungkus, Uang Rp 100.000 (Pecahan 50rb 2 lembar)" required></textarea>
                            <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Harap rincikan dengan jelas untuk memudahkan pemeriksaan oleh petugas.
                            </p>
                        </div>

                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-200">
                        <a href="{{ route('masyarakat.index') }}" class="w-full sm:w-auto px-6 py-3 bg-white text-slate-700 border border-slate-300 font-bold rounded-xl hover:bg-slate-50 transition text-center">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#0f172a] text-white font-bold rounded-xl shadow-lg hover:bg-slate-800 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Kirim Permohonan
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>