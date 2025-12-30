<nav x-data="{ open: false }" class="bg-[#0f172a] border-b border-[#F5C542] sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/logo-kejari.png') }}" class="h-8 w-8 object-contain" onerror="this.style.display='none'">
                    </a>
                    <div class="flex flex-col justify-center">
                        <span class="font-bold text-white text-lg leading-none">SIP-RUTAN</span>
                        <span class="text-[10px] text-gray-400 uppercase leading-none mt-1">Kejari Banjarmasin</span>
                    </div>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    {{-- ============================== --}}
                    {{-- 1. MENU KHUSUS PETUGAS         --}}
                    {{-- ============================== --}}
                    @if(Auth::user()->role == 'petugas')
                    @php
                    // Hitung notifikasi (Hanya dijalankan jika user adalah petugas)
                    $notifCount = \App\Models\Kunjungan::where('status', 'menunggu')->count();
                    @endphp

                    <x-nav-link :href="route('petugas.index')" :active="request()->routeIs('petugas.index')"
                        class="text-gray-300 hover:text-[#F5C542] hover:border-[#F5C542] transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Verifikasi
                        @if($notifCount > 0)
                        <span class="ml-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full animate-pulse">{{ $notifCount }}</span>
                        @endif
                    </x-nav-link>

                    <x-nav-link :href="route('petugas.gate')" :active="request()->routeIs('petugas.gate')"
                        class="text-gray-300 hover:text-[#F5C542] hover:border-[#F5C542] transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Gate Check-In
                    </x-nav-link>

                    <x-nav-link :href="route('petugas.riwayat')" :active="request()->routeIs('petugas.riwayat')" class="text-gray-300 hover:text-white">Arsip</x-nav-link>
                    <x-nav-link :href="route('petugas.laporan')" :active="request()->routeIs('petugas.laporan')" class="text-gray-300 hover:text-white">Laporan</x-nav-link>
                    @endif

                    {{-- ============================== --}}
                    {{-- 2. MENU KHUSUS MASYARAKAT      --}}
                    {{-- ============================== --}}
                    @if(Auth::user()->role == 'masyarakat')
                    <x-nav-link :href="route('masyarakat.index')" :active="request()->routeIs('masyarakat.index')"
                        class="text-gray-300 hover:text-[#F5C542] hover:border-[#F5C542] transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Beranda
                    </x-nav-link>

                    <x-nav-link :href="route('masyarakat.riwayat')" :active="request()->routeIs('masyarakat.riwayat')"
                        class="text-gray-300 hover:text-[#F5C542] hover:border-[#F5C542] transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Saya
                    </x-nav-link>
                    @endif

                    {{-- ============================== --}}
                    {{-- 3. MENU KHUSUS ADMIN / KEPALA  --}}
                    {{-- ============================== --}}
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'kepala')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white">
                        Dashboard
                    </x-nav-link>

                    {{-- Jika ada route user management, buka komentar di bawah --}}
                    {{-- <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')" class="text-gray-300 hover:text-white">Kelola User</x-nav-link> --}}

                    @if(Route::has('petugas.laporan'))
                    <x-nav-link :href="route('petugas.laporan')" :active="request()->routeIs('petugas.laporan')" class="text-gray-300 hover:text-white">
                        Laporan
                    </x-nav-link>
                    @endif
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-300 hover:text-white hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                            <div class="text-right mr-3 hidden md:block">
                                <div class="text-[10px] uppercase tracking-wider opacity-70">{{ Auth::user()->role }}</div>
                                <div class="font-bold">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="h-9 w-9 rounded bg-[#F5C542] text-[#0f172a] flex items-center justify-center font-bold text-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-bold">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-800 border-t border-slate-700">
        <div class="pt-2 pb-3 space-y-1">

            {{-- MOBILE MENU PETUGAS --}}
            @if(Auth::user()->role == 'petugas')
            <x-responsive-nav-link :href="route('petugas.index')" :active="request()->routeIs('petugas.index')">Verifikasi</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.gate')" :active="request()->routeIs('petugas.gate')">Gate Check-In</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.riwayat')" :active="request()->routeIs('petugas.riwayat')">Arsip</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.laporan')" :active="request()->routeIs('petugas.laporan')">Laporan</x-responsive-nav-link>

            {{-- MOBILE MENU MASYARAKAT --}}
            @elseif(Auth::user()->role == 'masyarakat')
            <x-responsive-nav-link :href="route('masyarakat.index')" :active="request()->routeIs('masyarakat.index')">Beranda</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('masyarakat.riwayat')" :active="request()->routeIs('masyarakat.riwayat')">Riwayat Saya</x-responsive-nav-link>

            {{-- MOBILE MENU ADMIN --}}
            @else
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            @if(Route::has('petugas.laporan'))
            <x-responsive-nav-link :href="route('petugas.laporan')" :active="request()->routeIs('petugas.laporan')">Laporan</x-responsive-nav-link>
            @endif
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-slate-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>