<section class="space-y-4">
    <header>
        <h2 class="text-sm font-bold text-neutral-900 uppercase tracking-wider">
            Informasi Profil & Relawan
        </h2>
        <p class="text-xs text-neutral-500 mt-0.5">
            Perbarui data diri, kontak, dan penugasan posko relawan Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4 space-y-4">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-semibold text-neutral-700 mb-1">Nama Lengkap <span class="text-red-600">*</span></label>
                <input id="name" name="name" type="text" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                <x-input-error class="mt-1" :messages="$errors->get('name')" />
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label for="phone" class="block text-xs font-semibold text-neutral-700 mb-1">Nomor Telepon / WhatsApp</label>
                <input id="phone" name="phone" type="tel" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600" value="{{ old('phone', $user->phone) }}" placeholder="081234567890" autocomplete="tel" />
                <x-input-error class="mt-1" :messages="$errors->get('phone')" />
            </div>
        </div>

        <!-- Alamat Email -->
        <div>
            <label for="email" class="block text-xs font-semibold text-neutral-700 mb-1">Alamat Email <span class="text-red-600">*</span></label>
            <input id="email" name="email" type="email" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-amber-50 border border-amber-200 rounded-md">
                    <p class="text-xs text-amber-800">
                        Alamat email Anda belum terverifikasi.
                        <button form="send-verification" class="underline text-xs font-semibold text-amber-900 hover:text-red-700">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1.5 font-medium text-xs text-emerald-700">
                            Tautan verifikasi baru telah dikirimkan ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Detail Keanggotaan Relawan -->
        <div class="pt-4 border-t border-neutral-200 space-y-4">
            <h3 class="text-xs font-bold text-neutral-800 uppercase tracking-wider">Atribut Tugas Relawan</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Bidang Keahlian -->
                <div>
                    <label for="bidang" class="block text-xs font-semibold text-neutral-700 mb-1">Bidang Keahlian / Peran</label>
                    <input id="bidang" name="bidang" type="text" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600" value="{{ old('bidang', $user->relawan?->bidang) }}" placeholder="Contoh: Medis / Logistik / Evakuasi" />
                    <x-input-error class="mt-1" :messages="$errors->get('bidang')" />
                </div>

                <!-- Instansi / Organisasi -->
                <div>
                    <label for="instansi" class="block text-xs font-semibold text-neutral-700 mb-1">Instansi / Organisasi</label>
                    <input id="instansi" name="instansi" type="text" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600" value="{{ old('instansi', $user->relawan?->instansi) }}" placeholder="Contoh: PMI / Basarnas / Mandiri" />
                    <x-input-error class="mt-1" :messages="$errors->get('instansi')" />
                </div>
            </div>

            <!-- Penugasan Posko -->
            <div>
                <label for="posko_id" class="block text-xs font-semibold text-neutral-700 mb-1">Posko Penugasan</label>
                <select id="posko_id" name="posko_id" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                    <option value="">-- Pilih Posko Penugasan (Opsional) --</option>
                    @foreach($poskos as $posko)
                        <option value="{{ $posko->id }}" {{ old('posko_id', $user->relawan?->posko_id) == $posko->id ? 'selected' : '' }}>
                            {{ $posko->name }} - {{ $posko->alamat ?? 'Lokasi Kedaruratan' }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-1" :messages="$errors->get('posko_id')" />
            </div>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="bg-red-600 text-white hover:bg-red-700 rounded-md px-4 py-2 text-xs font-semibold transition-colors shadow-xs">
                Simpan Perubahan Profil
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>