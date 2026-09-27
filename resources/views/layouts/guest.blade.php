<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KitaSiaga') }} - Portal Relawan & Kedaruratan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Plus_Jakarta_Sans',sans-serif] bg-neutral-100 text-neutral-900 antialiased selection:bg-red-100 selection:text-red-800 min-h-screen flex flex-col justify-center items-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo & Header Branding KitaSiaga -->
        <div class="text-center mb-6">
            <a href="/" class="inline-flex items-center gap-3 group focus:outline-none">
                <div class="w-12 h-12 rounded-lg bg-red-600 flex items-center justify-center text-white shadow-sm group-hover:bg-red-700 transition-colors">
            <img src="{{ asset('images/logo.webp') }}" alt="logo"/>
                </div>
                <div class="text-left">
                    <span class="text-xl font-bold tracking-tight text-neutral-900 block leading-tight">KitaSiaga</span>
                    <span class="text-[11px] font-medium text-neutral-500 block uppercase tracking-wider">Portal Relawan Bencana</span>
                </div>
            </a>
        </div>

        <!-- Main Card Form -->
        <div class="bg-white border border-neutral-200 rounded-xl shadow-sm p-6 sm:p-8">
            {{ $slot }}
        </div>

        <!-- Footer Link Kembali -->
        <div class="text-center mt-6">
            <a href="/" class="text-xs text-neutral-500 hover:text-red-600 font-medium transition-colors inline-flex items-center gap-1">
                &larr; Kembali ke Portal Warga
            </a>
        </div>
    </div>
</body>
</html>