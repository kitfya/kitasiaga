<x-guest-layout>
    <div class="mb-4">
        <h1 class="text-xl font-bold text-neutral-900">Verifikasi Email Anda</h1>
        <p class="text-xs text-neutral-600 mt-2 leading-relaxed">
            Terima kasih telah mendaftar! Sebelum melangkah lebih jauh, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-md text-xs font-medium">
            Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda daftarkan.
        </div>
    @endif

    <div class="mt-6 flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-md text-xs transition-colors shadow-xs">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-xs text-neutral-500 hover:text-neutral-800 underline">
                Keluar (Log Out)
            </button>
        </form>
    </div>
</x-guest-layout>