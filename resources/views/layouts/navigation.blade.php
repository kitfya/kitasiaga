<!-- Load Alpine.js & Tailwind via CDN jika belum di-load di layout utama -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<header class="bg-white border-b border-neutral-200 sticky top-0 z-30 shadow-xs" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-2">
            
            <!-- Logo & Branding -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 sm:gap-3 hover:opacity-90 transition-opacity shrink-0">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-md bg-red-600 flex items-center justify-center text-white shadow-xs shrink-0">
                    <img src="{{ asset('images/logo.webp') }}" alt="logo" class="w-full h-full object-cover rounded-md"/>
                </div>
                <div>
                    <span class="text-sm sm:text-base font-bold tracking-tight text-neutral-900 block leading-tight">KitaSiaga</span>
                    <span class="text-[10px] sm:text-[11px] font-medium text-neutral-500 block uppercase tracking-wider">Dashboard Relawan</span>
                </div>
            </a>

            <!-- Desktop Navigation & Profile -->
            <div class="flex items-center gap-2 sm:gap-4">
                
                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-1 sm:gap-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('dashboard') ? 'text-red-600' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('korban.index')" :active="request()->routeIs('korban.*')">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('korban.*') ? 'text-red-600' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        {{ __('Korban') }}
                    </x-nav-link>

                    <x-nav-link :href="route('logistik.index')" :active="request()->routeIs('logistik.*')">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('logistik.*') ? 'text-red-600' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        {{ __('Logistik') }}
                    </x-nav-link>
                </nav>

                <div class="h-6 w-px bg-neutral-200 my-auto hidden md:block"></div>

                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            @click.away="open = false" 
                            type="button" 
                            class="flex items-center gap-1.5 sm:gap-2 p-1.5 rounded-md hover:bg-neutral-100 transition-colors focus:outline-none">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-red-100 text-red-700 font-bold text-xs flex items-center justify-center border border-red-200 shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="text-xs font-semibold text-neutral-800 hidden lg:inline-block truncate max-w-[120px]">
                            {{ Auth::user()->name ?? 'Petugas' }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-neutral-500 transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         style="display: none;"
                         class="absolute right-0 mt-2 w-52 bg-white border border-neutral-200 rounded-md shadow-lg py-1 z-50">
                        
                        <div class="px-4 py-2 border-b border-neutral-100">
                            <p class="text-xs font-bold text-neutral-900 truncate">{{ Auth::user()->name ?? 'Petugas' }}</p>
                            <p class="text-[11px] text-neutral-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-neutral-700 hover:bg-neutral-50 transition-colors">
                            <svg class="w-4 h-4 text-neutral-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Pengaturan Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors text-left border-t border-neutral-100">
                                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Hamburger Button (Mobile Only) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="md:hidden p-2 rounded-md text-neutral-600 hover:bg-neutral-100 focus:outline-none" 
                        aria-label="Toggle Navigation">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         style="display: none;" 
         class="md:hidden border-t border-neutral-200 bg-white px-4 pt-2 pb-3 space-y-1 shadow-md">
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-2.5 px-3 py-2 rounded-md text-xs font-semibold {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-700' : 'text-neutral-700 hover:bg-neutral-50' }}">
            <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('dashboard') ? 'text-red-600' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            {{ __('Dashboard') }}
        </a>

        <a href="{{ route('korban.index') }}" 
           class="flex items-center gap-2.5 px-3 py-2 rounded-md text-xs font-semibold {{ request()->routeIs('korban.*') ? 'bg-red-50 text-red-700' : 'text-neutral-700 hover:bg-neutral-50' }}">
            <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('korban.*') ? 'text-red-600' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            {{ __('Korban') }}
        </a>

        <a href="{{ route('logistik.index') }}" 
           class="flex items-center gap-2.5 px-3 py-2 rounded-md text-xs font-semibold {{ request()->routeIs('logistik.*') ? 'bg-red-50 text-red-700' : 'text-neutral-700 hover:bg-neutral-50' }}">
            <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('logistik.*') ? 'text-red-600' : 'text-neutral-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            {{ __('Logistik') }}
        </a>
    </div>
</header>
