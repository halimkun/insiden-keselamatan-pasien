<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Detail Data - {{ $user->name ?? 'Detail Data Karyawan' }}
        </h2>
    </x-slot>

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <div class="w-full">
            <header class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="text-lg font-medium text-gray-900">
                        Detail Karayawan
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Detail dari data karayawan - {{ $user->name ?? '' }}
                    </p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a type="button" href="{{ route('users.index') }}"
                        class="flex items-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
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
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Nama Karyawan</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{
                                        $user->name }}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Username</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{
                                        $user->username }}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Email</dt>
                                    <dd
                                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 hover:underline">
                                        <a target="_blank" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                    </dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Nomor HP</dt>
                                    <dd
                                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 hover:underline">
                                        <a target="_blank"
                                            href="https://wa.me/{{ preg_replace('/^0/', '62', $user?->detail?->no_hp) }}">{{
                                            $user?->detail?->no_hp }}</a>
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Unit</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{
                                        $user?->detail?->unit?->nama_unit }}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Jabatan</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{
                                        $user?->detail?->jabatan }}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Departement</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{
                                        $user?->detail?->departemen }}</dd>
                                </div>

                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>