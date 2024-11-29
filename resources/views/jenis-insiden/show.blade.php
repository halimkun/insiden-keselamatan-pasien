<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $jenisInsiden->name ?? __('Detail Data') . ' ' . __('Jenis Insiden') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                <div class="w-full">
                    <header class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h2 class="text-lg font-semibold text-gray-900">Detail Jenis Insiden</h2>
                            <p class="mt-1 text-sm text-gray-600">Detail data jenis insiden.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('jenis-insiden.index') }}" class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                                <x-icons.arrow-back class="h-5 w-5" />
                                Kembali
                            </a>
                        </div>
                    </header>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <div class="mt-6 border-t border-gray-100">
                                    <dl class="divide-y divide-gray-100">

                                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Alias</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $jenisInsiden->alias }}</dd>
                                        </div>

                                    </dl>
                                </div>

                                <div class="border-t border-gray-100">
                                    <dl class="divide-y divide-gray-100">

                                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Nama Jenis Insiden</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $jenisInsiden->nama_jenis_insiden }}</dd>
                                        </div>

                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
