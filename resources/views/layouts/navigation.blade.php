<nav x-data="{ open: false }" class="bg-slate-800 border-b border-slate-700 sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="bg-slate-700 p-2 rounded-lg border border-slate-600">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-white leading-tight tracking-wide">SIP-RUTAN</span>
                            <span class="text-[10px] text-slate-400 uppercase tracking-wider">Sistem Kunjungan Tahanan</span>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->role == 'petugas')
                    <x-nav-link :href="route('petugas.index')" :active="request()->routeIs('petugas.index')" class="text-slate-300 hover:text-white hover:border-blue-400 focus:text-white focus:border-blue-400">
                        {{ __('Verifikasi Masuk') }}
                    </x-nav-link>
                    <x-nav-link :href="route('petugas.riwayat')" :active="request()->routeIs('petugas.riwayat')" class="text-slate-300 hover:text-white hover:border-blue-400 focus:text-white focus:border-blue-400">
                        {{ __('Riwayat Proses') }}
                    </x-nav-link>
                    @endif

                    @if(Auth::user()->role == 'masyarakat')
                    <x-nav-link :href="route('masyarakat.index')" :active="request()->routeIs('masyarakat.index')" class="text-slate-300 hover:text-white">
                        {{ __('Permohonan Saya') }}
                    </x-nav-link>
                    @endif

                    @if(Auth::user()->role == 'kepala')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-300 hover:text-white">
                        {{ __('Laporan Pimpinan') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-600 text-sm leading-4 font-medium rounded-lg text-slate-300 bg-slate-700 hover:text-white hover:bg-slate-600 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-slate-500 flex items-center justify-center text-xs text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 text-xs text-slate-500 border-b border-gray-100 bg-gray-50">
                            Role: <span class="font-bold text-blue-600 uppercase">{{ Auth::user()->role }}</span>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-900 border-t border-slate-700">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role == 'petugas')
            <x-responsive-nav-link :href="route('petugas.index')" :active="request()->routeIs('petugas.index')" class="text-slate-300 hover:bg-slate-800 hover:text-white">
                {{ __('Verifikasi Masuk') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('petugas.riwayat')" :active="request()->routeIs('petugas.riwayat')" class="text-slate-300 hover:bg-slate-800 hover:text-white">
                {{ __('Riwayat Proses') }}
            </x-responsive-nav-link>
            @endif
            @if(Auth::user()->role == 'masyarakat')
            <x-responsive-nav-link :href="route('masyarakat.index')" :active="request()->routeIs('masyarakat.index')">
                {{ __('Permohonan Saya') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>