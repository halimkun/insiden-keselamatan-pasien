<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex items-center justify-between w-full sm:max-w-md mb-10">
                    <a href="{{ env('APP_URL') }}">
                        {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
                        <img src="{{ asset(\App\Helpers\SettingHelper::get('site_logo', 'images/logo.png')) }}" alt="Logo" class="max-w-[270px] max-h-[50px]" />
                    </a>
                    <img src="{{ asset('images/umy-maadrs.jpg') }}" alt="Logo" class="max-w-[270px] max-h-[50px]" />
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
