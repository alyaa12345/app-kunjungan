<x-app-layout>
    <div class="min-h-screen bg-[#F1F5F9] font-sans pb-20">

        <div class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center gap-3">
                    <div class="bg-[#0f172a] text-white p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Gate Check-In</h1>
                        <p class="text-sm text-slate-500">Pos Pemeriksaan Pintu Utama</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 mt-10">

            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="p-8">

                    <div class="text-center mb-8">
                        <img src="{{ asset('assets/logo-kejari.png') }}" class="h-16 w-16 mx-auto mb-4 opacity-80">
                        <h2 class="text-xl font-bold text-slate-800">Validasi Tiket Pengunjung</h2>
                        <p class="text-slate-500 text-sm">Silakan pilih metode input di bawah ini:</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

                        <div class="text-center border-b md:border-b-0 md:border-r border-slate-100 pb-8 md:pb-0 pr-0 md:pr-8">
                            <div class="inline-block p-4 bg-blue-50 rounded-full text-blue-600 mb-3 animate-pulse">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-700">Opsi 1: Gunakan Scanner</h3>
                            <p class="text-xs text-slate-400 mt-1">Arahkan alat scan ke QR Code tiket.</p>
                            <p class="text-[10px] text-green-600 font-bold mt-2 uppercase tracking-widest bg-green-50 inline-block px-2 py-1 rounded">Sistem Siap</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Opsi 2: Ketik Kode Manual</label>

                            <div class="relative group">
                                <input type="text" id="gateScanner" autofocus autocomplete="off"
                                    class="w-full pl-4 pr-12 py-3 rounded-lg border-2 border-slate-300 focus:border-[#F5C542] focus:ring-[#F5C542] text-lg font-bold text-slate-800 uppercase placeholder-slate-300 transition-all shadow-sm"
                                    placeholder="Contoh: REQ-1">

                                <button onclick="manualCheck()" class="absolute right-2 top-2 bottom-2 bg-[#0f172a] hover:bg-[#F5C542] hover:text-[#0f172a] text-white px-4 rounded font-bold transition">
                                    CEK
                                </button>
                            </div>
                            <p class="text-xs text-slate-400 mt-2">
                                *Klik tombol <strong>CEK</strong> atau tekan <strong>ENTER</strong>.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 flex justify-between items-center text-xs text-slate-500">
                    <span>Sistem Gatekeeper v2.0</span>
                    <a href="{{ route('petugas.index') }}" class="hover:text-blue-600 hover:underline">Kembali ke Dashboard</a>
                </div>
            </div>

        </div>
    </div>

    <div id="scanResultModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform scale-100 transition-transform">

            <div id="scanHeader" class="px-8 py-6 text-center text-white relative">
                <div id="scanIcon" class="text-6xl mb-2 drop-shadow-md"></div>
                <h2 id="scanTitle" class="text-2xl font-bold uppercase tracking-wide"></h2>
                <div id="scanSubtitle" class="text-sm font-medium opacity-90"></div>
            </div>

            <div class="p-6 space-y-4">
                <div class="text-center">
                    <h3 id="scanNama" class="text-xl font-bold text-slate-800"></h3>
                    <p id="scanInfo" class="text-slate-500 text-sm"></p>
                </div>

                <div class="flex items-center gap-4 bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <img id="scanFoto" src="" class="w-14 h-14 rounded-lg object-cover bg-slate-200 shadow-sm border border-slate-300">
                    <div class="flex-1 space-y-1">
                        <div class="flex justify-between border-b border-slate-200 pb-1">
                            <span class="text-[10px] uppercase font-bold text-slate-400">Tujuan</span>
                            <span id="scanTahanan" class="text-xs font-bold text-slate-800"></span>
                        </div>
                        <div class="flex justify-between pt-1">
                            <span class="text-[10px] uppercase font-bold text-slate-400">Kamar</span>
                            <span id="scanKamar" class="text-xs font-bold text-slate-800 bg-white px-2 rounded border border-slate-200"></span>
                        </div>
                    </div>
                </div>

                <button onclick="closeScanModal()" class="w-full py-3 bg-[#0f172a] text-white font-bold rounded-xl hover:bg-[#F5C542] hover:text-[#0f172a] transition shadow-lg uppercase text-sm tracking-wide">
                    Tutup & Scan Lagi (Enter)
                </button>
            </div>
        </div>
    </div>

    <script>
        const input = document.getElementById('gateScanner');

        // 1. FOKUS INPUT: Agar siap scan/ketik
        // Kita biarkan user mengetik, tapi jika klik di luar, kita ingatkan.
        document.addEventListener('click', (e) => {
            if (document.getElementById('scanResultModal').classList.contains('hidden')) {
                input.focus();
            }
        });
        input.focus();

        // 2. LISTENER TOMBOL ENTER (PENTING UNTUK SCANNER & MANUAL)
        // Scanner fisik itu cara kerjanya mirip keyboard: mengetik kode lalu tekan Enter otomatis.
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();

                // Jika modal terbuka, Enter menutup modal
                if (!document.getElementById('scanResultModal').classList.contains('hidden')) {
                    closeScanModal();
                } else {
                    // Jika modal tertutup, Enter memicu cek
                    manualCheck();
                }
            }
        });

        // 3. FUNGSI CEK MANUAL (Dipanggil tombol CEK atau Enter)
        function manualCheck() {
            let code = input.value.trim().toUpperCase();

            if (code.length < 3) {
                alert("Kode tiket terlalu pendek!");
                return;
            }

            checkDB(code);
        }

        // 4. AJAX KE SERVER
        async function checkDB(code) {
            // Ubah placeholder biar terlihat loading
            let originalPlaceholder = input.placeholder;
            input.value = "MEMERIKSA...";
            input.disabled = true;

            try {
                let res = await fetch(`{{ route('petugas.checkQr') }}?code=${code}`);
                let data = await res.json();
                showResult(data);
            } catch (e) {
                console.error(e);
                alert("Gagal menghubungi server. Periksa koneksi.");
            } finally {
                input.value = ""; // Kosongkan input
                input.disabled = false;
                input.placeholder = originalPlaceholder;
                input.focus();
            }
        }

        // 5. TAMPILKAN HASIL (POPUP)
        function showResult(res) {
            const header = document.getElementById('scanHeader');
            const modal = document.getElementById('scanResultModal');

            if (res.status === 'not_found') {
                // STATUS: TIDAK DITEMUKAN (ABU-ABU)
                header.className = "px-8 py-6 text-center text-white bg-slate-600";
                document.getElementById('scanIcon').innerText = "🚫";
                document.getElementById('scanTitle').innerText = "Tidak Ditemukan";
                document.getElementById('scanSubtitle').innerText = "Kode tiket salah atau tidak terdaftar.";

                // Kosongkan data
                document.getElementById('scanNama').innerText = "-";
                document.getElementById('scanInfo').innerText = "-";
                document.getElementById('scanTahanan').innerText = "-";
                document.getElementById('scanKamar').innerText = "-";
                document.getElementById('scanFoto').src = "https://via.placeholder.com/150?text=No+Data";
            } else {
                let d = res.data;
                document.getElementById('scanNama').innerText = d.nama_pengunjung;
                document.getElementById('scanInfo').innerText = "+ " + d.jumlah_pengikut + " Pengikut";
                document.getElementById('scanTahanan').innerText = d.nama_tahanan;
                document.getElementById('scanKamar').innerText = d.kamar;
                document.getElementById('scanFoto').src = d.foto ? d.foto : "https://via.placeholder.com/150?text=No+Foto";

                if (d.status_kunjungan === 'disetujui') {
                    // STATUS: SUKSES (HIJAU)
                    header.className = "px-8 py-6 text-center text-white bg-emerald-600";
                    document.getElementById('scanIcon').innerText = "✅";
                    document.getElementById('scanTitle').innerText = "Akses Diterima";
                    document.getElementById('scanSubtitle').innerText = "Silakan Masuk";
                } else if (d.status_kunjungan === 'menunggu') {
                    // STATUS: PENDING (KUNING)
                    header.className = "px-8 py-6 text-center text-white bg-amber-500";
                    document.getElementById('scanIcon').innerText = "⚠️";
                    document.getElementById('scanTitle').innerText = "Belum Verifikasi";
                    document.getElementById('scanSubtitle').innerText = "Arahkan ke Loket Admin";
                } else {
                    // STATUS: DITOLAK (MERAH)
                    header.className = "px-8 py-6 text-center text-white bg-red-600";
                    document.getElementById('scanIcon').innerText = "⛔";
                    document.getElementById('scanTitle').innerText = "Akses Ditolak";
                    document.getElementById('scanSubtitle').innerText = "Permohonan Ditolak Petugas";
                }
            }
            modal.classList.remove('hidden');
        }

        function closeScanModal() {
            document.getElementById('scanResultModal').classList.add('hidden');
            input.focus();
        }
    </script>
</x-app-layout>