<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jabatans') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="w-full">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Jabatans') }}</h1>
                    <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Jabatans') }}.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    @can('tambah_jabatan')
                    <a type="button" href="{{ route('jabatan.create') }}" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <x-icons.circle-plus class="h-5 w-5" />
                        Tambah Data
                    </a>
                    @endcan
                </div>
            </div>

            <div class="flow-root">
                <div class="mt-8 ">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>
                                
                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Kode</th>
                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nama</th>
                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Deskripsi</th>

                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($jabatans as $jabatan)
                                <tr class="even:bg-gray-50">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>
                                    
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $jabatan->kode }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $jabatan->nama }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $jabatan->deskripsi }}</td>

                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                        <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST" class="flex gap-2">
                                            <a href="{{ route('jabatan.show', $jabatan->id) }}" class="text-gray-600 font-bold hover:text-gray-900">
                                                <x-icons.search class="h-[1.1rem] w-[1.1rem]" />
                                            </a>
                                            @can('edit_jabatan')
                                                <a href="{{ route('jabatan.edit', $jabatan->id) }}" class="text-gray-600 font-bold hover:text-gray-900">
                                                    <x-icons.edit-circle class="h-[1.1rem] w-[1.1rem]" />
                                                </a>
                                            @endcan
                                            
                                            @can('hapus_jabatan')
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('jabatan.destroy', $jabatan->id) }}" class="text-red-600 font-bold hover:text-red-900" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">
                                                    <x-icons.trash class="h-[1.1rem] w-[1.1rem]" />
                                                </a>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4 px-4">
                            {!! $jabatans->withQueryString()->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>