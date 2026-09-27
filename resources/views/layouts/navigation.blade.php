<header class="bg-white border-b border-neutral-200 sticky top-0 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                <div class="w-10 h-10 rounded-md bg-red-600 flex items-center justify-center text-white shadow-xs">
            <img src="{{ asset('images/logo.webp') }}" alt="logo"/>
                </div>
                <div>
                    <span class="text-base font-bold tracking-tight text-neutral-900 block leading-tight">KitaSiaga</span>
                    <span class="text-[11px] font-medium text-neutral-500 block uppercase tracking-wider">Dashboard Relawan</span>
                </div>
            </a>

            <div class="flex items-center gap-2 sm:gap-4">
                
                <nav class="flex items-center gap-1 sm:gap-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-red-600' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('korban.index')" :active="request()->routeIs('korban.*')">
                        <svg class="w-4 h-4 {{ request()->routeIs('korban.*') ? 'text-red-600' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        {{ __('Korban') }}
                    </x-nav-link>

                    <x-nav-link :href="route('logistik.index')" :active="request()->routeIs('logistik.*')">
                        <svg class="w-4 h-4 {{ request()->routeIs('logistik.*') ? 'text-red-600' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        {{ __('Logistik') }}
                    </x-nav-link>
                </nav>

                <div class="h-6 w-px bg-neutral-200 my-auto hidden sm:block"></div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            @click.away="open = false" 
                            type="button" 
                            class="flex items-center gap-2 p-1.5 rounded-md hover:bg-neutral-100 transition-colors focus:outline-none">
                        <div class="w-7 h-7 rounded-full bg-red-100 text-red-700 font-bold text-xs flex items-center justify-center border border-red-200">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="text-xs font-semibold text-neutral-800 hidden md:inline-block">
                            {{ Auth::user()->name ?? 'Petugas' }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-neutral-500 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition.opacity.duration.150ms
                         x-cloak
                         class="absolute right-0 mt-2 w-48 bg-white border border-neutral-200 rounded-md shadow-lg py-1 z-50">
                        
                        <div class="px-4 py-2 border-b border-neutral-100">
                            <p class="text-xs font-bold text-neutral-900 truncate">{{ Auth::user()->name ?? 'Petugas' }}</p>
                            <p class="text-[11px] text-neutral-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-neutral-700 hover:bg-neutral-50 transition-colors">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Pengaturan Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors text-left border-t border-neutral-100">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>