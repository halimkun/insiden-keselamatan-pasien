<x-app-layout>
    @push('styles')
        {{-- using public url --}}
        <link rel="stylesheet" href="{{ asset('static/css/dataTables.tailwindcss.css') }}">

        <script src="{{ asset('static/js/dataTables.js') }}"></script>
        <script src="{{ asset('static/js/dataTables.tailwindcss.js') }}"></script>

        <style>
            .dt-search {
                display: none;
                visibility: hidden;
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col items-center justify-between gap-6 md:flex-row md:gap-0">
            <h2 class="flex items-center gap-2 text-xl font-semibold leading-none text-gray-800">
                <x-icons.database class="h-5 w-5" />
                Master Data {{ request()->segment(2) ? '- ' . \Str::headline(\Str::replace('-', ' ', request()->segment(2))) : '' }}
            </h2>

            <x-master-data.navigation />
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                <div class="w-full">
                    <header class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h2 class="text-lg font-semibold text-gray-900">{{ __('Units') }}</h2>
                            <p class="mt-1 text-sm text-gray-600">A list of all the {{ __('Units') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('unit.create') }}" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                <x-icons.circle-plus class="h-5 w-5" />
                                Add New
                            </a>
                        </div>
                    </header>

                    <div class="flow-root">
                        <div class="mt-8">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <div class="w-full overflow-x-auto lg:overflow-visible">
                                    <table class="w-full divide-y divide-gray-300" id="tableData">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nama Unit</th>

                                                <th scope="col" class="px-3 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                    <span class="text-lg">#</span>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation --}}
    <dialog id="confirmDelete" class="modal">
        <div class="modal-box">
            <form method="POST">
                @csrf
                @method('DELETE')

                <h3 class="text-lg font-bold">Delete Confirmation !</h3>
                <p class="text-sm">Are you sure you want to delete <span class="font-semibold" id="unit"></span> unit?</p>

                <div class="modal-action mt-10 flex justify-end space-x-4">
                    <x-danger-button onclick="confirmDelete.close()">Delete</x-danger-button>

                    <form method="dialog">
                        <x-secondary-button class="bg-red-500" onclick="confirmDelete.close()">Close</x-secondary-button>
                    </form>
                </div>
            </form>
        </div>

        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // delete-user on click get data-id
                $(document).on('click', '.delete-unit', function() {
                    $('#confirmDelete #unit').text($(this).data('unit'));
                    var url = "{{ route('unit.destroy', ':id') }}".replace(':id', $(this).data('id'));
                    confirmDelete.showModal();
                    $('#confirmDelete form').attr('action', url);
                });

                var table = $('#tableData').DataTable({
                    processing: true,
                    serverSide: true,
                    lengthChange: false,

                    pageLength: 10,

                    ajax: {
                        url: "{{ route('datatables.units') }}",
                        data: function(d) {
                            d.show_deleted = $('#show_deleted').is(':checked') ? 1 : 0;
                        },
                        type: 'GET',
                    },

                    columns: [
                        {
                            data: 'id',
                            name: 'id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'nama_unit',
                            name: 'nama_unit'
                        },
                        {
                            data: 'action',
                            name: 'action',
                        }
                    ],

                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td').eq(2).addClass('whitespace-nowrap text-center py-3 pl-4 pr-3 text-sm text-gray-500');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
