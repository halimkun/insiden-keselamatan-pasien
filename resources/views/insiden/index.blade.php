<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Insiden
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                <div class="w-full">
                    <header class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h2 class="text-lg font-semibold text-gray-900">Data Insiden Pasien</h2>
                            <p class="mt-1 text-sm text-gray-600">Data insiden pasien yang terjadi di rumah sakit.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('insiden.create') }}" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                <x-icons.circle-plus class="h-5 w-5" />
                                Add New
                            </a>
                        </div>
                    </header>

                    <div class="flow-root">
                        <div class="mt-8">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <div class="flex w-full flex-col items-center gap-2 md:flex-row md:justify-end">
                                    {{-- search box --}}
                                    <div class="flex items-center space-x-2">
                                        <x-text-input id="search" placeholder="Search" class="input input-sm w-64" />
                                    </div>
                                </div>

                                <div class="w-full overflow-x-auto lg:overflow-visible">
                                    <table class="w-full divide-y divide-gray-300">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Pasien</th>
                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Jenis</th>
                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tanggal Insiden</th>
                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Pelapor</th>
                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tempat</th>

                                                <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @foreach ($insidens as $insiden)
                                                <tr class="even:bg-gray-50">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>

                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $insiden->pasien_id }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $insiden->jenis_insiden_id }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $insiden->tanggal_insiden }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $insiden->pelapor_id }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $insiden->tempat_kejadian }}</td>

                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                        <form action="{{ route('insiden.destroy', $insiden->id) }}" method="POST">
                                                            <a href="{{ route('insiden.show', $insiden->id) }}" class="mr-2 font-bold text-gray-600 hover:text-gray-900">{{ __('Show') }}</a>
                                                            <a href="{{ route('insiden.edit', $insiden->id) }}" class="mr-2 font-bold text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="{{ route('insiden.destroy', $insiden->id) }}" class="font-bold text-red-600 hover:text-red-900" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">{{ __('Delete') }}</a>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4 px-4">
                                    {!! $insidens->withQueryString()->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        
    @endpush
</x-app-layout>
