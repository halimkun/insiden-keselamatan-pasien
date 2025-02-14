<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah RCA
        </h2>
    </x-slot>

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 mb-3">
        <div class="w-full">
            <header class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                <div class="sm:flex-auto">
                    <h2 class="text-lg font-semibold text-indigo-500 leading-none">Detail Insiden</h2>
                    <p class="text-sm text-gray-600">Informasi singkat mengenai insiden yang akan di-RCA.</p>
                </div>
            </header>

            <div class="mt-4">
                <div class="mt-3 mb-5" id="insiden-detail">
                    <dl class="divide-y divide-gray-200">

                        <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">Insiden Yang Terjadi</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize flex items-center justify-between">
                                <span>{{ $insiden->insiden }}</span> 
                                <span class="font-medium uppercase">[ {{ $insiden->jenis->alias }} ] [ {{ $insiden->dampak_insiden }} ]</span>
                            </dd>
                        </div>
                        <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">Waktu Insiden</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">
                                <p>{{ $insiden->tanggal_insiden?->translatedFormat('l, j F Y') }} <span class="ml-2">{{ $insiden->waktu_insiden }}</span></p>
                            </dd>
                        </div>
                        <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">Tempat Kejadian</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->tempat_kejadian }}</dd>
                        </div>
                        <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">
                                <p>Unit / Departemen terkait</p>
                                <p class="text-xs text-gray-500">yang menyebabkan insiden</p>
                            </dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->unit->nama_unit }}</dd>
                        </div>
                        <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">Kronologi Kejadian</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->kronologi }}</dd>
                        </div>

                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 mb-3" id="1">
        <div class="w-full">
            <header class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                <div class="flex w-full items-center justify-start gap-4 lg:justify-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500 p-5">
                        <p class="m-0 p-0 font-semibold leading-none text-white">2</p>
                    </div>

                    <div class="sm:flex-auto">
                        <h2 class="text-lg font-semibold text-indigo-500 leading-none">Tentukan Tim Investigator</h2>
                        <p class="text-sm text-gray-600">Pilih tim investigator yang akan menangani RCA insiden ini.</p>
                    </div>
                </div>
            </header>

            <div class="mt-6 flex flex-col gap-4">
                <div class="w-full overflow-x-auto xl:overflow-visible">
                    <x-input-label for="ketua" value="Pilih Anggota" />
                    <table class="w-full divide-y divide-gray-300" id="tableKaryawan">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>

                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Name</th>
                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Jabatan</th>
                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Unit</th>
                            </tr>
                        </thead>
                    </table>

                    <x-input-error class="mt-2" :messages="$errors->get('anggota')" />
                </div>

                <div class="flex gap-6 flex-col">
                    <div class="flex flex-col xl:flex-row gap-4">
                        <div class="w-full">
                            <x-input-label for="ketua" value="Ketua TIM" />
                            <select name="ketua" id="ketua" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="">-- Pilih Ketua TIM --</option>
                                @foreach ($karyawan as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
        
                            <x-input-error class="mt-2" :messages="$errors->get('ketua')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="notulen" value="Notulen" />
                            <select name="notulen" id="notulen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="">-- Pilih Notulen --</option>
                                @foreach ($karyawan as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
        
                            <x-input-error class="mt-2" :messages="$errors->get('notulen')" />
                        </div>
                    </div>
                    
                    <div class="flex flex-col xl:flex-row gap-4">
                        <div class="w-full">
                            <div class="form-control rounded-lg border border-gray-200 bg-indigo-100 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-indigo-200">
                                <label class="label cursor-pointer items-center justify-between gap-2">
                                    <span class="label-text">Apakah semua area yang  terkait sudah terwakili ?</span>
                                    <input type="checkbox" name="sudah_terwakili" class="checkbox checkbox-xs rounded checked:bg-red-500" />
                                </label>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('sudah_terwakili')" />
                        </div>
                        <div class="w-full">
                            <div class="form-control rounded-lg border border-gray-200 bg-indigo-100 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-indigo-200">
                                <label class="label cursor-pointer items-center justify-between gap-2">
                                    <span class="label-text">Apakah macam-macam & tingkat pengetahuan yang berbeda, sudah diwakili didalam Tim tersebut ?</span>
                                    <input type="checkbox" name="sudah_terwakili2" class="checkbox checkbox-xs rounded checked:bg-red-500" />
                                </label>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('sudah_terwakili2')" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col xl:flex-row gap-4">
                    <div class="w-full">
                        <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                        <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full" autocomplete="tanggal_mulai" placeholder="Tanggal Mulai" />
                        <x-input-error class="" :messages="$errors->get('tanggal_mulai')" />
                    </div>
                
                    <div class="w-full">
                        <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                        <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full" autocomplete="tanggal_selesai" placeholder="Tanggal Selesai" />
                        <x-input-error class="" :messages="$errors->get('tanggal_selesai')" />
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 mb-3" id="2">
        <div class="w-full">
            <header class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                <div class="flex w-full items-center justify-start gap-4 lg:justify-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500 p-5">
                        <p class="m-0 p-0 font-semibold leading-none text-white">3</p>
                    </div>

                    <div class="sm:flex-auto">
                        <h2 class="text-lg font-semibold text-indigo-500 leading-none">Tentukan Data dan Informas</h2>
                        <p class="text-sm text-gray-600">Data sekunder (mis.berkas, rekaman CCTV) maupun primer (mis.observasi, wawancar).</p>
                    </div>
                </div>
            </header>

            <div class="mt-6 flex flex-col gap-4">
                {{-- Data Primer --}}
                <div>
                    <x-input-label for="data_primer" value="Data Primer" />
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 bg-indigo-200 rounded-md px-3 py-2.5" id="dataPrimer">
                        <div class="w-full relative">
                            <x-text-input id="data_primer" name="data_primer[]" type="text" autocomplete="data_primer" placeholder="Data Primer" class="block w-full focus:ring-0" />
                        </div>
    
                        {{-- plus button --}}
                        <div class="w-full">
                            <button type="button" class="flex items-center justify-center w-full h-10 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 gap-2" id="addDataPrimer">
                                <x-icons.circle-plus class="h-6 w-6" />
                                Tambah Data Primer
                            </button>
                        </div>
                    </div>
                    <x-input-error class="" :messages="$errors->get('data_primer')" />
                </div>
                
                {{-- Data Sekunder --}}
                <div>
                    <x-input-label for="data_sekunder" value="Data Sekunder" />
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 bg-gray-200 rounded-md px-3 py-2.5" id="dataSekunder">
                        <div class="w-full relative">
                            <x-text-input id="data_sekunder" name="data_sekunder[]" type="text" autocomplete="data_sekunder" placeholder="Data Sekunder" class="block w-full focus:ring-0" />
                        </div>
    
                        {{-- plus button --}}
                        <div class="w-full">
                            <button type="button" class="flex items-center justify-center w-full h-10 bg-gray-500 text-white rounded-lg hover:bg-gray-600 gap-2" id="addDataSekunder">
                                <x-icons.circle-plus class="h-6 w-6" />
                                Tambah Data Sekunder
                            </button>
                        </div>
                    </div>
                    <x-input-error class="" :messages="$errors->get('data_sekunder')" />
                </div>

                {{-- Data Lainnya --}}
                <div>
                    <x-input-label for="data_lainnya" value="Data Lainnya" />
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 bg-gray-200 rounded-md px-3 py-2.5" id="dataLainnya">
                        <div class="w-full relative">
                            <x-text-input id="data_lainnya" name="data_lainnya[]" type="text" autocomplete="data_lainnya" placeholder="Data Lainnya" class="block w-full focus:ring-0" />
                        </div>
    
                        {{-- plus button --}}
                        <div class="w-full">
                            <button type="button" class="flex items-center justify-center w-full h-10 bg-gray-500 text-white rounded-lg hover:bg-gray-600 gap-2" id="addDataLainnya">
                                <x-icons.circle-plus class="h-6 w-6" />
                                Tambah Data Lainnya
                            </button>
                        </div>
                    </div>
                    <x-input-error class="" :messages="$errors->get('data_lainnya')" />
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    {{-- using public url --}}
    <link rel="stylesheet" href="{{ asset('static/css/dataTables.tailwindcss.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.4.3/css/scroller.dataTables.css">

    <script src="{{ asset('static/js/dataTables.js') }}"></script>
    <script src="{{ asset('static/js/dataTables.tailwindcss.js') }}"></script>
    <script src="https://cdn.datatables.net/scroller/2.4.3/js/dataTables.scroller.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.4.3/js/scroller.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/3.0.0/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/3.0.0/js/select.dataTables.js"></script>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
            
                $("#addDataPrimer").click(function () {
                    let newInput = `
                        <div class="w-full relative bg-white rounded-lg border border-gray-300">
                            <x-text-input name="data_primer[]" type="text" autocomplete="data_primer" placeholder="Data Primer" class="block w-[calc(100%-2rem)] border-0 shadow-none focus:ring-0" />
                            <button type="button" class="absolute text-gray-500 hover:text-red-500 top-1/2 right-1.5 transform -translate-y-1/2 removeDataPrimer">
                                <x-icons.circle-x class="h-6 w-6" />
                            </button>
                        </div>`;

                    $(this).parent().before(newInput);

                    // focus to the new input
                    $(this).parent().prev().find('input').focus();
                });

                $("#dataPrimer").on("click", ".removeDataPrimer", function () {
                    $(this).parent().remove();
                });
                


                $("#addDataSekunder").click(function () {
                    let newInput = `
                        <div class="w-full relative bg-white rounded-lg border border-gray-300">
                            <x-text-input name="data_primer[]" type="text" autocomplete="data_primer" placeholder="Data Sekunder" class="block w-[calc(100%-2rem)] border-0 shadow-none focus:ring-0" />
                            <button type="button" class="absolute text-gray-500 hover:text-red-500 top-1/2 right-1.5 transform -translate-y-1/2 removeDataSekunder">
                                <x-icons.circle-x class="h-6 w-6" />
                            </button>
                        </div>`;

                    $(this).parent().before(newInput);

                    // focus to the new input
                    $(this).parent().prev().find('input').focus();
                });

                $("#dataSekunder").on("click", ".removeDataSekunder", function () {
                    $(this).parent().remove();
                });

                var table = $('#tableKaryawan').DataTable({
                    paging: true,
                    processing: true,
                    searching: false,
                    serverSide: true,
                    deferRender: true,
                    lengthChange: false,

                    scrollCollapse: true,
                    scroller: true,
                    select: {
                        style: 'multi',
                    },
                    
                    scrollY: 300,
                    pageLength: 10,

                    ajax: {
                        url: "{{ route('datatables.users') }}",
                        data: function(d) {
                            d.show_deleted = $('#show_deleted').is(':checked') ? 1 : 0;
                        },
                        type: 'GET'
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
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'detail.jabatan.nama',
                            name: 'detail.jabatan.nama',
                        },
                        {
                            data: 'detail.unit.nama_unit',
                            name: 'detail.unit.nama_unit',
                        },
                    ],
                });
            
            });
        </script>
    @endpush
</x-app-layout>