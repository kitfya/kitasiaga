<x-guest-layout>
    <div class="mb-4">
        <h1 class="text-xl font-bold text-neutral-900">Lupa Kata Sandi?</h1>
        <p class="text-xs text-neutral-500 mt-1 leading-relaxed">
            Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-neutral-700 mb-1">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                placeholder="nama@email.com"
                class="w-full border border-neutral-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-red-600 focus:border-red-600 outline-none transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-md text-sm transition-colors shadow-xs">
                Kirim Tautan Reset Password
            </button>
        </div>

        <p class="text-center text-xs text-neutral-500 pt-2">
            Kembai ke <a href="{{ route('login') }}" class="text-red-600 font-semibold hover:underline">Halaman Masuk</a>
        </p>
    </form>
</x-guest-layout>