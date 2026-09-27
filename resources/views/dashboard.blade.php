<x-app-layout>
    <section class="border border-neutral-200 bg-white rounded-lg p-5 shadow-xs">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="space-y-1">
          <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
            <span class="text-xs font-medium text-emerald-700 uppercase tracking-wider">Posko Penugasan Bersiaga</span>
          </div>
          <h1 id="activePoskoName" class="text-xl font-bold text-neutral-900 leading-tight">{{ $posko->name ?? 'Posko Utama' }}</h1>
          <p id="activePoskoAddress" class="text-xs text-neutral-500">{{ $posko->alamat ?? 'Alamat Posko Belum Diset' }}</p>
        </div>
      </div>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
      <article class="border border-neutral-200 bg-white rounded-lg p-5 shadow-xs hover:border-red-200 transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-medium text-red-600 uppercase tracking-wider">Pengungsi Posko</span>
          <span class="p-1.5 rounded-md bg-red-50 text-red-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
          </span>
        </div>
        <div class="mt-3">
          <div id="statTotalVictims" class="text-2xl font-bold tracking-tight text-neutral-900">{{ $posko->jumlah_pengungsi ?? 0 }} Jiwa</div>
          <p class="text-xs text-neutral-500 mt-0.5">Tercatat di posko saat ini</p>
        </div>
        <div class="mt-4 pt-3 border-t border-neutral-100 grid grid-cols-2 gap-2 text-[11px]">
          <div>Lansia: <strong class="text-neutral-900">{{ $korban->where('kelompok_rentan', 'lansia')->count() }}</strong> jiwa</div>
          <div>Balita: <strong class="text-neutral-900">{{ $korban->where('kelompok_rentan', 'bayi')->count() }}</strong> anak</div>
          <div>Ibu Hamil: <strong class="text-neutral-900">{{ $korban->where('kelompok_rentan', 'hamil')->count() }}</strong> jiwa</div>
          <div>Disabilitas: <strong class="text-red-600">{{ $korban->where('kelompok_rentan', 'disabilitas')->count() }}</strong> orang</div>
        </div>
      </article>

      <article class="border border-neutral-200 bg-white rounded-lg p-5 shadow-xs hover:border-red-200 transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-medium text-red-600 uppercase tracking-wider">Perlu Verifikasi</span>
          <span class="p-1.5 rounded-md bg-amber-50 text-amber-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          </span>
        </div>
        <div class="mt-3">
          <div class="text-2xl font-bold tracking-tight text-amber-700">{{ $laporanPending }} Laporan</div>
          <p class="text-xs text-neutral-500 mt-0.5">Menunggu verifikasi</p>
        </div>
      </article>

      <article class="border border-neutral-200 bg-white rounded-lg p-5 shadow-xs hover:border-red-200 transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-medium text-red-600 uppercase tracking-wider">Total Laporan</span>
          <span class="p-1.5 rounded-md bg-neutral-100 text-neutral-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          </span>
        </div>
        <div class="mt-3">
          <div class="text-2xl font-bold tracking-tight text-neutral-900">{{ $laporan }} Laporan</div>
          <p class="text-xs text-neutral-500 mt-0.5">Masuk dalam sistem</p>
        </div>
      </article>

      <article class="border border-neutral-200 bg-white rounded-lg p-5 shadow-xs hover:border-red-200 transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-medium text-red-600 uppercase tracking-wider">Status Logistik</span>
          <span class="p-1.5 rounded-md bg-emerald-50 text-emerald-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
          </span>
        </div>
        <div class="mt-3">
          <div class="text-2xl font-bold tracking-tight text-emerald-700">{{ $logistik }} Tersedia</div>
          <p class="text-xs text-neutral-500 mt-0.5">{{ $logistikMenipis }} item butuh penambahan stok</p>
        </div>
      </article>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mt-6" x-data="reportModal()">
      
      <section class="lg:col-span-8 bg-white border border-neutral-200 rounded-lg shadow-xs overflow-hidden">
        <div class="p-5 border-b border-neutral-200 space-y-4">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
              <h2 class="text-base font-bold text-neutral-900">Laporan Bencana Masuk</h2>
              <p class="text-xs text-neutral-500">Klik tombol detail untuk membuka informasi lengkap, media bukti, dan navigasi lokasi</p>
            </div>
            
            <div class="relative w-full sm:w-64">
              <input type="text" id="searchReportInput" placeholder="Cari pelapor, tipe, ID..." class="w-full border border-neutral-300 rounded-md pl-8 pr-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-red-600 placeholder:text-neutral-400">
              <svg class="w-4 h-4 text-neutral-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-neutral-50/80 border-b border-neutral-200 text-[11px] font-semibold text-neutral-500 uppercase tracking-wider">
                <th class="px-4 py-2.5">Kode Laporan</th>
                <th class="px-4 py-2.5">Pelapor</th>
                <th class="px-4 py-2.5">Tipe Bencana</th>
                <th class="px-4 py-2.5">Koordinat Satelit</th>
                <th class="px-4 py-2.5">Status</th>
                <th class="px-4 py-2.5 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody id="reportsTableBody" class="divide-y divide-neutral-100 text-xs">
              @forelse($laporanList as $data)
              @php
                $filePath = $data->bukti;
            
                $mediaUrl = $filePath ? asset('storage/' . ltrim($filePath, '/')) : '';
            
                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                $isVideo = in_array($ext, ['mp4', 'mkv', 'webm', 'mov', 'avi']);
                
                $kodeLaporan = $data->kode_laporan ?? 'LAP-' . str_pad($data->id, 4, '0', STR_PAD_LEFT);
            @endphp
              <tr class="border-b border-neutral-100 hover:bg-neutral-50/80 transition-colors">
                  <td class="px-4 py-3 text-xs font-mono font-bold text-neutral-900">
                      #{{ $kodeLaporan }}
                  </td>

                  <td class="px-4 py-3">
                      <div class="text-xs font-medium text-neutral-900">{{ $data->name }}</div>
                  </td>

                  <td class="px-4 py-3">
                      <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-neutral-100 text-neutral-800">
                          {{ $data->tipe }}
                      </span>
                      <div class="text-[11px] text-neutral-500 mt-0.5 line-clamp-1 max-w-xs">{{ $data->description }}</div>
                  </td>

                  <td class="px-4 py-3 text-xs text-neutral-600 whitespace-nowrap">
                      <span class="inline-flex items-center gap-1 font-mono">
                          <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                          {{ $data->latitude }}, {{$data->longitude }}
                      </span>
                  </td>

                  <td class="px-4 py-3 whitespace-nowrap">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium border {{ $data->is_valid ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                          {{ $data->is_valid ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
                      </span>
                  </td>

                  <td class="px-4 py-3 text-right whitespace-nowrap">
                      <button type="button" 
                              @click="openModal({
                                  id: '{{ $data->id }}',
                                  kode: '{{ $kodeLaporan }}',
                                  waktu: '{{ $data->created_at ? $data->created_at->format('d M Y, H:i') : '-' }} WIB',
                                  status: '{{ $data->is_valid ? 'Terverifikasi' : 'Menunggu Verifikasi' }}',
                                  tipe: '{{ $data->tipe }}',
                                  mediaUrl: '{{ $mediaUrl }}',
                                  isVideo: {{ $isVideo ? 'true' : 'false' }},
                                  pelapor: '{{ e($data->name) }}',
                                  telepon: '{{ $data->telepon ?? '-' }}',
                                  deskripsi: '{{ e($data->description) }}',
                                  lat: '{{ $data->latitude }}',
                                  lng: '{{ $data->longitude }}'
                              })" 
                              class="text-xs font-semibold text-red-600 hover:text-red-700 hover:underline inline-flex items-center gap-1">
                          Detail Laporan
                          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                      </button>
                  </td>
              </tr>
              @empty
              <tr>
                  <td colspan="6" class="px-4 py-6 text-center text-xs text-neutral-500">
                      Belum ada laporan bencana yang tersimpan.
                  </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="px-4 py-3 bg-neutral-50 border-t border-neutral-200 text-[11px] text-neutral-500 flex items-center justify-between">
          <span>Menampilkan aliran laporan real-time yang tersimpan di sistem</span>
          <span class="font-medium text-neutral-700">Waspada: Dahulukan evakuasi warga kelompok rentan</span>
        </div>
      </section>

      <div x-show="isOpen" 
           x-cloak
           x-transition.opacity.duration.200ms
           @keydown.escape.window="closeModal()"
           class="fixed inset-0 z-50 bg-neutral-900/60 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6 overflow-y-auto" 
           role="dialog" 
           aria-modal="true">
        
        <div @click.away="closeModal()" class="bg-white border border-neutral-200 rounded-lg shadow-xl w-full max-w-2xl my-8 overflow-hidden">
            
            <div class="px-6 py-4 border-b border-neutral-200 flex items-center justify-between bg-neutral-50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded bg-red-600 text-white flex items-center justify-center font-mono font-bold text-xs">
                        LAP
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm font-bold text-neutral-900">Detail Laporan Bencana</h2>
                            <span class="text-xs font-mono font-bold bg-neutral-200/80 px-1.5 py-0.5 rounded text-neutral-800" x-text="'#' + report.kode"></span>
                        </div>
                        <p class="text-[11px] text-neutral-500" x-text="report.waktu"></p>
                    </div>
                </div>

                <button type="button" @click="closeModal()" class="text-neutral-400 hover:text-neutral-700 p-1.5 rounded-md hover:bg-neutral-200/60 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-5">
                <div class="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-neutral-100">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-neutral-500">Status Tindak Lanjut:</span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border"
                              :class="report.status === 'Terverifikasi' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200'"
                              x-text="report.status"></span>
                    </div>
                    <div>
                        <span class="text-xs text-neutral-500">Tipe Kejadian:</span>
                        <span class="font-semibold text-xs text-neutral-900 ml-1" x-text="report.tipe"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="sm:col-span-5">
                        <span class="text-[11px] font-medium text-neutral-500 block mb-1">Bukti Foto / Media Lapangan</span>
                        
                        <template x-if="report.mediaUrl && report.isVideo">
                            <video :src="report.mediaUrl" controls class="w-full h-44 object-cover rounded-md border border-neutral-200 bg-black"></video>
                        </template>

                        <template x-if="report.mediaUrl && !report.isVideo">
                            <img :src="report.mediaUrl" alt="Bukti Lapangan" class="w-full h-44 object-cover rounded-md border border-neutral-200 bg-neutral-100">
                        </template>

                        <template x-if="!report.mediaUrl">
                            <div class="w-full h-44 rounded-md border border-neutral-200 bg-neutral-100 flex flex-col items-center justify-center text-neutral-400 p-2 text-center">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-[11px]">Tidak ada bukti media</span>
                            </div>
                        </template>
                    </div>

                    <div class="sm:col-span-7 space-y-3">
                        <div>
                            <span class="text-[11px] font-medium text-neutral-500 block">Identitas Pelapor</span>
                            <div class="text-sm font-bold text-neutral-900" x-text="report.pelapor"></div>
                            <div class="text-xs text-neutral-500 flex items-center gap-1.5 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <a :href="'tel:' + report.telepon" x-text="report.telepon" class="text-red-600 hover:underline font-semibold font-mono"></a>
                            </div>
                        </div>

                        <div>
                            <span class="text-[11px] font-medium text-neutral-500 block">Laporan Situasi Lapangan</span>
                            <p x-text="report.deskripsi" class="text-xs text-neutral-700 leading-relaxed mt-0.5 p-2.5 rounded bg-neutral-50 border border-neutral-200 max-h-28 overflow-y-auto"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-neutral-50 p-4 rounded-md border border-neutral-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <span class="text-[11px] font-semibold text-neutral-500 uppercase tracking-wider block">Titik Koordinat Lokasi Kejadian</span>
                        <div class="flex items-center gap-2 mt-0.5">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span class="text-sm font-mono font-bold text-neutral-900" x-text="report.lat + ', ' + report.lng"></span>
                        </div>
                        <span class="text-[11px] text-neutral-500">Klik tombol di samping untuk rute navigasi akurat armada.</span>
                    </div>

                    <a :href="`https://www.google.com/maps?q=${report.lat},${report.lng}`" 
                       target="_blank" 
                       rel="noopener" 
                       class="bg-red-600 text-white hover:bg-red-700 rounded-md px-4 py-2.5 text-xs font-semibold inline-flex items-center justify-center gap-2 shadow-xs shrink-0 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Buka Lokasi di Google Maps
                    </a>
                </div>

                <div class="pt-4 border-t border-neutral-200 flex flex-wrap items-center justify-between gap-3">
                    <button type="button" @click="closeModal()" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-3.5 py-1.5 text-xs font-medium transition-colors">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
      </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('reportModal', () => ({
                isOpen: false,
                report: {
                    id: '',
                    kode: '',
                    waktu: '',
                    status: '',
                    tipe: '',
                    mediaUrl: '',
                    isVideo: false,
                    pelapor: '',
                    telepon: '',
                    deskripsi: '',
                    lat: '',
                    lng: ''
                },
                openModal(data) {
                    this.report = data;
                    this.isOpen = true;
                },
                closeModal() {
                    this.isOpen = false;
                }
            }));
        });
    </script>
</x-app-layout>