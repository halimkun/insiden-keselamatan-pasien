<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Penanggung Biaya
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="w-full">
            <header class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="text-lg font-semibold text-gray-900">Tambah Penanggung Biaya</h2>
                    <p class="mt-1 text-sm text-gray-600">Tambah data penanggung biaya baru.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a type="button" href="{{ route('penanggung-biaya.index') }}"
                        class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                        <x-icons.arrow-back class="h-5 w-5" />
                        Kembali
                    </a>
                </div>
            </header>

            <div class="flow-root">
                <div class="mt-8">
                    <div class="max-w-xl py-2 align-middle">
                        <form method="POST" action="{{ route('penanggung-biaya.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            @include('penanggung-biaya.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>