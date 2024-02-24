<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 grid grid-cols-12" x-data="{open: false}">
            {{-- @livewire('navigation-menu') --}}
            <x-navbar.sidebar />
            <div class="xl:col-span-10 col-span-12 w-full">
                <x-navbar.default :header="$header" />
                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
