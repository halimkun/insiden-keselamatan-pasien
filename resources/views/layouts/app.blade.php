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
    <script src="{{ asset('static/js/jquery-3.7.1.min.js') }}"></script>

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
    <div class="flex h-screen overflow-hidden pb-3 lg:p-3">

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
                    {{-- @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5" role="alert">
                            <strong class="font-bold">Something went wrong!</strong>
                            <ul class="mt-1 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    {{ $slot }}
                </div>
            </main>
            {{-- ===== Main Content End ===== --}}

        </div>
        {{-- ===== Content Area End ===== --}}

    </div>
    {{-- ===== Page Wrapper End ===== --}}

    {{-- ===== DIALOG JUKNIK ===== --}}
   <dialog id="juknisModal" class="modal">
        <div class="modal-box w-11/12 max-w-3xl bg-white p-4 rounded-lg shadow-lg">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Juknis Insidek Keselamatan Pasien !</h3>
            <p>Petunjuk dan panduan dalam menggunakan aplikasi ini.</p>

            <div class="mt-4">
                {{-- iframe to show pdf on public folder --}}
                <iframe src="{{ asset('docs/juknis.pdf') }}" class="w-full min-h-[calc(100svh-15rem)]" frameborder="0"></iframe>
            </div>
        </div>
    </dialog>

    <script src="{{ asset('static/js/sweetalert2@11.js') }}"></script>

    {{-- ===== Scripts ===== --}}
    @stack('scripts')

    <script>
        $(document).ready(function() {
            const localStorageJuknisModal = localStorage.getItem('juknisModal');

            setTimeout(() => {
                if (!localStorageJuknisModal) {
                    document.getElementById('juknisModal').showModal();
                }

                // set to local storage to prevent showing again
                localStorage.setItem('juknisModal', 'true');
            }, 1000);

            @if (session('success'))
                Swal.fire({icon: 'success',title: 'Success',text: '{{ session('success') }}',showConfirmButton: false,timer: 2500});
            @endif
            @if (session('error'))
                Swal.fire({icon: 'error',title: 'Error',text: '{{ session('error') }}',showConfirmButton: false,timer: 2500});
            @endif
        });
    </script>
</body>

</html>