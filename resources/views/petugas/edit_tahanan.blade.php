<x-app-layout>
    <x-slot name="header">
        <div class="bg-white pt-2 pb-4">
            <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                Edit Data Tahanan
            </h2>
            <p class="text-sm text-slate-500 font-medium mt-1">
                Perbarui data hukum dan status registrasi tahanan.
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                <form action="{{ route('petugas.tahanan.update', $tahanan->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Nama Tahanan</label>
                        <input type="text" name="nama_tahanan" value="{{ $tahanan->nama_tahanan }}" required class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-400 focus:border-slate-400">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">No Tahanan</label>
                            <input type="text" name="no_tahanan" value="{{ $tahanan->no_tahanan }}" required class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-400 focus:border-slate-400">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">No Register</label>
                            <input type="text" name="no_register" value="{{ $tahanan->no_register }}" required class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-400 focus:border-slate-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white">
                            <option value="Laki-laki" {{ $tahanan->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $tahanan->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Pasal / Perkara</label>
                        <input type="text" name="pasal" value="{{ $tahanan->pasal }}" required class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-400 focus:border-slate-400">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Lokasi Tahanan</label>
                        <input type="text" name="lokasi_tahanan" value="{{ $tahanan->lokasi_tahanan }}" required class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-400 focus:border-slate-400">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Status</label>
                        <select name="status" required class="w-full text-sm border-slate-200 rounded-xl bg-slate-50 focus:bg-white">
                            <option value="Aktif" {{ $tahanan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Non-Aktif" {{ $tahanan->status == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('petugas.tahanan.index') }}" class="w-1/3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-center font-bold py-2.5 rounded-xl transition-all text-sm flex items-center justify-center">
                            Batal
                        </a>
                        <button type="submit" class="w-2/3 bg-[#0f172a] hover:bg-slate-800 text-[#F5C542] font-bold py-2.5 rounded-xl transition-all shadow-sm text-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>