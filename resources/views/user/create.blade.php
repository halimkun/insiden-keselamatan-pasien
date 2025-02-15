<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Karyawan
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="w-full">
            <header class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="text-lg font-medium text-gray-900">
                        Tamabah Karyawan Baru
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Tambahkan karyawan baru untuk bisa mengakses sistem
                    </p>
                </div>

                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a type="button" href="{{ route('users.index') }}"
                        class="flex gap-2 items-center rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                        <x-icons.arrow-back class="h-5 w-5" />
                        Kembali
                    </a>
                </div>
            </header>

            <div class="flow-root">
                <div class="mt-8">
                    <div class="w-full py-2 align-middle">
                        <form method="POST" action="{{ route('users.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            @include('user.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>