<x-app-layout>
    <div x-data="victimManagement()" x-cloak class="space-y-8">

        <div class="flex flex-col gap-5 border-b border-neutral-200 pb-6 sm:flex-row sm:items-end sm:justify-between no-print">
            <div class="max-w-2xl">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.16em] text-red-700">Operasional posko</p>
                <h1 class="text-2xl font-bold tracking-tight text-neutral-950 sm:text-3xl">Manajemen Korban & Pengungsi</h1>
                <p class="mt-2 text-sm leading-relaxed text-neutral-600">
                    Pencatatan data manifest pengungsi posko, pemilahan kondisi kesehatan, identifikasi kelompok rentan, dan inventarisir kebutuhan darurat.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                <button type="button" @click="exportCsv()" class="inline-flex items-center gap-2 rounded-lg border border-neutral-300 bg-white px-3.5 py-2.5 text-sm font-semibold text-neutral-700 shadow-sm transition-colors hover:bg-neutral-50">
                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Ekspor CSV
                </button>
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg border border-neutral-300 bg-white px-3.5 py-2.5 text-sm font-semibold text-neutral-700 shadow-sm transition-colors hover:bg-neutral-50">
                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Manifest
                </button>
                <button type="button" @click="openCreateModal()" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data Korban
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-5 xl:gap-4 no-print">
            <div class="rounded-2xl border border-neutral-200 border-l-4 border-l-neutral-400 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:p-5">
                <span class="block text-xs font-semibold text-neutral-500">Total pengungsi</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-neutral-900">{{ $summary['total'] }}</span>
            </div>
            <div class="rounded-2xl border border-neutral-200 border-l-4 border-l-red-500 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:p-5">
                <span class="block text-xs font-semibold text-red-700">Kondisi kritis</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-red-700">{{ $summary['kritis'] }}</span>
            </div>
            <div class="rounded-2xl border border-neutral-200 border-l-4 border-l-amber-500 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:p-5">
                <span class="block text-xs font-semibold text-amber-700">Luka-luka</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-amber-700">{{ $summary['luka'] }}</span>
            </div>
            <div class="rounded-2xl border border-neutral-200 border-l-4 border-l-emerald-500 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:p-5">
                <span class="block text-xs font-semibold text-emerald-700">Kondisi sehat</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-emerald-700">{{ $summary['sehat'] }}</span>
            </div>
            <div class="col-span-2 rounded-2xl border border-neutral-200 border-l-4 border-l-purple-500 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:col-span-1 sm:p-5">
                <span class="block text-xs font-semibold text-purple-700">Kelompok rentan</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-purple-700">{{ $summary['rentan'] }} <span class="text-sm font-semibold">jiwa</span></span>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('korban.index') }}" class="space-y-4 rounded-2xl border border-neutral-200 bg-white p-5 shadow-sm no-print sm:p-6">
            <div class="flex flex-col gap-1 border-b border-neutral-100 pb-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-sm font-bold text-neutral-900">Cari & filter data</h2>
                    <p class="mt-1 text-xs text-neutral-500">Persempit manifest berdasarkan posko, kondisi, atau kategori.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <label for="search" class="mb-1.5 block text-xs font-semibold text-neutral-700">Cari korban</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ketik nama, NIK, ID, atau kebutuhan..." class="w-full rounded-lg border border-neutral-300 py-2.5 pl-10 pr-3 text-sm placeholder:text-neutral-400 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                        <svg class="absolute left-3 top-3 h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div>
                    <label for="posko_id" class="mb-1.5 block text-xs font-semibold text-neutral-700">Posko evakuasi</label>
                    <select name="posko_id" id="posko_id" onchange="this.form.submit()" class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                        <option value="all">Semua Posko</option>
                        @foreach($poskoList as $p)
                            <option value="{{ $p->id }}" {{ request('posko_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="kondisi" class="mb-1.5 block text-xs font-semibold text-neutral-700">Kondisi kesehatan</label>
                    <select name="kondisi" id="kondisi" onchange="this.form.submit()" class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                        <option value="all">Semua Kondisi</option>
                        <option value="Sehat" {{ request('kondisi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="Luka-luka" {{ request('kondisi') == 'Luka-luka' ? 'selected' : '' }}>Luka-luka</option>
                        <option value="Kritis" {{ request('kondisi') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                    </select>
                </div>

                <div>
                    <label for="kelompok_rentan" class="mb-1.5 block text-xs font-semibold text-neutral-700">Kelompok rentan</label>
                    <div class="flex items-center gap-1.5">
                        <select name="kelompok_rentan" id="kelompok_rentan" onchange="this.form.submit()" class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                            <option value="all">Semua Kategori</option>
                            <option value="bayi" {{ request('kelompok_rentan') == 'bayi' ? 'selected' : '' }}>Bayi / Balita</option>
                            <option value="lansia" {{ request('kelompok_rentan') == 'lansia' ? 'selected' : '' }}>Lansia</option>
                            <option value="hamil" {{ request('kelompok_rentan') == 'hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                            <option value="disabilitas" {{ request('kelompok_rentan') == 'disabilitas' ? 'selected' : '' }}>Disabilitas</option>
                            <option value="None" {{ request('kelompok_rentan') == 'None' ? 'selected' : '' }}>Umum</option>
                        </select>
                        <a href="{{ route('korban.index') }}" title="Reset Filter" class="inline-flex items-center justify-center rounded-lg border border-neutral-300 p-2.5 text-neutral-600 transition-colors hover:bg-neutral-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table Manifest -->
        <section class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm print-area">
            <div class="flex items-center justify-between gap-3 border-b border-neutral-200 bg-neutral-50/70 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="text-sm font-bold text-neutral-900 sm:text-base">Manifest pengungsi posko</h2>
                    <p class="mt-1 text-xs text-neutral-500">Data korban dan kebutuhan penanganan</p>
                </div>
                <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                        {{ $victims->count() }} Korban Terdata
                    </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-neutral-200 bg-neutral-50 text-[11px] font-bold uppercase tracking-wider text-neutral-500">
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Nama & NIK</th>
                            <th class="px-4 py-3">Usia</th>
                            <th class="px-4 py-3">Kelompok Rentan</th>
                            <th class="px-4 py-3">Kondisi</th>
                            <th class="px-4 py-3">Kebutuhan Saat Ini</th>
                            <th class="px-4 py-3 text-right no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 text-xs">
                        @if(count($victims) > 0)
                            @foreach($victims as $v)
                                <tr class="border-b border-neutral-100 transition-colors hover:bg-neutral-50/80">
                                    <td class="whitespace-nowrap px-4 py-4 text-xs font-mono font-semibold text-neutral-900">
                                        #KOR-{{ str_pad($v->id, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-xs font-semibold text-neutral-900">{{ $v->name }}</div>
                                        <div class="text-[11px] text-neutral-500 font-mono">
                                            NIK: {{ $v->nik ? $v->nik : 'Tidak ada' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-neutral-700 whitespace-nowrap">
                                        <span class="font-medium">{{ $v->usia }} Th</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] border 
                                            {{ $v->kelompok_rentan === 'bayi' ? 'text-purple-700 bg-purple-50 border-purple-200 font-medium' : '' }}
                                            {{ $v->kelompok_rentan === 'lansia' ? 'text-blue-700 bg-blue-50 border-blue-200 font-medium' : '' }}
                                            {{ $v->kelompok_rentan === 'hamil' ? 'text-pink-700 bg-pink-50 border-pink-200 font-medium' : '' }}
                                            {{ $v->kelompok_rentan === 'disabilitas' ? 'text-orange-700 bg-orange-50 border-orange-200 font-medium' : '' }}
                                            {{ in_array($v->kelompok_rentan, ['', 'Umum']) ? 'text-neutral-500 bg-neutral-100 border-neutral-200' : '' }}">
                                            {{ in_array($v->kelompok_rentan, ['None', 'Umum']) ? 'Umum' :$v->kelompok_rentan }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] border 
                                            {{ $v->kondisi === 'sehat' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                            {{ $v->kondisi === 'luka' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                            {{$v->kondisi === 'kritis' ? 'bg-red-50 text-red-700 border-red-200 font-semibold' : '' }}">
                                            {{ $v->kondisi }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-xs text-neutral-700 max-w-xs line-clamp-1" title="{{ $v->kebutuhan }}">
                                            {{ $v->kebutuhan ?? '-' }}
                                        </div>
                                        <div class="text-[11px] text-neutral-400 mt-0.5">
                                            Ref: <span class="font-mono">{{ $v->laporan?->id ?? '-' }}</span> • {{ $v->posko?->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap no-print">
                                        <div class="inline-flex items-center gap-1.5">
                                            <button type="button" @click="openEditModal({
                                                id: '{{ $v->id }}',
                                                name: '{{ e($v->name) }}',
                                                usia: '{{ $v->usia }}',
                                                nik: '{{ $v->nik }}',
                                                posko_id: '{{ $v->posko_id }}',
                                                laporan_id: '{{ $v->laporan_id }}',
                                                kondisi: '{{ $v->kondisi }}',
                                                kelompok_rentan: '{{ $v->kelompok_rentan }}',
                                                kebutuhan: '{{ e($v->kebutuhan) }}'
                                            })" class="rounded-lg px-3 py-2 text-xs font-semibold text-neutral-700 transition-colors hover:bg-neutral-100 hover:text-neutral-900">
                                                Edit
                                            </button>
                                            <button type="button" @click="openDeleteModal('{{ $v->id }}', '{{ e($v->name) }}')" class="rounded-lg px-3 py-2 text-xs font-semibold text-red-600 transition-colors hover:bg-red-50 hover:text-red-700">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-xs text-neutral-500">
                                    Tidak ada data korban/pengungsi yang ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Form Modal (Create / Edit) -->
        <div x-show="isFormModalOpen" 
             x-transition.opacity.duration.200ms
             @keydown.escape.window="isFormModalOpen = false"
             class="fixed inset-0 z-50 bg-neutral-900/60 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
            
            <div @click.away="isFormModalOpen = false" class="my-8 w-full max-w-xl overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-neutral-200 bg-neutral-50 px-6 py-5">
                    <div class="flex items-center gap-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-red-600 text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-neutral-900" x-text="isEdit ? 'Edit Data Korban / Pengungsi' : 'Tambah Data Korban / Pengungsi'"></h2>
                            <p class="text-[11px] text-neutral-500">Lengkapi data manifest pengungsi untuk penyaluran bantuan tepat sasaran</p>
                        </div>
                    </div>
                    <button type="button" @click="isFormModalOpen = false" class="text-neutral-400 hover:text-neutral-700 p-1.5 rounded-md hover:bg-neutral-200/60 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="formAction" method="POST" class="p-6 space-y-4">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Laporan Bencana Terkait <span class="text-red-600">*</span></label>
                            <select name="laporan_id" x-model="formData.laporan_id" required class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                                <option value="">-- Pilih Laporan --</option>
                                @foreach($laporanList as $lap)
                                    <option value="{{ $lap->id }}">{{ $lap->id }} - {{$lap->tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Posko Penampungan <span class="text-red-600">*</span></label>
                            <select name="posko_id" x-model="formData.posko_id" required class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                                <option value="">-- Pilih Posko --</option>
                                @foreach($poskoList as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                        <div class="sm:col-span-8">
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Nama Lengkap Korban <span class="text-red-600">*</span></label>
                            <!-- PENTING: Diberi name="name" agar cocok dengan Controller & Database -->
                            <input type="text" name="name" x-model="formData.name" required placeholder="Contoh: Siti Rahmah" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600">
                        </div>
                        <div class="sm:col-span-4">
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Usia (Tahun) <span class="text-red-600">*</span></label>
                            <input type="number" name="usia" x-model="formData.usia" required min="0" max="120" placeholder="32" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-neutral-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" name="nik" x-model="formData.nik" maxlength="16" placeholder="16 Digit NIK KTP / Kartu Keluarga" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-red-600">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Kondisi Kesehatan <span class="text-red-600">*</span></label>
                            <select name="kondisi" x-model="formData.kondisi" required class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                                <option value="sehat">Sehat</option>
                                <option value="luka">Luka-luka (Ringan/Sedang)</option>
                                <option value="kritis">Kritis (Perlu Rujukan RS)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Kelompok Rentan <span class="text-red-600">*</span></label>
                            <select name="kelompok_rentan" x-model="formData.kelompok_rentan" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                                <option value="">Tidak Termasuk (Umum)</option>
                                <option value="bayi">Bayi / Balita (&le; 5 Tahun)</option>
                                <option value="lansia">Lansia (&ge; 60 Tahun)</option>
                                <option value="hamil">Ibu Hamil / Menyusui</option>
                                <option value="disabilitas">Penyandang Disabilitas</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-neutral-700 mb-1">Kebutuhan Mendesak Saat Ini</label>
                        <input type="text" name="kebutuhan" x-model="formData.kebutuhan" placeholder="Contoh: Susu Formula, Selimut, Obat Hipertensi..." class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600">
                    </div>

                    <div class="flex items-center justify-end gap-2 border-t border-neutral-200 pt-4">
                        <button type="button" @click="isFormModalOpen = false" class="rounded-lg border border-neutral-300 px-4 py-2.5 text-sm font-semibold text-neutral-700 transition-colors hover:bg-neutral-50">
                            Batal
                        </button>
                        <button type="submit" class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-700">
                            Simpan Data Korban
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="isDeleteModalOpen" 
             x-transition.opacity.duration.200ms
             @keydown.escape.window="isDeleteModalOpen = false"
             class="fixed inset-0 z-50 bg-neutral-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
            
            <div @click.away="isDeleteModalOpen = false" class="w-full max-w-md space-y-4 rounded-2xl border border-neutral-200 bg-white p-6 shadow-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-neutral-900">Konfirmasi Hapus Data Korban</h3>
                        <p class="text-xs text-neutral-500 mt-0.5">Tindakan ini akan menghapus data pengungsi dari database.</p>
                    </div>
                </div>

                <div class="bg-neutral-50 p-3 rounded-md border border-neutral-200 text-xs">
                    <span class="text-neutral-500">Nama Pengungsi:</span>
                    <div class="font-bold text-neutral-900 mt-0.5" x-text="deleteTargetName"></div>
                </div>

                <form :action="deleteAction" method="POST" class="flex items-center justify-end gap-2 pt-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="isDeleteModalOpen = false" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-3.5 py-2 text-xs font-medium transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 text-white hover:bg-red-700 rounded-md px-3.5 py-2 text-xs font-semibold transition-colors shadow-xs">
                        Ya, Hapus Data
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('victimManagement', () => ({
            isFormModalOpen: false,
            isDeleteModalOpen: false,
            isEdit: false,
            formAction: '{{ route("korban.store") }}',
            deleteAction: '',
            deleteTargetName: '',

            formData: {
                laporan_id: '',
                posko_id: '{{ $poskoRelawan?->id ?? "" }}',
                name: '',
                usia: '',
                nik: '',
                kondisi: 'Sehat',
                kelompok_rentan: 'None',
                kebutuhan: ''
            },

            openCreateModal() {
                this.isEdit = false;
                this.formAction = '{{ route("korban.store") }}';
                this.formData = {
                    laporan_id: '',
                    posko_id: '{{ $poskoRelawan?->id ?? "" }}',
                    name: '',
                    usia: '',
                    nik: '',
                    kondisi: 'Sehat',
                    kelompok_rentan: 'None',
                    kebutuhan: ''
                };
                this.isFormModalOpen = true;
            },

            openEditModal(data) {
                this.isEdit = true;
                this.formAction = `/korban/${data.id}`;
                this.formData = {
                    laporan_id: String(data.laporan_id ?? ''),
                    posko_id: String(data.posko_id ?? ''),
                    name: data.name,
                    usia: data.usia,
                    nik: data.nik !== 'null' && data.nik ? data.nik : '',
                    kondisi: data.kondisi,
                    kelompok_rentan: data.kelompok_rentan,
                    kebutuhan: data.kebutuhan !== 'null' && data.kebutuhan ? data.kebutuhan : ''
                };
                this.isFormModalOpen = true;
            },

            openDeleteModal(id, name) {
                this.deleteAction = `/korban/${id}`;
                this.deleteTargetName = name;
                this.isDeleteModalOpen = true;
            },

            exportCsv() {
                let csv = 'ID,Nama,NIK,Usia,Kelompok Rentan,Kondisi,Kebutuhan\n';
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const cols = row.querySelectorAll('td');
                    if (cols.length > 1) {
                        const id = cols[0].innerText.trim();
                        const name = cols[1].querySelector('div').innerText.trim();
                        const nikText = cols[1].querySelector('.font-mono').innerText.replace('NIK:', '').trim();
                        const usia = cols[2].innerText.trim();
                        const rentan = cols[3].innerText.trim();
                        const kondisi = cols[4].innerText.trim();
                        const kebutuhan = cols[5].querySelector('.line-clamp-1').innerText.trim();

                        csv += `"${id}","${name}","${nikText}","${usia}","${rentan}","${kondisi}","${kebutuhan}"\n`;
                    }
                });

                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.setAttribute('href', url);
                link.setAttribute('download', `manifest_pengungsi_{{ date('Y-m-d') }}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }));
    });
    </script>

    <style>
        [x-cloak] { display: none !important; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</x-app-layout>
