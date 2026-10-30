<x-app-layout>
    <div x-data="logisticsManagement()" x-cloak class="space-y-8">

        <div class="flex flex-col gap-5 border-b border-neutral-200 pb-6 sm:flex-row sm:items-end sm:justify-between no-print">
            <div class="max-w-2xl">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.16em] text-red-700">Operasional posko</p>
                <h1 class="text-2xl font-bold tracking-tight text-neutral-950 sm:text-3xl">Manajemen Logistik & Bantuan</h1>
                <p class="mt-2 text-sm leading-relaxed text-neutral-600">
                    Inventarisasi stok bantuan masuk, distribusi logistik per posko, dan pemantauan ketersediaan obat, makanan, serta pakaian.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                <button type="button" @click="exportCsv()" class="inline-flex items-center gap-2 rounded-lg border border-neutral-300 bg-white px-3.5 py-2.5 text-sm font-semibold text-neutral-700 shadow-sm transition-colors hover:bg-neutral-50">
                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Ekspor CSV
                </button>
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg border border-neutral-300 bg-white px-3.5 py-2.5 text-sm font-semibold text-neutral-700 shadow-sm transition-colors hover:bg-neutral-50">
                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
                <button type="button" @click="openCreateModal()" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Stok Logistik
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-5 xl:gap-4 no-print">
            <div class="rounded-2xl border border-neutral-200 border-l-4 border-l-neutral-400 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:p-5">
                <span class="block text-xs font-semibold text-neutral-500">Total item terdaftar</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-neutral-900">{{ number_format($summary['total_item']) }} <span class="text-sm font-semibold">jenis</span></span>
            </div>
            <div class="rounded-2xl border border-neutral-200 border-l-4 border-l-emerald-500 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:p-5">
                <span class="block text-xs font-semibold text-emerald-700">Stok makanan</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-emerald-700">{{ number_format($summary['makanan']) }}</span>
            </div>
            <div class="rounded-2xl border border-neutral-200 border-l-4 border-l-blue-500 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:p-5">
                <span class="block text-xs font-semibold text-blue-700">Stok obat-obatan</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-blue-700">{{ number_format($summary['obat']) }}</span>
            </div>
            <div class="rounded-2xl border border-neutral-200 border-l-4 border-l-purple-500 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:p-5">
                <span class="block text-xs font-semibold text-purple-700">Stok pakaian</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-purple-700">{{ number_format($summary['pakaian']) }}</span>
            </div>
            <div class="col-span-2 rounded-2xl border border-neutral-200 border-l-4 border-l-red-500 bg-white p-4 shadow-sm transition-shadow hover:shadow-md sm:col-span-1 sm:p-5">
                <span class="block text-xs font-semibold text-red-700">Stok menipis (&le; 50)</span>
                <span class="mt-2 block text-2xl font-bold tracking-tight text-red-700">{{ $summary['menipis'] }} <span class="text-sm font-semibold">item</span></span>
            </div>
        </div>

        <form method="GET" action="{{ route('logistik.index') }}" class="space-y-4 rounded-2xl border border-neutral-200 bg-white p-5 shadow-sm no-print sm:p-6">
            <div class="border-b border-neutral-100 pb-4">
                <h2 class="text-sm font-bold text-neutral-900">Cari & filter inventaris</h2>
                <p class="mt-1 text-xs text-neutral-500">Temukan bantuan berdasarkan nama, posko, atau kategori stok.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <label for="search" class="mb-1.5 block text-xs font-semibold text-neutral-700">Cari barang logistik</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ketik nama bantuan/logistik..." class="w-full rounded-lg border border-neutral-300 py-2.5 pl-10 pr-3 text-sm placeholder:text-neutral-400 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                        <svg class="absolute left-3 top-3 h-4 w-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div>
                    <label for="posko_id" class="mb-1.5 block text-xs font-semibold text-neutral-700">Posko penampungan</label>
                    <select name="posko_id" id="posko_id" onchange="this.form.submit()" class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                        <option value="all">Semua Posko</option>
                        @foreach($poskoList as $p)
                            <option value="{{ $p->id }}" {{ request('posko_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tipe" class="mb-1.5 block text-xs font-semibold text-neutral-700">Kategori tipe</label>
                    <div class="flex items-center gap-1.5">
                        <select name="tipe" id="tipe" onchange="this.form.submit()" class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                            <option value="all">Semua Tipe</option>
                            <option value="makanan" {{ request('tipe') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="obat" {{ request('tipe') == 'obat' ? 'selected' : '' }}>Obat-obatan</option>
                            <option value="pakaian" {{ request('tipe') == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                            <option value="lainnya" {{ request('tipe') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <a href="{{ route('logistik.index') }}" title="Reset Filter" class="inline-flex items-center justify-center rounded-lg border border-neutral-300 p-2.5 text-neutral-600 transition-colors hover:bg-neutral-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <section class="overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm print-area">
            <div class="flex items-center justify-between gap-3 border-b border-neutral-200 bg-neutral-50/70 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="text-sm font-bold text-neutral-900 sm:text-base">Daftar inventaris logistik</h2>
                    <p class="mt-1 text-xs text-neutral-500">Pemantauan stok bantuan di seluruh posko</p>
                </div>
                <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                        {{ $logistics->count() }} Jenis Bantuan
                    </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-neutral-200 bg-neutral-50 text-[11px] font-bold uppercase tracking-wider text-neutral-500">
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Nama Barang / Bantuan</th>
                            <th class="px-4 py-3">Tipe Kategori</th>
                            <th class="px-4 py-3">Jumlah Stok</th>
                            <th class="px-4 py-3">Lokasi Posko</th>
                            <th class="px-4 py-3 text-right no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 text-xs">
                        @if(count($logistics) > 0)
                            @foreach($logistics as $item)
                                <tr class="border-b border-neutral-100 transition-colors hover:bg-neutral-50/80">
                                    <td class="whitespace-nowrap px-4 py-4 text-xs font-mono font-semibold text-neutral-900">
                                        #LOG-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-xs font-bold text-neutral-900">{{ $item->name }}</div>
                                        <div class="text-[11px] text-neutral-400">
                                            Diperbarui: {{ $item->updated_at ? $item->updated_at->format('d M Y, H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] border font-medium uppercase tracking-wider
                                            {{ $item->tipe === 'makanan' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}                                             {{$item->tipe === 'obat' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                            {{ $item->tipe === 'pakaian' ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}                                             {{$item->tipe === 'lainnya' ? 'bg-neutral-100 text-neutral-700 border-neutral-200' : '' }}">
                                            {{ $item->tipe }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-xs font-bold font-mono {{ $item->jumlah <= 50 ? 'text-red-600' : 'text-neutral-900' }}">
                                            {{ number_format($item->jumlah) }}
                                        </span>
                                        @if($item->jumlah <= 50)
                                            <span class="ml-1.5 text-[10px] text-red-600 bg-red-50 border border-red-200 px-1.5 py-0.2 rounded font-medium">Stok Menipis</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs text-neutral-700">
                                        {{ $item->posko?->name ?? 'Posko ID: ' . $item->posko_id }}
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap no-print">
                                        <div class="inline-flex items-center gap-1.5">
                                            <button type="button" @click="openEditModal({
                                                id: '{{ $item->id }}',
                                                name: '{{ e($item->name) }}',
                                                tipe: '{{ $item->tipe }}',
                                                jumlah: '{{ $item->jumlah }}',
                                                posko_id: '{{ $item->posko_id }}'
                                            })" class="rounded-lg px-3 py-2 text-xs font-semibold text-neutral-700 transition-colors hover:bg-neutral-100 hover:text-neutral-900">
                                                Edit
                                            </button>
                                            <button type="button" @click="openDeleteModal('{{ $item->id }}', '{{ e($item->name) }}')" class="rounded-lg px-3 py-2 text-xs font-semibold text-red-600 transition-colors hover:bg-red-50 hover:text-red-700">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-xs text-neutral-500">
                                    Tidak ada data logistik/bantuan yang ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

        <div x-show="isFormModalOpen" 
             x-transition.opacity.duration.200ms
             @keydown.escape.window="isFormModalOpen = false"
             class="fixed inset-0 z-50 bg-neutral-900/60 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
            
            <div @click.away="isFormModalOpen = false" class="my-8 w-full max-w-lg overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-neutral-200 bg-neutral-50 px-6 py-5">
                    <div class="flex items-center gap-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-red-600 text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-neutral-900" x-text="isEdit ? 'Edit Stok Logistik' : 'Tambah Stok Logistik'"></h2>
                            <p class="text-[11px] text-neutral-500">Kelola kuantitas dan jenis bantuan logistik bencana</p>
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

                    <div>
                        <label class="block text-xs font-medium text-neutral-700 mb-1">Posko Tujuan / Penampungan <span class="text-red-600">*</span></label>
                        <select name="posko_id" x-model="formData.posko_id" required class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                            <option value="">-- Pilih Posko --</option>
                            @foreach($poskoList as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-neutral-700 mb-1">Nama Barang Logistik <span class="text-red-600">*</span></label>
                        <input type="text" name="name" x-model="formData.name" required placeholder="Contoh: Beras Super 10kg, Paracetamol, Selimut" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Tipe Kategori <span class="text-red-600">*</span></label>
                            <select name="tipe" x-model="formData.tipe" required class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                                <option value="makanan">Makanan</option>
                                <option value="obat">Obat-obatan</option>
                                <option value="pakaian">Pakaian</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-700 mb-1">Jumlah Stok <span class="text-red-600">*</span></label>
                            <input type="number" name="jumlah" x-model="formData.jumlah" required min="0" placeholder="100" class="w-full border border-neutral-300 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-600">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 border-t border-neutral-200 pt-4">
                        <button type="button" @click="isFormModalOpen = false" class="rounded-lg border border-neutral-300 px-4 py-2.5 text-sm font-semibold text-neutral-700 transition-colors hover:bg-neutral-50">
                            Batal
                        </button>
                        <button type="submit" class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-700">
                            Simpan Data Logistik
                        </button>
                    </div>
                </form>
            </div>
        </div>

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
                        <h3 class="text-sm font-bold text-neutral-900">Konfirmasi Hapus Logistik</h3>
                        <p class="text-xs text-neutral-500 mt-0.5">Tindakan ini akan menghapus data stok dari inventaris.</p>
                    </div>
                </div>

                <div class="bg-neutral-50 p-3 rounded-md border border-neutral-200 text-xs">
                    <span class="text-neutral-500">Nama Barang:</span>
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
            Alpine.data('logisticsManagement', () => ({
                isFormModalOpen: false,
                isDeleteModalOpen: false,
                isEdit: false,
                formAction: '{{ route("logistik.store") }}',
                deleteAction: '',
                deleteTargetName: '',

                formData: {
                    posko_id: '{{ $poskoRelawan?->id ?? "" }}',
                    name: '',
                    tipe: 'makanan',
                    jumlah: ''
                },

                openCreateModal() {
                    this.isEdit = false;
                    this.formAction = '{{ route("logistik.store") }}';
                    this.formData = {
                        posko_id: '{{ $poskoRelawan?->id ?? "" }}',
                        name: '',
                        tipe: 'makanan',
                        jumlah: ''
                    };
                    this.isFormModalOpen = true;
                },

                openEditModal(data) {
                    this.isEdit = true;
                    this.formAction = `/logistik/${data.id}`;
                    this.formData = {
                        posko_id: data.posko_id,
                        name: data.name,
                        tipe: data.tipe,
                        jumlah: data.jumlah
                    };
                    this.isFormModalOpen = true;
                },

                openDeleteModal(id, name) {
                    this.deleteAction = `/logistik/${id}`;
                    this.deleteTargetName = name;
                    this.isDeleteModalOpen = true;
                },

                exportCsv() {
                    let csv = 'ID,Nama Barang,Tipe,Jumlah Stok,Posko ID\n';
                    const rows = document.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        const cols = row.querySelectorAll('td');
                        if (cols.length > 1) {
                            const id = cols[0].innerText.trim();
                            const name = cols[1].querySelector('div').innerText.trim();
                            const tipe = cols[2].innerText.trim();
                            const jumlah = cols[3].innerText.replace('Stok Menipis', '').trim();
                            const posko = cols[4].innerText.trim();

                            csv += `"${id}","${name}","${tipe}","${jumlah}","${posko}"\n`;
                        }
                    });

                    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.setAttribute('href', url);
                    link.setAttribute('download', `inventaris_logistik_{{ date('Y-m-d') }}.csv`);
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