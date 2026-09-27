<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-neutral-900">Registrasi Relawan Baru</h1>
        <p class="text-xs text-neutral-500 mt-1">Bergabung dengan jaringan tanggap darurat dan posko KitaSiaga.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-semibold text-neutral-700 mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Contoh: Ahmad Hidayat"
                class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 outline-none transition">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-neutral-700 mb-1">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="nama@email.com"
                class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 outline-none transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-neutral-700 mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 outline-none transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-neutral-700 mb-1">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi kata sandi"
                class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 outline-none transition">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-md text-sm transition-colors shadow-xs flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Daftar Sebagai Relawan
            </button>
        </div>

        <!-- Switch to Login -->
        <p class="text-center text-xs text-neutral-500 pt-3 border-t border-neutral-100">
            Sudah memiliki akun relawan? 
            <a href="{{ route('login') }}" class="text-red-600 font-semibold hover:underline">Masuk Sekarang</a>
        </p>
    </form>
</x-guest-layout>