<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('daipolres.webp') }}" type="image/webp">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ isSidebarOpen: false }" class="min-h-screen bg-gray-50">
            <!-- Overlay for mobile sidebar -->
            <div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 z-30 bg-black opacity-50 sm:hidden" style="display:none;"></div>

            @include('layouts.header')

            {{-- Include the new sidebar --}}
            @include('layouts.sidebar')

            {{-- Main Content --}}
            <div class="p-4 sm:ml-64">
                <x-notification />
                <div class="mt-14">
                    <!-- Page Heading -->
                    @hasSection('header')
                        <header class="bg-secondary shadow mb-6">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                @yield('header')
                            </div>
                        </header>
                    @endif

                    <!-- Page Content -->
                    <main>
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
