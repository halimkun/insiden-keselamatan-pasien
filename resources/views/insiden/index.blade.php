<x-app-layout>
    @push('styles')
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
            <x-icons.alert-triangle class="h-5 w-5" />
            Insiden
        </h2>
    </x-slot>

    @if (!Auth::user()->hasRole(['admin', 'superadmin', 'administrator', 'komite-mutu']) && !Auth::user()->detail?->unit_id)
        <x-alert title="Warning !" type="warning">
            <p>Sepertinya Anda belum memiliki unit terkait. Silahkan hubungi <span class="font-bold">Administrator</span> untuk menambahkan unit terkait, dengan demikian anda dapat mengakses data insiden.</p>
        </x-alert>
    @endif

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <div class="w-full">
            <header class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="text-lg font-semibold text-gray-900">Data Insiden Pasien</h2>
                    <p class="mt-1 text-sm text-gray-600">Data insiden pasien yang terjadi di rumah sakit.</p>
                </div>

                @can('tambah_insiden')
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" href="{{ route('insiden.create', ['step' => '1']) }}"
                            class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            <x-icons.circle-plus class="h-5 w-5" />
                            Add New
                        </a>
                    </div>
                @endcan
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
                            <table class="w-full divide-y divide-gray-300" id="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Insiden</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Jenis</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tgl Kejadian</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Dampak</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Korban</th>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Grading</th>

                                        <th scope="col" class="px-3 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">#</th>
                                    </tr>
                                </thead>

                            </table>
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
                <p class="text-sm">Are you sure you want to delete <span class="font-semibold" id="insiden"></span> ?</p>

                <div class="modal-action mt-10 flex justify-end space-x-4">
                    <x-danger-button onclick="confirmDelete.close()">Delete</x-danger-button>

                    <form method="dialog">
                        <x-secondary-button class="bg-red-500" onclick="confirmDelete.close()">Close
                        </x-secondary-button>
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
            // delete-insiden on click get data-id
            $(document).on('click', '.delete-insiden', function() {
                $('#confirmDelete #insiden').text($(this).data('insiden'));
                var url = "{{ route('insiden.destroy', ':id') }}".replace(':id', $(this).data('id'));
                confirmDelete.showModal();
                $('#confirmDelete form').attr('action', url);
            });

            // restore-insiden on click get data-id
            // $(document).on('click', '.restore-insiden', function() {
            //     $('#confirmRestore #restoreName').text($(this).data('insiden'));
            //     var url = "{{ route('users.restore', ':id') }}".replace(':id', $(this).data('id'));
            //     confirmRestore.showModal();
            //     $('#confirmRestore form').attr('action', url);
            // });

            var table = $('#tableData').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,

                pageLength: 10,

                ajax: {
                    url: "{{ route('datatables.insiden') }}",
                    data: function(d) {
                        d.show_deleted = $('#show_deleted').is(':checked') ? 1 : 0;
                    },
                    type: 'GET',
                },

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
                        data: 'insiden',
                        name: 'insiden',
                        render: function(data, type, row) {
                            return `<div class="max-w-sm truncate">${data}</div>`;
                        }
                    },
                    {
                        data: 'jenis_insiden.alias',
                        name: 'jenis_insiden.alias',
                    },
                    {
                        data: 'waktu__insiden',
                        name: 'waktu__insiden',
                    },
                    {
                        data: 'dampak_insiden',
                        name: 'dampak_insiden',
                        render: function(data, type, row) {
                            return `<div class="capitalize">${data}</div>`;
                        }
                    },
                    {
                        data: 'korban_insiden',
                        name: 'korban_insiden',
                        render: function(data, type, row) {
                            return `<div class="capitalize">${data}</div>`;
                        }
                    },
                    {
                        data: 'grading',
                        name: 'grading',
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });

            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
    @endpush
</x-app-layout>