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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Investigasi Sederhana
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="w-full">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Investigasi</h1>
                    <p class="mt-2 text-sm text-gray-700">Daftar Investigasi Insiden Rumah Sakit</p>
                </div>
            </div>

            <div class="flow-root">
                <div class="mt-8 overflow-x-auto">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="w-full divide-y divide-gray-300" id="tableData">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>

                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Insiden</th>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tgl Mulai</th>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tgl Selesai</th>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Disahkan</th>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Info</th>

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

    <dialog id="confirmDelete" class="modal">
        <div class="modal-box">
            <form method="POST">
                @csrf
                @method('DELETE')

                <h3 class="text-lg font-bold">Delete Confirmation !</h3>
                <p class="text-sm">Are you sure you want to delete <span class="font-semibold" id="investigasi"></span> ?</p>

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
            // delete-investigasi on click get data-id
            $(document).on('click', '.delete-investigasi', function() {
                $('#confirmDelete #investigasi').text($(this).data('insiden'));
                var url = "{{ route('insiden.investigasi.destroy', ['insiden' => ':insiden', 'investigasi' => ':investigasi']) }}".replace(':insiden', $(this).data('insiden-id')).replace(':investigasi', $(this).data('id'));
                confirmDelete.showModal();
                $('#confirmDelete form').attr('action', url);
            });

            var table = $('#tableData').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                sort: false,

                pageLength: 10,

                ajax: {
                    url: "{{ route('datatables.investigasi') }}",
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
                    { data: 'insiden.insiden', name: 'insiden.insiden' },
                    { data: 'tanggal_mulai', name: 'tanggal_mulai' },
                    { data: 'tanggal_selesai', name: 'tanggal_selesai' },
                    { data: 'tanggal_pengesahan', name: 'tanggal_pengesahan' },
                    { data: 'info', name: 'info' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
    @endpush
</x-app-layout>