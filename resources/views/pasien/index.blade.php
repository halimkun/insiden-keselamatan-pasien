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
        <h2 class="flex items-center gap-3 text-xl font-semibold leading-tight text-gray-800">
            <x-icons.health-recognition class="h-5 w-5" />
            Pasien
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                <div class="w-full">
                    <header class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h2 class="text-lg font-semibold text-gray-900">Data Pasien</h2>
                            <p class="mt-1 text-sm text-gray-600">Data pasien yang terdaftar di rumah sakit.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('pasien.create') }}" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                <x-icons.circle-plus class="h-5 w-5" />
                                Tambah Pasien
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
                                                <th scope="col" class="py-3 pl-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                                                <th scope="col" class="py-3 pl-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nama</th>
                                                <th scope="col" class="py-3 pl-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Rekam Medis</th>
                                                <th scope="col" class="py-3 pl-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tanggal Lahir</th>

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
                <p class="text-sm">Are you sure you want to delete <span class="font-semibold" id="name"></span> user?</p>

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
                        url: "{{ route('datatables.pasien') }}",
                        data: function(d) {
                            d.show_deleted = $('#show_deleted').is(':checked') ? 1 : 0;
                        },
                        type: 'GET',
                    },

                    // order
                    order: [
                        [2, 'DESC']
                    ],

                    columns: [
                        {
                            data: 'id',
                            name: 'id',
                            orderable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                        },
                        {
                            data: 'no_rekam_medis',
                            name: 'no_rekam_medis',
                        },
                        {
                            data: 'tanggal_lahir',
                            name: 'tanggal_lahir',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ],

                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td').eq(4).addClass('py-3 pl-4 pr-3 text-center text-sm text-gray-500');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
