<section class="space-y-4">
    <header>
        <h2 class="text-sm font-bold text-red-600 uppercase tracking-wider">
            Hapus Akun
        </h2>
        <p class="text-xs text-neutral-500 mt-0.5">
            Setelah akun Anda dihapus, semua sumber daya dan data terkait akan dihapus secara permanen.
        </p>
    </header>

    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-red-600 text-white hover:bg-red-700 rounded-md px-4 py-2 text-xs font-semibold transition-colors shadow-xs">
        Hapus Akun Ini
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-4">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-neutral-900">Apakah Anda yakin ingin menghapus akun?</h3>
                    <p class="text-xs text-neutral-500 mt-0.5">Masukkan kata sandi Anda untuk mengonfirmasi penghapusan permanen.</p>
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs font-medium text-neutral-700 mb-1">Kata Sandi</label>
                <input id="password" name="password" type="password" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="Masukkan kata sandi Anda..." />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" x-on:click="$dispatch('close')" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-3.5 py-2 text-xs font-medium transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-red-600 text-white hover:bg-red-700 rounded-md px-3.5 py-2 text-xs font-semibold transition-colors shadow-xs">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>