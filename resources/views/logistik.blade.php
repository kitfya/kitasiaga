<x-app-layout>
    <div x-data="logisticsManagement()" x-cloak class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-neutral-200 no-print">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-neutral-900">Manajemen Logistik & Bantuan Posko</h1>
                <p class="text-sm leading-relaxed text-neutral-600 mt-0.5">
                    Inventarisasi stok bantuan masuk, distribusi logistik per posko, dan pemantauan ketersediaan obat, makanan, serta pakaian.
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <button type="button" @click="exportCsv()" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-3.5 py-2 text-xs font-medium transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Ekspor CSV
                </button>
                <button type="button" onclick="window.print()" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-3.5 py-2 text-xs font-medium transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
                <button type="button" @click="openCreateModal()" class="bg-red-600 text-white hover:bg-red-700 rounded-md px-3.5 py-2 text-xs font-medium transition-colors inline-flex items-center gap-1.5 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Stok Logistik
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 no-print">
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs">
                <span class="text-[11px] font-medium text-neutral-500 block">Total Item Terdaftar</span>
                <span class="text-xl font-bold text-neutral-900 mt-0.5 block">{{ number_format($summary['total_item']) }} Jenis</span>
            </div>
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs">
                <span class="text-[11px] font-medium text-emerald-600 block">Stok Makanan</span>
                <span class="text-xl font-bold text-emerald-700 mt-0.5 block">{{ number_format($summary['makanan']) }}</span>
            </div>
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs">
                <span class="text-[11px] font-medium text-blue-600 block">Stok Obat-obatan</span>
                <span class="text-xl font-bold text-blue-700 mt-0.5 block">{{ number_format($summary['obat']) }}</span>
            </div>
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs">
                <span class="text-[11px] font-medium text-purple-600 block">Stok Pakaian</span>
                <span class="text-xl font-bold text-purple-700 mt-0.5 block">{{ number_format($summary['pakaian']) }}</span>
            </div>
            <div class="p-3.5 bg-white border border-neutral-200 rounded-lg shadow-xs col-span-2 sm:col-span-1">
                <span class="text-[11px] font-medium text-red-600 block">Stok Menipis (&le; 50)</span>
                <span class="text-xl font-bold text-red-600 mt-0.5 block">{{ $summary['menipis'] }} Item</span>
            </div>
        </div>

        <form method="GET" action="{{ route('logistik.index') }}" class="bg-white border border-neutral-200 rounded-lg p-4 shadow-xs space-y-3 no-print">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="lg:col-span-2">
                    <label for="search" class="block text-[11px] font-medium text-neutral-600 mb-1">Cari Barang Logistik:</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ketik nama bantuan/logistik..." class="w-full border border-neutral-300 rounded-md pl-8 pr-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 placeholder:text-neutral-400">
                        <svg class="w-4 h-4 text-neutral-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div>
                    <label for="posko_id" class="block text-[11px] font-medium text-neutral-600 mb-1">Posko Penampungan:</label>
                    <select name="posko_id" id="posko_id" onchange="this.form.submit()" class="w-full border border-neutral-300 rounded-md px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                        <option value="all">Semua Posko</option>
                        @foreach($poskoList as $p)
                            <option value="{{ $p->id }}" {{ request('posko_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tipe" class="block text-[11px] font-medium text-neutral-600 mb-1">Kategori Tipe:</label>
                    <div class="flex items-center gap-1.5">
                        <select name="tipe" id="tipe" onchange="this.form.submit()" class="w-full border border-neutral-300 rounded-md px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 bg-white">
                            <option value="all">Semua Tipe</option>
                            <option value="makanan" {{ request('tipe') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="obat" {{ request('tipe') == 'obat' ? 'selected' : '' }}>Obat-obatan</option>
                            <option value="pakaian" {{ request('tipe') == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                            <option value="lainnya" {{ request('tipe') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <a href="{{ route('logistik.index') }}" title="Reset Filter" class="p-1.5 border border-neutral-300 text-neutral-600 hover:bg-neutral-100 rounded-md inline-flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <section class="bg-white border border-neutral-200 rounded-lg shadow-xs overflow-hidden print-area">
            <div class="px-5 py-3 border-b border-neutral-200 flex items-center justify-between bg-neutral-50/70">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-neutral-900 uppercase tracking-wider">Daftar Inventaris Logistik</span>
                    <span class="bg-red-50 text-red-700 border border-red-200 text-xs px-2 py-0.5 rounded-full font-medium">
                        {{ $logistics->count() }} Jenis Bantuan
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-100/70 border-b border-neutral-200 text-[11px] font-semibold text-neutral-600 uppercase tracking-wider">
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
                                <tr class="border-b border-neutral-100 hover:bg-neutral-50/70 transition-colors">
                                    <td class="px-4 py-3 text-xs font-mono font-semibold text-neutral-900 whitespace-nowrap">
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
                                            })" class="px-2 py-1 text-xs font-medium text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 rounded transition-colors">
                                                Edit
                                            </button>
                                            <button type="button" @click="openDeleteModal('{{ $item->id }}', '{{ e($item->name) }}')" class="px-2 py-1 text-xs font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded transition-colors">
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
            
            <div @click.away="isFormModalOpen = false" class="bg-white border border-neutral-200 rounded-lg shadow-xl w-full max-w-lg my-8 overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-200 flex items-center justify-between bg-neutral-50">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded bg-red-600 text-white flex items-center justify-center">
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

                    <div class="pt-3 border-t border-neutral-200 flex items-center justify-end gap-2">
                        <button type="button" @click="isFormModalOpen = false" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-4 py-2 text-xs font-medium transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="bg-red-600 text-white hover:bg-red-700 rounded-md px-4 py-2 text-xs font-semibold transition-colors shadow-xs">
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
            
            <div @click.away="isDeleteModalOpen = false" class="bg-white border border-neutral-200 rounded-lg shadow-xl w-full max-w-md p-6 space-y-4">
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