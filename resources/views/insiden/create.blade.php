<x-app-layout>
    @push('styles')
        {{-- using public url --}}
        <link rel="stylesheet" href="{{ asset('static/css/responsive.dataTables.css') }}">
        <link rel="stylesheet" href="{{ asset('static/css/dataTables.tailwindcss.css') }}">
        <link rel="stylesheet" href="{{ asset('static/css/scroller.dataTables.css') }}">
        <link rel="stylesheet" href="{{ asset('static/css/fixedColumns.dataTables.css') }}">

        <style>
            .dt-search {
                display: none;
                visibility: hidden;
            }

            .dt-scroll-body {
                height: auto;
                background: transparent !important;
            }
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="flex items-center gap-3 text-xl font-semibold leading-tight text-gray-800">
            <x-icons.alert-triangle class="h-5 w-5" />
            Tambah Insiden
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('insiden.store') }}" role="form" enctype="multipart/form-data">
        @csrf
        <div class="py-6">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <div class="w-full">
                        <header class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                            <div class="flex w-full items-center justify-start gap-4 lg:justify-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500 p-5">
                                    <p class="m-0 p-0 font-semibold leading-none text-white">1</p>
                                </div>

                                <div class="sm:flex-auto">
                                    <h2 class="text-lg font-semibold text-indigo-500">Pilih Pasien</h2>
                                    <p class="text-sm text-gray-600">Pilih pasien yang terkait dengan insiden.</p>
                                </div>
                            </div>

                            {{-- search --}}
                            <x-text-input id="search" placeholder="Search" class="input input-sm w-full lg:w-64" />
                        </header>

                        <div class="flow-root">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <div class="w-full overflow-x-auto lg:overflow-visible">
                                    <table class="w-full divide-y divide-gray-300" id="tableData">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="py-3 pl-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nama</th>
                                                <th scope="col" class="py-3 pl-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Rekam Medis</th>
                                                <th scope="col" class="py-3 pl-3 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tanggal Lahir</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <x-input-error class="mt-2" :messages="$errors->get('pasien_id')" />
                    </div>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <div class="w-full">
                        <header class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                            <div class="flex w-full items-center justify-start gap-4 lg:justify-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500 p-5">
                                    <p class="m-0 p-0 font-semibold leading-none text-white">2</p>
                                </div>

                                <div class="sm:flex-auto">
                                    <h2 class="text-lg font-semibold text-indigo-500">Detail Insiden</h2>
                                    <p class="text-sm text-gray-600">Isi detail insiden yang terjadi.</p>
                                </div>
                            </div>
                        </header>

                        <div class="mt-6">
                            @include('insiden.form-insiden')
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <div class="w-full">
                        <header class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                            <div class="flex w-full items-center justify-start gap-4 lg:justify-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500 p-5">
                                    <p class="m-0 p-0 font-semibold leading-none text-white">3</p>
                                </div>

                                <div class="sm:flex-auto">
                                    <h2 class="text-lg font-semibold text-indigo-500">Tindakan Pasca Insiden</h2>
                                    <p class="text-sm text-gray-600">Informasi tindakan pasca insiden.</p>
                                </div>
                            </div>
                        </header>

                        <div class="mt-6">
                            @include('insiden.form-tindakan')
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <div class="w-full">
                        <header class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                            <div class="flex w-full items-center justify-start gap-4 lg:justify-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500 p-5">
                                    <p class="m-0 p-0 font-semibold leading-none text-white">4</p>
                                </div>

                                <div class="sm:flex-auto">
                                    <h2 class="text-lg font-semibold text-indigo-500">Grading Insiden</h2>
                                    <p class="text-sm text-gray-600">Grading insiden yang terjadi.</p>
                                </div>
                            </div>
                        </header>

                        <div class="mt-6">
                            @include('insiden.form-grading')
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <div class="w-full">
                        <header class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                            <div class="flex w-full items-center justify-start gap-4 lg:justify-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500 p-5">
                                    <p class="m-0 p-0 font-semibold leading-none text-white">5</p>
                                </div>

                                <div class="sm:flex-auto">
                                    <h2 class="text-lg font-semibold text-indigo-500">Kirim Laporan</h2>
                                    <p class="text-sm text-gray-600">Kirim laporan insiden yang terjadi.</p>
                                </div>
                            </div>
                        </header>

                        <div class="mt-6">
                            {{-- simple paragraf dengan inti bahwa memastikan data sudah benar --}}
                            <p class="text-sm text-gray-600">Sebelum mengirim laporan, pastikan data yang diinput sudah benar.</p>
                            <p class="text-sm text-gray-600">Informasi tambahan : Nama anda akan tercatat sebagai seseorang yang mengirimkan laporan insiden ini.</p>

                            <div class="flex items-center gap-4 mt-4">
                                <x-primary-button>Submit</x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script src="{{ asset('static/js/dataTables.js') }}"></script>
        <script src="{{ asset('static/js/dataTables.tailwindcss.js') }}"></script>

        <script src="{{ asset('static/js/dataTables.scroller.js') }}"></script>
        <script src="{{ asset('static/js/scroller.dataTables.js') }}"></script>
        <script src="{{ asset('static/js/dataTables.fixedColumns.js') }}"></script>
        <script src="{{ asset('static/js/fixedColumns.dataTables.js') }}"></script>

        <script>
            const oldValue = "{{ old('pasien_id') }}";
            console.log(oldValue);
            
            $(document).ready(function() {
                // delete-user on click get data-id
                $(document).on('click', '.delete-unit', function() {
                    $('#confirmDelete #unit').text($(this).data('unit'));
                    var url = "{{ route('unit.destroy', ':id') }}".replace(':id', $(this).data('id'));
                    confirmDelete.showModal();
                    $('#confirmDelete form').attr('action', url);
                });

                // datatable
                var table = $('#tableData').DataTable({
                    processing: true,
                    serverSide: true,

                    lengthChange: false,

                    pageLength: 10,

                    scroller: true,
                    scrollY: 300,

                    fixedColumns: {
                        leftColumns: 1,
                    },

                    ajax: {
                        url: "{{ route('datatables.pasien') }}",
                        data: function(d) {
                            d.show_deleted = $('#show_deleted').is(':checked') ? 1 : 0;
                        },
                        type: 'GET',
                    },

                    order: [
                        [2, 'DESC']
                    ],

                    columns: [{
                            data: 'nama',
                            name: 'nama',
                            render: function(data, type, row, meta) {
                                const isChecked = oldValue == row.id ? 'checked' : '';
                                return `
                                    <div class="flex lg:items-center gap-1.5">
                                        <input type="radio" name="pasien_id" value="${row.id}" ${isChecked} class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                        ${data}
                                    </div>
                                `;
                            }
                        },
                        {
                            data: 'no_rekam_medis',
                            name: 'no_rekam_medis',
                        },
                        {
                            data: 'tanggal_lahir',
                            name: 'tanggal_lahir',
                        }
                    ],

                    rowCallback: function(row, data) {
                        $(row).on('click', function(e) {
                            if (!$(e.target).is('input[type="radio"]')) {
                                $(row).find('input[type="radio"]').prop('checked', true);
                            }
                        });
                    },
                });

                // search
                $('#search').on('keyup', function() {
                    table.search(this.value).draw();
                });
            });
        </script>
    @endpush
</x-app-layout>
