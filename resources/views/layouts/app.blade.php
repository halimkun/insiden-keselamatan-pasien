<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- ===== Fonts ===== --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- ===== Vite Scripts ===== --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ===== JQuery ===== --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- ===== Styles ===== --}}
    @stack('styles')
</head>

<body
    x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode')); $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">

    {{-- ===== Preloader Start ===== --}}
    <x-preloader />
    {{-- ===== Preloader End ===== --}}

    {{-- ===== Page Wrapper Start ===== --}}
    <div class="flex h-screen overflow-hidden lg:p-3">

        {{-- ===== Sidebar Start ===== --}}
        @include('layouts.partials.sidebar')
        {{-- ===== Sidebar End ===== --}}

        {{-- ===== Content Area Start ===== --}}
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
 
            {{-- ===== Header Start ===== --}}
            @include('layouts.partials.header')
            {{-- ===== Header End ===== --}}

            {{-- ===== Main Content Start ===== --}}
            <main>
                <div class="mx-auto max-w-screen-3xl px-4 md:px-6 2xl:px-10 2xl:py-3">
                    {{ $slot }}
                </div>
            </main>
            {{-- ===== Main Content End ===== --}}

        </div>
        {{-- ===== Content Area End ===== --}}

    </div>
    {{-- ===== Page Wrapper End ===== --}}

    {{-- ===== Scripts ===== --}}
    @stack('scripts')
</body>

</html>