<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Ubah Data Pasien
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                <div class="w-full">
                    <header class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h2 class="text-lg font-semibold text-gray-900">Ubah Data Pasien</h2>
                            <p class="mt-1 text-sm text-gray-600">Ubah Detail Data Pasien</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('pasien.index') }}" class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                                <x-icons.arrow-back class="h-5 w-5" />
                                Kembali
                            </a>
                        </div>
                    </header>

                    <div class="flow-root">
                        <div class="mt-8">
                            <div class="w-full py-2 align-middle">
                                <form method="POST" action="{{ route('pasien.update', $pasien->id) }}" role="form" enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf
                                    @include('pasien.form')

                                    <div class="flex items-center gap-4 mt-4">
                                        <x-primary-button>Submit</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
