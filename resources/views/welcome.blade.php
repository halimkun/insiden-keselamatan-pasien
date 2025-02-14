<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Helpers\SettingHelper::get('site_name', 'Insiden Keselamatan Pasien') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins antialiased bg-[#F2F7FF] min-h-[100svh]">
    {{-- navigation --}}
    <nav class="flex items-center justify-between p-6 bg-[#F2F7FF]">
        {{-- logo, menu center, login button --}}
        <div class="flex items-center justify-between w-full max-w-7xl mx-auto">
            <div class="flex flex-row gap-6 items-center justify-between lg:justify-start w-full">
                {{-- logo --}}
                <a href="{{ env('APP_URL') }}" class="text-xl font-semibold text-black">
                    <img src="{{ asset(\App\Helpers\SettingHelper::get('site_logo', 'images/logo.png')) }}" alt="Logo" class="max-w-[180px] xl:max-w-[270px] max-h-[40px] lg:max-h-[50px]" />
                </a>
                
                {{-- 2nd Branding --}}
                <a href="{{ env('APP_URL') . "#!" }}" class="text-xl font-semibold text-black">
                    <img src="{{ asset('images/umy-maadrs.jpg') }}" alt="Logo" class="max-w-[180px] xl:max-w-[270px] max-h-[40px] xl:max-h-[50px]" />
                </a>
            </div>

            {{-- menu center --}}
            <ul class="flex items-center gap-10">
                {{-- <li><a href="#" class="text-base font-medium text-[#6C87AE] hover:text-[#3A8EF6]">Home</a></li>
                <li><a href="#" class="text-base font-medium text-[#6C87AE] hover:text-[#3A8EF6]">About</a></li>
                <li><a href="#" class="text-base font-medium text-[#6C87AE] hover:text-[#3A8EF6]">Services</a></li>
                <li><a href="#" class="text-base font-medium text-[#6C87AE] hover:text-[#3A8EF6]">Contact</a></li> --}}
            </ul>

            <div class="hidden lg:block">
                {{-- login button --}}
                    @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-lg leading-none text-white rounded-full px-5 py-3 flex items-center justify-center gap-3 bg-gradient-to-br from-[#3A8EF6] to-[#6F3AFA] shadow-lg shadow-gray-400/50">
                            <x-icons.category class="w-5 h-5 text-white" />
                            <span class="mb-0.5">Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-lg leading-none text-white rounded-full px-5 py-3 flex items-center justify-center gap-3 bg-gradient-to-br from-[#3A8EF6] to-[#6F3AFA] shadow-lg shadow-gray-400/50">
                            <x-icons.login class="w-5 h-5 text-white" />
                            <span class="mb-0.5">Login</span>
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <div class="w-full bg-[#F2F7FF]">
        <div class="max-w-7xl mx-auto relative py-7">
            <div class="flex flex-col md:flex-row-reverse xl:flex-row gap-6 xl:h-[calc(100svh-16rem)]">
                {{-- Hero text --}}
                <div class="flex flex-col items-start justify-center gap-3 xl:gap-6 flex-1 max-w-xl px-5 xl:pl-10 2xl:px-0">
                    <p class="text-base xl:text-[22px] font-semibold text-[#00BFA5]">{{ \App\Helpers\SettingHelper::get('faskes_name') }}</p>
                    <h1 class="text-4xl xl:text-5xl font-bold text-black">{{ \App\Helpers\SettingHelper::get('site_name', 'Insiden Keselamatan Pasien') }}</h1>
                    <p class="text-base text-[#6C87AE]">{{ \App\Helpers\SettingHelper::get('site_description', 'lorem ipsum dolor') }}</p>

                    <div class="mt-7 xl:mt-0">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-lg leading-none text-white rounded-full px-5 py-3 flex items-center justify-center gap-3 bg-gradient-to-br from-[#3A8EF6] to-[#6F3AFA] shadow-lg shadow-gray-400/50 hover:-translate-y-1 cursor-pointer transition-all ease-in-out duration-300">
                                <x-icons.health-recognition class="w-6 h-6 text-white" />
                                <span class="mb-0.5">Manage Your Risk</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-lg leading-none text-white rounded-full px-5 py-3 flex items-center justify-center gap-3 bg-gradient-to-br from-[#3A8EF6] to-[#6F3AFA] shadow-lg shadow-gray-400/50 hover:-translate-y-1 cursor-pointer transition-all ease-in-out duration-300">
                                <x-icons.health-recognition class="w-6 h-6 text-white" />
                                <span class="mb-0.5">Manage Your Risk</span>
                            </a>
                        @endauth
                    </div>
                </div>
    
                {{-- Illustration --}}
                <div class="flex items-center justify-center xl:justify-end flex-1">
                    <img src="{{ asset("images/hero-illustrator.png") }}" alt="Hero" class="w-full md:w-[90%] xl:w-[80%]" />
                </div>
            </div>

            <div class="w-full flex flex-col md:flex-row items-center gap-3 xl:gap-6 px-5 xl:px-0 justify-center mt-12 xl:mt-0">
                <div class="rounded-xl shadow-lg shadow-gray-400/50 bg-gradient-to-br from-[#1678F2] to-[#65A8FB] p-4 px-5 w-[340px] md:w-[305px] xl:w-[350px] hover:-translate-y-2 cursor-pointer transition-all ease-in-out duration-300">
                    <div class="w-full flex gap-3 text-white">
                        <div class="mt-0.5">
                            <x-icons.refresh class="w-6 h-6 text-white" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <h3 class="font-semibold text-lg">Penilaian Risiko Otomatis</h3>
                            <p class="text-xs">Otomatis mengidentifikasi tingkat risiko dengan cepat dan akurat.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl shadow-lg shadow-gray-400/50 bg-gradient-to-br from-[#1678F2] to-[#65A8FB] p-4 px-5 w-[340px] md:w-[305px] xl:w-[350px] hover:-translate-y-2 cursor-pointer transition-all ease-in-out duration-300">
                    <div class="w-full flex gap-3 text-white">
                        <div class="mt-0.5">
                            <x-icons.git-branch class="w-6 h-6 text-white" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <h3 class="font-semibold text-lg">Data yang Terintegrasi</h3>
                            <p class="text-xs">Data disimpan secara terpusat, memudahkan akses, analisis, dan pelaporan.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl shadow-lg shadow-gray-400/50 bg-gradient-to-br from-[#1678F2] to-[#65A8FB] p-4 px-5 w-[340px] md:w-[305px] xl:w-[350px] hover:-translate-y-2 cursor-pointer transition-all ease-in-out duration-300">
                    <div class="w-full flex gap-3 text-white">
                        <div class="mt-0.5">
                            <x-icons.rosette-discount-check class="w-[26px] h-[26px] text-white" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <h3 class="font-semibold text-lg">Meningkatkan Keselamatan</h3>
                            <p class="text-xs">Manajemen yang efisien dan meningkatkan keselamatan pasien.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>