<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <!-- Leaflet.js CSS & JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-neutral-50 text-neutral-900 min-h-screen flex flex-col antialiased selection:bg-red-100 selection:text-red-800">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                        {{ $header }}
            @endisset

            <!-- Page Content -->
            <main class="flex-grow py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full space-y-8">
                {{ $slot }}
            </main>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('reportModal', () => ({
                    isOpen: false,
                    report: {},

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

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </body>
</html>
