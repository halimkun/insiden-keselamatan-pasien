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
        <h2 class="text-xl font-semibold leading-tight text-gray-800 flex gap-3 items-center">
            <x-icons.users class="h-5 w-5" />
            Karyawan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900 inline-flex items-center gap-2">
                                Karyawan
                            </h1>
                            <p class="mt-2 text-sm text-gray-700">Data karyawan yang terdaftar.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('users.create') }}" class="inline-flex gap-2 items-center rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                <x-icons.user-plus class="h-5 w-5" />
                                Add new
                            </a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block my-6 min-w-full py-2 align-middle">
                                <div class="flex flex-col md:flex-row gap-2 items-center md:justify-end w-full">
                                    {{-- show_deleted --}}
                                    <div class="flex items-center space-x-2 bg-gray-100 p-1.5 px-3 border shadow-sm rounded-lg">
                                        <label for="show_deleted" class="text-sm text-gray-700">Show Deleted</label>
                                        <input type="checkbox" id="show_deleted" class="checkbox checkbox-xs" />
                                    </div>

                                    {{-- search box --}}
                                    <div class="flex items-center space-x-2">
                                        <x-text-input id="search" placeholder="Search" class="input input-sm w-64" />
                                    </div>
                                </div>

                                <table class="w-full divide-y divide-gray-300" id="tableData">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Name</th>
                                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Username</th>
                                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Roles</th>
                                            <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Email</th>

                                            <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                                #
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

    {{-- Restore Confirmation --}}
    <dialog id="confirmRestore" class="modal">
        <div class="modal-box">
            <form method="POST">
                @csrf

                <input type="hidden" name="deleted_at" value="">

                <h3 class="text-lg font-bold">Restore Confirmation !</h3>
                <p class="text-sm">Are you sure you want to restore <span class="font-semibold" id="restoreName"></span> user?</p>

                <div class="modal-action mt-10 flex justify-end space-x-4">
                    <x-primary-button>Restore</x-primary-button>

                    <form method="dialog">
                        <x-secondary-button class="bg-red-500" onclick="confirmRestore.close()">Close</x-secondary-button>
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
                $(document).on('click', '.delete-user', function() {
                    $('#confirmDelete #name').text($(this).data('name'));
                    var url = "{{ route('users.destroy', ':id') }}".replace(':id', $(this).data('id'));
                    confirmDelete.showModal();
                    $('#confirmDelete form').attr('action', url);
                });

                // restore-user on click get data-id
                $(document).on('click', '.restore-user', function() {
                    $('#confirmRestore #restoreName').text($(this).data('name'));
                    var url = "{{ route('users.restore', ':id') }}".replace(':id', $(this).data('id'));
                    confirmRestore.showModal();
                    $('#confirmRestore form').attr('action', url);
                });

                var table = $('#tableData').DataTable({
                    processing: true,
                    serverSide: true,
                    lengthChange: false,

                    pageLength: 10,

                    ajax: {
                        url: "{{ route('datatables.users') }}",
                        data: function(d) {
                            d.show_deleted = $('#show_deleted').is(':checked') ? 1 : 0;
                        },
                        type: 'GET'
                    },

                    columns: [
                        { data: 'nomor', name: 'nomor' },
                        { data: 'name', name: 'name' },
                        { data: 'username', name: 'username' },
                        { data: 'roles', name: 'roles', searchable: true }, // Added Roles column
                        {
                            data: 'email',
                            name: 'email',
                            render: (data) => `<a href="mailto:${data}" class="hover:underline">${data}</a>`
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ],

                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td').eq(0).addClass('whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500');
                        $(row).find('td').eq(1).addClass('whitespace-nowrap px-3 py-4 text-sm text-gray-500');
                        $(row).find('td').eq(2).addClass('whitespace-nowrap px-3 py-4 text-sm text-gray-500');
                        $(row).find('td').eq(3).addClass('whitespace-nowrap px-3 py-4 text-sm text-gray-500');
                        $(row).find('td').eq(4).addClass('py-4 pl-4 pr-3 text-sm font-medium text-gray-500');
                    }
                });

                $('#search').on('keyup', function() {
                    table.search(this.value).draw();
                });

                $('#show_deleted').change(function() {
                    table.ajax.reload();
                });
            });
        </script>
    @endpush
</x-app-layout>
