<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create') }} Jabatan
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="w-full">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Create') }} Jabatan</h1>
                    <p class="mt-2 text-sm text-gray-700">Add a new {{ __('Jabatan') }}.</p>
                </div>
                <a type="button" href="{{ route('jabatan.index') }}"
                    class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                    <x-icons.arrow-back class="h-5 w-5" />
                    Kembali
                </a>
            </div>

            <div class="flow-root">
                <div class="mt-8 ">
                    <div class="max-w-xl py-2 align-middle">
                        <form method="POST" action="{{ route('jabatan.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            @include('jabatan.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>