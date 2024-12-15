<x-app-layout>

    <x-slot name="header">
        <h2 class="flex items-center gap-3 text-xl font-semibold leading-tight text-gray-800">
            <x-icons.alert-triangle class="h-5 w-5" />
            Tambah Insiden
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('insiden.store') }}" role="form" enctype="multipart/form-data">
        @csrf
        <div
            class="bg-white p-4 shadow sm:rounded-lg sm:p-8 {{ request('act') == 'tambah' ? 'border border-amber-500' : '' }}">
            <div class="w-full">
                <header class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                    <div class="flex w-full items-center justify-start gap-4 lg:justify-center">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full {{ request('act') == 'tambah' ? 'bg-amber-500' : 'bg-indigo-500' }} p-5">
                            <p class="m-0 p-0 font-semibold leading-none text-white">1</p>
                        </div>

                        <div class="sm:flex-auto">
                            <h2
                                class="text-lg font-semibold {{ request('act') == 'tambah' ? 'text-amber-500' : 'text-indigo-500' }}">
                                {{ request('act') == 'tambah' ? "Tambah" : "Pilih" }} Pasien
                            </h2>
                            <p class="text-sm text-gray-600">{{ request('act') == 'tambah' ? "Tambah" : "Pilih" }}
                                pasien yang terkait dengan insiden.</p>
                        </div>
                    </div>

                    {{-- back --}}
                    @if (request('act') == 'tambah')
                    <a href="{{ route('insiden.create') }}"
                        class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                        <x-icons.arrow-back class="h-5 w-5" />
                        <span>Kembali</span>
                    </a>
                    @endif
                </header>

                <div class="mt-6">
                    @if (request('step') > 1 && request('act') != 'tambah')
                    <input type="hidden" class="mb-4" readonly name="pasien_id"
                        value="{{ request('step') > 1 ? old('pasien_id', $pasien?->id) : null }}" />
                    @endif

                    @if (request('act') == 'tambah')
                    <input type="hidden" name="act" value="tambah" />
                    <div class="flex flex-col md:flex-row items-start gap-4">
                        <div class="w-full">
                            <x-input-label for="no_rekam_medis" :value="__('No Rekam Medis')" />
                            <x-text-input id="no_rekam_medis" name="no_rekam_medis" type="text"
                                class="mt-1 block- w-full" :value="old('no_rekam_medis', $pasien?->no_rekam_medis)"
                                autocomplete="no_rekam_medis" placeholder="No Rekam Medis" inputmode="numeric" />

                            <x-input-error class="mt-2" :messages="$errors->get('no_rekam_medis')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="nama" :value="__('Nama')" />
                            <x-text-input class="w-full mt-1" id="nama" type="text" name="nama" label="Nama"
                                value="{{ request('step') > 1 ? old('nama', $pasien?->nama) : null }}"
                                placeholder="Nama" />

                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('jenis_kelamin', $pasien?->jenis_kelamin) == 'L' ? 'selected' :
                                    '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $pasien?->jenis_kelamin) == 'P' ? 'selected' :
                                    '' }}>Perempuan</option>
                            </select>


                            <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                        </div>
                    </div>

                    <div class="mt-4 flex flex-col md:flex-row items-start gap-4">
                        <div class="w-full">
                            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                            <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full"
                                :value="old('tempat_lahir', $pasien?->tempat_lahir)" autocomplete="tempat_lahir"
                                placeholder="Nama pasien" />

                            <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full"
                                :value="old('tanggal_lahir', $pasien?->tanggal_lahir?->format('Y-m-d'))"
                                autocomplete="tanggal_lahir" placeholder="Tanggal Lahir" />

                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="nik" value="Nomor KTP" />
                            <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full"
                                :value="old('nik', $pasien?->nik)" autocomplete="nik" placeholder="Nama pasien" />

                            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                        </div>
                    </div>

                    <div class="mt-4 flex flex-col md:flex-row gap-6">
                        <div class="w-full">
                            <x-input-label for="no_telp" :value="__('No Telepon')" />
                            <x-text-input id="no_telp" name="no_telp" type="text" class="mt-1 block w-full"
                                :value="old('no_telp', $pasien?->no_telp)" autocomplete="no_telp"
                                placeholder="No Telepon" inputmode="numeric" />

                            <x-input-error class="mt-2" :messages="$errors->get('no_telp')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email', $pasien?->email)" autocomplete="email" placeholder="Email" />

                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="alamat" :value="__('Alamat')" />
                        <textarea name="alamat" id="alamat"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                            placeholder="Alamat">{{ old('alamat', $pasien?->alamat) }}</textarea>

                        <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                    </div>
                    @else
                    <div class="flex items-start gap-4">
                        <div class="w-full max-w-xs">
                            <x-input-label for="no_rekam_medis" :value="__('No Rekam Medis')" />
                            <x-combobox-pasien-async @pasien-selected="handleSelectedResult"
                                rm="{{ request('step') > 1 ? old('no_rekam_medis', $pasien?->no_rekam_medis) : null }}" />
                            <p class="text-sm text-gray-600 mt-1">
                                Cari atau tambah pasien baru.
                            </p>
                        </div>

                        <div class="w-full">
                            <x-input-label for="nama" :value="__('Nama')" />
                            <x-text-input class="w-full mt-1" id="nama" type="text" name="nama" label="Nama"
                                value="{{ request('step') > 1 ? old('nama', $pasien?->nama) : null }}"
                                :readonly="request('act') != 'tambah'" placeholder="Nama" />
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 mt-4">
                        <x-text-input class="flex-2" id="dob" type="text" name="dob" label="Tanggal Lahir"
                            value="{{ request('step') > 1 ? old('tanggal_lahir', $pasien?->tanggal_lahir->format('Y-m-d')) : null }}"
                            readonly placeholder="Tanggal Lahir" />
                        <x-text-input class="flex-1" id="dob" type="text" name="dob" label="Usia"
                            value="{{ request('step') > 1 ? old('tanggal_lahir', $pasien?->tanggal_lahir->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan %d Hari')) : null }}"
                            readonly placeholder="Usia" />
                        <x-text-input class="flex-1" id="gender" type="text" name="gender" label="Gender"
                            value="{{ request('step') > 1 ? old('jenis_kelamin', $pasien?->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') : null }}"
                            readonly placeholder="gender" />
                    </div>
                    @endif

                    <x-input-error class="mt-2" :messages="$errors->get('pasien_id')" />
                </div>
            </div>
        </div>

        @if (request('step') > 1)
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

                    {{-- submit button --}}
                    <div class="flex items-center gap-4 mt-4">
                        <x-primary-button>Submit</x-primary-button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </form>

    @push('scripts')
    <script src="{{ asset('static/js/dataTables.js') }}"></script>
    <script src="{{ asset('static/js/dataTables.tailwindcss.js') }}"></script>

    <script>
        const oldValue = "{{ old('pasien_id') }}";
            $(document).ready(function() {
                // delete-user on click get data-id
                $(document).on('click', '.delete-unit', function() {
                    $('#confirmDelete #unit').text($(this).data('unit'));
                    var url = "{{ route('unit.destroy', ':id') }}".replace(':id', $(this).data('id'));
                    confirmDelete.showModal();
                    $('#confirmDelete form').attr('action', url);
                });
            });
    </script>
    @endpush
</x-app-layout>