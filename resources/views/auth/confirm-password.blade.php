<x-guest-layout>
    <div class="mb-4">
        <h1 class="text-xl font-bold text-neutral-900">Konfirmasi Kata Sandi</h1>
        <p class="text-xs text-neutral-600 mt-1 leading-relaxed">
            Ini adalah area terproteksi. Mohon konfirmasi kata sandi Anda sebelum melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <label for="password" class="block text-xs font-semibold text-neutral-700 mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-md text-sm transition-colors shadow-xs">
                Konfirmasi
            </button>
        </div>
    </form>
</x-guest-layout>