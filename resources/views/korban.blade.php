<x-app-layout>
    <div x-data="victimManagement()" x-cloak class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-neutral-200 no-print">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-neutral-900">Manajemen Korban & Pengungsi Bencana</h1>
                <p class="text-sm leading-relaxed text-neutral-600 mt-0.5">
                    Pencatatan data manifest pengungsi posko, pemilahan kondisi kesehatan, identifikasi kelompok rentan, dan inventarisir kebutuhan darurat.
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <button type="button" @click="exportCsv()" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-3.5 py-2 text-xs font-medium transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Ekspor CSV
                </button>
                <button type="button" onclick="window.print()" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-3.5 py-2 text-xs font-medium transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Manifest
                </button>
                <button type="button" @click="openCreateModal()" class="bg-red-600 text-white hover:bg-red-700 rounded-md px-3.5 py-2 text-xs font-medium transition-colors inline-flex items-center gap-1.5 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data Korban
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 no-print">
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs">
                <span class="text-[11px] font-medium text-neutral-500 block">Total Pengungsi</span>
                <span class="text-xl font-bold text-neutral-900 mt-0.5 block">{{ $summary['total'] }}</span>
            </div>
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs">
                <span class="text-[11px] font-medium text-red-600 block">Kondisi Kritis</span>
                <span class="text-xl font-bold text-red-600 mt-0.5 block">{{ $summary['kritis'] }}</span>
            </div>
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs">
                <span class="text-[11px] font-medium text-amber-600 block">Luka-luka</span>
                <span class="text-xl font-bold text-amber-700 mt-0.5 block">{{ $summary['luka'] }}</span>
            </div>
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs">
                <span class="text-[11px] font-medium text-emerald-600 block">Kondisi Sehat</span>
                <span class="text-xl font-bold text-emerald-700 mt-0.5 block">{{ $summary['sehat'] }}</span>
            </div>
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs col-span-2 sm:col-span-1">
                <span class="text-[11px] font-medium text-neutral-500 block">Kelompok Rentan</span>
                <span class="text-xl font-bold text-purple-700 mt-0.5 block">{{ $summary['rentan'] }} Jiwa</span>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('korban.index') }}" class="bg-white border border-neutral-200 rounded-lg p-4 shadow-xs space-y-3 no-print">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <div class="lg:col-span-2">
                    <label for="search" class="block text-[11px] font-medium text-neutral-600 mb-1">Cari Korban:</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ketik nama, NIK, ID, atau kebutuhan..." class="w-full border border-neutral-300 rounded-md pl-8 pr-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 placeholder:text-neutral-400">
                        <svg class="w-4 h-4 text-neutral-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div>
                    <label for="posko_id" class="block text-[11px] font-medium text-neutral-600 mb-1">Posko Evakuasi:</label>
                    <select name="posko_id" id="posko_id" onchange="this.form.submit()" class="w-full border border-neutral-300 rounded-md px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                        <option value="all">Semua Posko</option>
                        @foreach($poskoList as $p)
                            <option value="{{ $p->id }}" {{ request('posko_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="kondisi" class="block text-[11px] font-medium text-neutral-600 mb-1">Kondisi Kesehatan:</label>
                    <select name="kondisi" id="kondisi" onchange="this.form.submit()" class="w-full border border-neutral-300 rounded-md px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                        <option value="all">Semua Kondisi</option>
                        <option value="Sehat" {{ request('kondisi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="Luka-luka" {{ request('kondisi') == 'Luka-luka' ? 'selected' : '' }}>Luka-luka</option>
                        <option value="Kritis" {{ request('kondisi') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                    </select>
                </div>

                <div>
                    <label for="kelompok_rentan" class="block text-[11px] font-medium text-neutral-600 mb-1">Kelompok Rentan:</label>
                    <div class="flex items-center gap-1.5">
                        <select name="kelompok_rentan" id="kelompok_rentan" onchange="this.form.submit()" class="w-full border border-neutral-300 rounded-md px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                            <option value="all">Semua Kategori</option>
                            <option value="Bayi/Balita" {{ request('kelompok_rentan') == 'Bayi/Balita' ? 'selected' : '' }}>Bayi / Balita</option>
                            <option value="Lansia" {{ request('kelompok_rentan') == 'Lansia' ? 'selected' : '' }}>Lansia</option>
                            <option value="Hamil" {{ request('kelompok_rentan') == 'Hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                            <option value="Disabilitas" {{ request('kelompok_rentan') == 'Disabilitas' ? 'selected' : '' }}>Disabilitas</option>
                            <option value="None" {{ request('kelompok_rentan') == 'None' ? 'selected' : '' }}>Umum</option>
                        </select>
                        <a href="{{ route('korban.index') }}" title="Reset Filter" class="p-1.5 border border-neutral-300 text-neutral-600 hover:bg-neutral-100 rounded-md inline-flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table Manifest -->
        <section class="bg-white border border-neutral-200 rounded-lg shadow-xs overflow-hidden print-area">
            <div class="px-5 py-3 border-b border-neutral-200 flex items-center justify-between bg-neutral-50/70">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-neutral-900 uppercase tracking-wider">Manifest Pengungsi Posko</span>
                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-0.5 rounded-full font-medium">
                        {{ $victims->count() }} Korban Terdata
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-100/70 border-b border-neutral-200 text-[11px] font-semibold text-neutral-600 uppercase tracking-wider">
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
                                <tr class="border-b border-neutral-100 hover:bg-neutral-50/70 transition-colors">
                                    <td class="px-4 py-3 text-xs font-mono font-semibold text-neutral-900 whitespace-nowrap">
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
                                            {{ $v->kelompok_rentan === 'Bayi/Balita' ? 'text-purple-700 bg-purple-50 border-purple-200 font-medium' : '' }}
                                            {{ $v->kelompok_rentan === 'Lansia' ? 'text-blue-700 bg-blue-50 border-blue-200 font-medium' : '' }}
                                            {{ $v->kelompok_rentan === 'Hamil' ? 'text-pink-700 bg-pink-50 border-pink-200 font-medium' : '' }}
                                            {{ $v->kelompok_rentan === 'Disabilitas' ? 'text-orange-700 bg-orange-50 border-orange-200 font-medium' : '' }}
                                            {{ in_array($v->kelompok_rentan, ['None', 'Umum']) ? 'text-neutral-500 bg-neutral-100 border-neutral-200' : '' }}">
                                            {{ in_array($v->kelompok_rentan, ['None', 'Umum']) ? 'Umum' :$v->kelompok_rentan }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] border 
                                            {{ $v->kondisi === 'Sehat' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                            {{ $v->kondisi === 'Luka-luka' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                            {{$v->kondisi === 'Kritis' ? 'bg-red-50 text-red-700 border-red-200 font-semibold' : '' }}">
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
                                            })" class="px-2 py-1 text-xs font-medium text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 rounded transition-colors">
                                                Edit
                                            </button>
                                            <button type="button" @click="openDeleteModal('{{ $v->id }}', '{{ e($v->name) }}')" class="px-2 py-1 text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors">
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
            
            <div @click.away="isFormModalOpen = false" class="bg-white border border-neutral-200 rounded-lg shadow-xl w-full max-w-xl my-8 overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-200 flex items-center justify-between bg-neutral-50">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded bg-red-600 text-white flex items-center justify-center">
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
                                @foreach($laporanList as$lap)
                                    <option value="{{ $lap->id }}">{{ $lap->id }} - {{$lap->tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Posko Penampungan <span class="text-red-600">*</span></label>
                            <select name="posko_id" x-model="formData.posko_id" required class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                                <option value="">-- Pilih Posko --</option>
                                @foreach($poskoList as$p)
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
                                <option value="Sehat">Sehat</option>
                                <option value="Luka-luka">Luka-luka (Ringan/Sedang)</option>
                                <option value="Kritis">Kritis (Perlu Rujukan RS)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Kelompok Rentan <span class="text-red-600">*</span></label>
                            <select name="kelompok_rentan" x-model="formData.kelompok_rentan" required class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                                <option value="None">Tidak Termasuk (Umum)</option>
                                <option value="Bayi/Balita">Bayi / Balita (&le; 5 Tahun)</option>
                                <option value="Lansia">Lansia (&ge; 60 Tahun)</option>
                                <option value="Hamil">Ibu Hamil / Menyusui</option>
                                <option value="Disabilitas">Penyandang Disabilitas</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-neutral-700 mb-1">Kebutuhan Mendesak Saat Ini</label>
                        <input type="text" name="kebutuhan" x-model="formData.kebutuhan" placeholder="Contoh: Susu Formula, Selimut, Obat Hipertensi..." class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600">
                    </div>

                    <div class="pt-3 border-t border-neutral-200 flex items-center justify-end gap-2">
                        <button type="button" @click="isFormModalOpen = false" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-4 py-2 text-xs font-medium transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="bg-red-600 text-white hover:bg-red-700 rounded-md px-4 py-2 text-xs font-semibold transition-colors shadow-xs">
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
            
            <div @click.away="isDeleteModalOpen = false" class="bg-white border border-neutral-200 rounded-lg shadow-xl w-full max-w-md p-6 space-y-4">
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