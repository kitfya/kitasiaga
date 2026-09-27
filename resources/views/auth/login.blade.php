<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-neutral-900">Masuk Relawan</h1>
        <p class="text-xs text-neutral-500 mt-1">Akses dashboard koordinasi posko dan penanganan darurat.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-neutral-700 mb-1">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="relawan@kitasiaga.id"
                class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-neutral-700 mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••"
                class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs">
            <label for="remember_me" class="inline-flex items-center text-neutral-600 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-neutral-300 text-red-600 shadow-sm focus:ring-red-600" name="remember">
                <span class="ms-2">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-red-600 hover:underline font-medium" href="{{ route('password.request') }}">
                    Lupa Kata Sandi?
                </a>
            @endif
        </div>

        <!-- Action Button -->
        <div class="pt-2">
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-md text-sm transition-colors shadow-xs flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Masuk
            </button>
        </div>

        <!-- Switch to Register -->
        <p class="text-center text-xs text-neutral-500 pt-3 border-t border-neutral-100">
            Belum terdaftar sebagai relawan? 
            <a href="{{ route('register') }}" class="text-emerald-700 font-semibold hover:underline">Daftar Akun Baru</a>
        </p>
    </form>
</x-guest-layout>