<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <!-- Header Halaman -->
        <div class="pb-2 border-b border-neutral-200">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900">Pengaturan Profil & Keamanan</h1>
            <p class="text-sm leading-relaxed text-neutral-600 mt-0.5">
                Kelola informasi akun petugas, perbarui kata sandi, dan setelan akses akun sistem.
            </p>
        </div>

        <!-- Form Informasi Profil -->
        <div class="p-6 bg-white border border-neutral-200 rounded-lg shadow-xs">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Form Ubah Password -->
        <div class="p-6 bg-white border border-neutral-200 rounded-lg shadow-xs">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Form Hapus Akun -->
        <div class="p-6 bg-white border border-neutral-200 rounded-lg shadow-xs">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-app-layout>