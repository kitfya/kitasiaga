<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>KitaSiaga | Portal Tanggap Darurat Bencana & Navigasi Posko</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              red: '#dc2626',
              redHover: '#b91c1c',
              redDark: '#450a0a',
              accent: '#059669',
            }
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif']
          }
        }
      }
    }
  </script>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <style>
    .leaflet-container {
      z-index: 1 !important;
    }
    .marker-emergency-pin {
      width: 18px;
      height: 18px;
      background-color: #dc2626;
      border: 3px solid #ffffff;
      border-radius: 50%;
      box-shadow: 0 0 8px rgba(220, 38, 38, 0.8);
      animation: pulse 1.5s infinite;
    }
    .marker-posko-pin {
      width: 24px;
      height: 24px;
      background-color: #059669;
      color: white;
      font-weight: bold;
      font-size: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid #ffffff;
      border-radius: 50%;
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }
    @keyframes pulse {
      0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
      70% { transform: scale(1.1); box-shadow: 0 0 0 8px rgba(220, 38, 38, 0); }
      100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
    }
  </style>
</head>
<body class="bg-neutral-50 text-neutral-900 min-h-screen flex flex-col antialiased selection:bg-red-100 selection:text-red-800">

  <header class="bg-white border-b border-neutral-200 sticky top-0 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16 gap-2">
        <!-- Logo & Branding -->
        <div class="flex items-center gap-2.5 shrink-0">
          <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-md bg-red-600 flex items-center justify-center text-white shadow-xs">
            <img src="{{ asset('images/logo.webp') }}" alt="logo" class="w-full h-full object-cover rounded-md"/>
          </div>
          <div>
            <span class="text-sm sm:text-base font-bold tracking-tight text-neutral-900 block leading-tight">KitaSiaga</span>
            <span class="text-[10px] sm:text-[11px] font-medium text-neutral-500 block uppercase tracking-wider">Portal Darurat</span>
          </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex items-center gap-1.5 sm:gap-3">
          <a href="{{ route('welcome') }}" class="px-2.5 py-1.5 sm:px-3 sm:py-2 text-xs font-semibold rounded-md bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="hidden sm:inline">Portal Warga</span>
          </a>

          <div class="h-4 w-px bg-neutral-200 mx-0.5 hidden sm:block"></div>

          @auth
            <a href="{{ route('dashboard') }}" class="px-2.5 py-1.5 sm:px-3 sm:py-2 text-xs font-semibold rounded-md bg-neutral-900 text-white hover:bg-neutral-800 transition-colors flex items-center gap-1.5">
              <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
              <span class="hidden xs:inline">Dashboard</span> Relawan
            </a>
          @else
            <a href="{{ route('login') }}" class="px-2.5 py-1.5 sm:px-3 sm:py-2 text-xs font-medium rounded-md text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 transition-colors flex items-center gap-1">
              <svg class="w-4 h-4 text-neutral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
              <span>Masuk</span>
            </a>
            <a href="{{ route('register') }}" class="px-2.5 py-1.5 sm:px-3 sm:py-2 text-xs font-semibold rounded-md bg-emerald-600 text-white hover:bg-emerald-700 transition-colors flex items-center gap-1.5 shadow-xs">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
              <span>Daftar</span>
            </a>
          @endauth
        </nav>
      </div>
    </div>
  </header>

  <main class="flex-grow">
    <section class="bg-white border-b border-neutral-200 py-8 sm:py-14">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
          <h1 class="text-2xl sm:text-4xl font-bold tracking-tight text-neutral-900 leading-snug sm:leading-tight">
            Laporkan Kejadian Bencana Secara Cepat, Dapatkan Jalur Evakuasi Terdekat
          </h1>
          <p class="mt-3 sm:mt-4 text-sm sm:text-base text-neutral-600 leading-relaxed">
            Sistem terintegrasi untuk mendata kejadian banjir, longsor, dan kedaruratan lainnya. Lokasi Anda dideteksi secara presisi menggunakan GPS satelit untuk langsung mengarahkan Anda ke posko penampungan terdekat.
          </p>

          <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row sm:items-center gap-3">
            <button type="button" onclick="openReportModal()" class="w-full sm:w-auto bg-red-600 text-white hover:bg-red-700 rounded-md px-5 py-3 text-sm font-semibold transition-colors shadow-xs flex items-center justify-center gap-2">
              <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
              Laporkan Bencana Sekarang
            </button>
            <a href="#mapOverviewSection" class="w-full sm:w-auto border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-4 py-3 text-sm font-medium transition-colors flex items-center justify-center gap-2 text-center">
              <svg class="w-4 h-4 text-neutral-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
              Lihat Peta Posko & Rute
            </a>
          </div>

          <div class="mt-8 sm:mt-10 pt-6 border-t border-neutral-100 grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-3 gap-4">
            <div class="bg-neutral-50 sm:bg-transparent p-3 sm:p-0 rounded-lg border sm:border-0 border-neutral-100">
              <span class="text-xs text-neutral-500 block">Posko Aktif Bersiaga</span>
              <span class="text-lg sm:text-xl font-bold text-neutral-900 mt-0.5 block">{{ $totalPosko }} Titik Terpadu</span>
            </div>
            <div class="bg-neutral-50 sm:bg-transparent p-3 sm:p-0 rounded-lg border sm:border-0 border-neutral-100">
              <span class="text-xs text-neutral-500 block">Total Pengungsi Tertampung</span>
              <span class="text-lg sm:text-xl font-bold text-neutral-900 mt-0.5 block">{{ $totalPengungsi }} Jiwa</span>
            </div>
            <div class="bg-neutral-50 sm:bg-transparent p-3 sm:p-0 rounded-lg border sm:border-0 border-neutral-100 xs:col-span-2 sm:col-span-1">
              <span class="text-xs text-neutral-500 block">Kapasitas Aman Tersedia</span>
              <span class="text-lg sm:text-xl font-bold text-emerald-700 mt-0.5 block">{{ $kapasitasTersedia }} Slot</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="mapOverviewSection" class="py-8 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div id="navigationSection" class="space-y-4 sm:space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
          <div>
            <h2 class="text-xs sm:text-sm font-semibold text-red-600 uppercase tracking-wider">Petunjuk Arah & Posko Terdekat</h2>
            <p class="text-lg sm:text-xl font-bold text-neutral-900 mt-0.5">Rute Jalur Evakuasi Teraman Berdasarkan Titik Kejadian</p>
          </div>
          <div class="inline-flex items-center gap-2 self-start sm:self-auto">
            <span class="inline-flex items-center gap-1.5 text-xs text-neutral-600 bg-white border border-neutral-200 px-2.5 py-1 rounded-md shadow-2xs">
              <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span> Titik Kejadian
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs text-neutral-600 bg-white border border-neutral-200 px-2.5 py-1 rounded-md shadow-2xs">
              <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span> Posko Evakuasi
            </span>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
          <div class="lg:col-span-8 bg-white border border-neutral-200 rounded-lg p-2 shadow-xs z-0 relative">
            <div id="evacuationMap" class="w-full h-[320px] sm:h-[420px] rounded-md border border-neutral-200 relative bg-neutral-100 z-0"></div>
            <div class="p-2 flex flex-col sm:flex-row sm:items-center justify-between text-[11px] text-neutral-500 gap-1">
              <span>Data Peta: &copy; OpenStreetMap Kontributor &bull; Leaflet.js</span>
              <span class="font-medium text-emerald-700">Rute dihitung berdasarkan algoritma jarak terdekat</span>
            </div>
          </div>

          <div class="lg:col-span-4 space-y-4">
            <div class="border border-neutral-200 bg-white rounded-lg p-4 sm:p-5 shadow-xs">
              <div class="flex items-center justify-between pb-3 border-b border-neutral-100">
                <span class="text-xs font-semibold uppercase tracking-wider text-red-600">Rekomendasi Posko</span>
                <span id="navTicketId" class="text-xs font-mono bg-neutral-100 px-2 py-0.5 rounded text-neutral-700">-</span>
              </div>

              <div class="mt-4 space-y-3">
                <div>
                  <h3 id="navPoskoName" class="text-base font-bold text-neutral-900 leading-tight">Pilih atau Kirim Laporan</h3>
                  <p id="navPoskoAddress" class="text-xs text-neutral-500 mt-1">Sistem akan secara otomatis menentukan posko terdekat dari lokasi Anda.</p>
                </div>

                <div class="bg-neutral-50 p-3 rounded-md border border-neutral-200 grid grid-cols-2 gap-2">
                  <div>
                    <span class="text-[11px] text-neutral-500 block">Jarak Terdekat</span>
                    <span id="navDistance" class="text-sm font-bold text-neutral-900">- km</span>
                  </div>
                  <div>
                    <span class="text-[11px] text-neutral-500 block">Estimasi Tempuh</span>
                    <span id="navWalkingTime" class="text-xs font-semibold text-emerald-700">-</span>
                  </div>
                </div>

                <div class="space-y-1.5 pt-1">
                  <div class="flex items-center justify-between text-xs">
                    <span class="text-neutral-500">Kapasitas Posko:</span>
                    <span id="navCapacity" class="font-medium text-neutral-900">-</span>
                  </div>
                </div>

                <div class="pt-3 border-t border-neutral-100 flex flex-col gap-2">
                  <a id="btnOpenGmapsNav" href="#" target="_blank" rel="noopener" class="w-full bg-emerald-600 text-white hover:bg-emerald-700 rounded-md px-3.5 py-2.5 text-xs font-semibold transition-colors text-center flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    Buka Petunjuk Arah di Google Maps
                  </a>
                  <button type="button" onclick="openReportModal()" class="w-full border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-3 py-2 text-xs font-medium transition-colors text-center">
                    Buat Laporan Darurat Baru
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-10 sm:mt-12 space-y-4">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-xs sm:text-sm font-semibold text-red-600 uppercase tracking-wider">Pantauan Publik Terkini</h3>
            <p class="text-base sm:text-lg font-bold text-neutral-900 mt-0.5">Laporan Kejadian Bencana Terverifikasi Lapangan</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($publicReports as $report)
          <article class="p-4 border border-neutral-200 rounded-lg bg-white">
            <div class="flex items-start justify-between gap-3">
              <div class="space-y-1">
                <div class="flex items-center gap-2 flex-wrap">
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-red-50 text-red-700 border border-red-200">
                    {{ ucfirst($report->tipe) }}
                  </span>
                  <span class="text-xs text-neutral-400">•</span>
                  <time class="text-xs text-neutral-500">{{ $report->created_at->format('d M Y, H:i') }} WIB</time>
                </div>
                <h4 class="text-sm font-semibold text-neutral-900">#{{ $report->kode ?? 'LAP-'.$report->id }} - {{$report->name }}</h4>
                <p class="text-xs text-neutral-600 line-clamp-2 leading-relaxed">{{ $report->description }}</p>
              </div>
              <span class="shrink-0 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border bg-emerald-50 text-emerald-700 border-emerald-200">
                Terverifikasi
              </span>
            </div>
            <div class="mt-3 pt-3 border-t border-neutral-100 flex items-center justify-between text-xs text-neutral-500">
              <span class="inline-flex items-center gap-1 font-mono truncate max-w-[200px] sm:max-w-none">
                <svg class="w-3.5 h-3.5 text-neutral-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                {{ $report->latitude }}, {{$report->longitude }}
              </span>
              <a href="https://www.google.com/maps?q={{ $report->latitude }},{{$report->longitude }}" target="_blank" rel="noopener" class="text-red-600 hover:underline font-medium shrink-0">
                Tinjau Peta &rarr;
              </a>
            </div>
          </article>
          @empty
          <p class="text-xs text-neutral-500 col-span-2 py-4">Belum ada laporan bencana publik yang terverifikasi.</p>
          @endforelse
        </div>
      </div>
    </section>
  </main>

  <!-- Modal Form Lapor Bencana (Dioptimalkan untuk Mobile) -->
  <div id="reportModal" class="fixed inset-0 z-[9999] bg-neutral-900/60 backdrop-blur-xs hidden items-end sm:items-center justify-center p-0 sm:p-4 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="bg-white border-t sm:border border-neutral-200 rounded-t-xl sm:rounded-lg shadow-xl w-full max-w-xl max-h-[90vh] sm:max-h-[85vh] flex flex-col z-[10000] relative overflow-hidden">
      
      <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-neutral-200 flex items-center justify-between bg-neutral-50 shrink-0">
        <div class="flex items-center gap-2.5">
          <div class="w-7 h-7 rounded bg-red-600 text-white flex items-center justify-center shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
          </div>
          <div>
            <h2 class="text-xs sm:text-sm font-bold text-neutral-900">Formulir Lapor Darurat Bencana</h2>
            <p class="text-[10px] sm:text-[11px] text-neutral-500">Koordinat terdeteksi otomatis untuk rekomendasi posko</p>
          </div>
        </div>
        <button type="button" onclick="closeReportModal()" class="text-neutral-400 hover:text-neutral-700 p-1.5 rounded-md hover:bg-neutral-200/60 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>

      <form id="formLaporBencana" class="p-4 sm:p-6 space-y-3.5 sm:space-y-4 overflow-y-auto flex-grow">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-medium text-neutral-700 mb-1">Nama Lengkap Pelapor <span class="text-red-600">*</span></label>
            <input type="text" id="inputNama" name="name" required placeholder="Contoh: Bambang Sudarsono" class="w-full border border-neutral-300 rounded-md px-3 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-red-600 focus:outline-hidden">
          </div>
          <div>
            <label class="block text-xs font-medium text-neutral-700 mb-1">Nomor Telepon / WhatsApp</label>
            <input type="tel" id="inputTelepon" name="telepon" placeholder="Contoh: 081234567890" class="w-full border border-neutral-300 rounded-md px-3 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-red-600 focus:outline-hidden">
          </div>
        </div>

        <div>
          <label class="block text-xs font-medium text-neutral-700 mb-1">Tipe Bencana <span class="text-red-600">*</span></label>
          <select id="inputTipe" name="tipe" required class="w-full border border-neutral-300 rounded-md px-3 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-red-600 focus:outline-hidden bg-white">
            <option value="" disabled selected>Pilih Jenis Bencana Terjadi</option>
            <option value="banjir">Banjir Bandang / Genangan Tinggi</option>
            <option value="kebakaran">Kebakaran Pemukiman Warga</option>
            <option value="gempa">Gempa Bumi</option>
            <option value="tsunami">Tsunami</option>
            <option value="longsor">Tanah Longsor</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-medium text-neutral-700 mb-1">Deskripsi Kondisi Lapangan <span class="text-red-600">*</span></label>
          <textarea id="inputDeskripsi" name="description" rows="3" required placeholder="Jelaskan perkiraan ketinggian air / longsoran, jumlah warga terjebak, dsb..." class="w-full border border-neutral-300 rounded-md px-3 py-2 text-xs sm:text-sm focus:ring-2 focus:ring-red-600 focus:outline-hidden"></textarea>
        </div>

        <div>
          <label class="block text-xs font-medium text-neutral-700 mb-1">Bukti Foto / Video Lokasi</label>
          <input type="file" id="inputBukti" name="bukti" accept="image/*,video/*" class="w-full border border-neutral-300 rounded-md p-1.5 text-xs bg-white">
        </div>

        <div class="bg-neutral-50 p-3 sm:p-3.5 rounded-md border border-neutral-200 space-y-2">
          <div class="flex items-center justify-between">
            <label class="text-xs font-semibold text-neutral-800 flex items-center gap-1.5">
              <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
              Koordinat Lokasi Kejadian (GPS)
            </label>
            <button type="button" onclick="requestRealtimeGPS()" class="text-xs text-red-600 hover:underline font-medium">
              Deteksi Ulang
            </button>
          </div>

          <div class="grid grid-cols-2 gap-2">
            <div>
              <span class="text-[10px] sm:text-[11px] text-neutral-500 block">Latitude</span>
              <input type="number" step="any" id="inputLat" name="latitude" required readonly class="w-full border border-neutral-300 bg-neutral-100 rounded-md px-2 py-1 text-xs font-mono">
            </div>
            <div>
              <span class="text-[10px] sm:text-[11px] text-neutral-500 block">Longitude</span>
              <input type="number" step="any" id="inputLng" name="longitude" required readonly class="w-full border border-neutral-300 bg-neutral-100 rounded-md px-2 py-1 text-xs font-mono">
            </div>
          </div>
          <p id="gpsStatusText" class="text-[10px] sm:text-[11px] text-neutral-500">Mencari lokasi GPS Anda...</p>
        </div>

        <div class="pt-3 border-t border-neutral-200 flex items-center justify-end gap-2 shrink-0">
          <button type="button" onclick="closeReportModal()" class="border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-md px-4 py-2 text-xs font-medium">Batal</button>
          <button type="submit" id="btnSubmitReport" class="bg-red-600 text-white hover:bg-red-700 rounded-md px-4 py-2 text-xs font-semibold shadow-xs">Kirim Laporan Darurat</button>
        </div>
      </form>
    </div>
  </div>

  <footer class="bg-white border-t border-neutral-200 py-4 sm:py-6 text-xs text-neutral-500 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 shrink-0"></span>
        <span class="text-neutral-700 font-medium">KitaSiaga &bull; Sistem Informasi Tanggap Bencana & Posko Terpadu</span>
      </div>
      <div>
        Leaflet.js Engine &bull; OpenStreetMap Data
      </div>
    </div>
  </footer>

  <script>
    const poskoData = @json($poskoList);

    let leafletMap = null;
    let routeLayerGroup = null;
    let currentPelaporCoords = null;

    document.addEventListener('DOMContentLoaded', () => {
        initLeafletMap();
        requestRealtimeGPS();
    });

    function initLeafletMap() {
        if (typeof L === 'undefined') return;

        const defaultCenter = poskoData.length > 0 ? [poskoData[0].latitude, poskoData[0].longitude] : [-6.2000, 106.8166];

        leafletMap = L.map('evacuationMap', { scrollWheelZoom: false }).setView(defaultCenter, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(leafletMap);

        routeLayerGroup = L.layerGroup().addTo(leafletMap);

        poskoData.forEach(posko => {
            if (posko.latitude && posko.longitude) {
                const greenIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div class="marker-posko-pin" title="${posko.name}">P</div>`,
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });

                L.marker([posko.latitude, posko.longitude], { icon: greenIcon })
                    .bindPopup(`
                        <div class="p-1 text-xs">
                            <strong class="text-neutral-900">${posko.name}</strong><br>
                            <span class="text-neutral-500">${posko.alamat}</span><br>
                            <span class="text-emerald-700 font-semibold">Pengungsi: ${posko.jumlah_pengungsi}/${posko.kapasitas}</span>
                        </div>
                    `)
                    .addTo(leafletMap);
            }
        });
    }

    function requestRealtimeGPS() {
        const latInput = document.getElementById('inputLat');
        const lngInput = document.getElementById('inputLng');
        const statusEl = document.getElementById('gpsStatusText');

        if (!navigator.geolocation) {
            statusEl.textContent = 'Geolocation tidak didukung browser ini.';
            return;
        }

        statusEl.textContent = 'Meminta akses lokasi GPS satelit...';

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude.toFixed(6);
                const lng = position.coords.longitude.toFixed(6);

                latInput.value = lat;
                lngInput.value = lng;
                currentPelaporCoords = [parseFloat(lat), parseFloat(lng)];
                statusEl.textContent = `GPS Terkunci (Akurasi: ±${Math.round(position.coords.accuracy)}m)`;

                findAndDisplayNearestPosko(lat, lng);
            },
            (error) => {
                statusEl.textContent = 'Gagal mendeteksi lokasi otomatis. Menggunakan lokasi default.';
                latInput.value = '-6.241500';
                lngInput.value = '106.989000';
                currentPelaporCoords = [-6.241500, 106.989000];
                findAndDisplayNearestPosko(-6.241500, 106.989000);
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    function findAndDisplayNearestPosko(lat, lng) {
        if (!poskoData || poskoData.length === 0) return;

        let nearestPosko = null;
        let minDistance = Infinity;

        poskoData.forEach(posko => {
            if (posko.latitude && posko.longitude) {
                const dist = calculateHaversine(lat, lng, posko.latitude, posko.longitude);
                if (dist < minDistance) {
                    minDistance = dist;
                    nearestPosko = posko;
                }
            }
        });

        if (nearestPosko) {
            renderPoskoNavigationCard(nearestPosko, minDistance, lat, lng);
            drawEvacuationRoute([lat, lng], [nearestPosko.latitude, nearestPosko.longitude], nearestPosko.name);
        }
    }

    function calculateHaversine(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    function renderPoskoNavigationCard(posko, distKm, userLat, userLng) {
        document.getElementById('navPoskoName').textContent = posko.name;
        document.getElementById('navPoskoAddress').textContent = posko.alamat;
        document.getElementById('navDistance').textContent = distKm.toFixed(2) + ' km';

        const walkTime = Math.max(3, Math.round((distKm / 4.5) * 60));
        document.getElementById('navWalkingTime').textContent = `±${walkTime} Menit Jalan Kaki`;

        document.getElementById('navCapacity').textContent = `${posko.jumlah_pengungsi} / ${posko.kapasitas} Jiwa`;

        const gmapsBtn = document.getElementById('btnOpenGmapsNav');
        gmapsBtn.href = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${posko.latitude},${posko.longitude}`;
    }

    function drawEvacuationRoute(userCoords, poskoCoords, poskoName) {
        if (!leafletMap || !routeLayerGroup) return;

        routeLayerGroup.clearLayers();

        const redIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div class="marker-emergency-pin"></div>`,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        L.marker(userCoords, { icon: redIcon })
            .bindPopup(`<strong>Lokasi Anda (Pelapor)</strong>`)
            .addTo(routeLayerGroup);

        L.polyline([userCoords, poskoCoords], {
            color: '#059669',
            weight: 4,
            dashArray: '6, 8',
            opacity: 0.9
        }).addTo(routeLayerGroup);

        const bounds = L.latLngBounds([userCoords, poskoCoords]);
        leafletMap.fitBounds(bounds, { padding: [50, 50] });

        setTimeout(() => {
            leafletMap.invalidateSize();
        }, 200);
    }

    function openReportModal() {
        const modal = document.getElementById('reportModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReportModal() {
        const modal = document.getElementById('reportModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('formLaporBencana').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const btnSubmit = document.getElementById('btnSubmitReport');
        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Sending...';

        fetch("{{ route('lapor.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeReportModal();
                document.getElementById('navTicketId').textContent = '#' + (data.data.kode || 'LAP-' + data.data.id);
                findAndDisplayNearestPosko(data.data.latitude, data.data.longitude);
            } else {
                alert('Gagal mengirim laporan. Periksa masukan Anda.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan koneksi.');
        })
        .finally(() => {
            btnSubmit.disabled = false;
            btnSubmit.textContent = 'Kirim Laporan Darurat';
        });
    });
  </script>
</body>
</html>
