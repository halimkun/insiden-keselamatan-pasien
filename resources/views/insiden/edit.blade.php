<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update') }} Insiden
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('insiden.update', $insiden->id) }}" role="form" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
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
                </header>

                <div class="mt-6">
                    <input type="hidden" class="mb-4" readonly name="pasien_id"
                        value="{{ old('pasien_id', $insiden?->pasien?->id) }}" />

                    <div class="flex gap-4">
                        <x-text-input class="flex-2" id="no_rekam_medis" type="text" name="no_rekam_medis"
                            label="No. Rekam Medis"
                            value="{{ old('no_rekam_medis', $insiden?->pasien?->no_rekam_medis) }}" readonly
                            placeholder="No. Rekam Medis" />
                        <x-text-input class="flex-1" id="nama" type="text" name="nama" label="Nama"
                            value="{{ old('nama', $insiden?->pasien?->nama) }}" readonly placeholder="Nama" />

                        <x-input-error class="mt-2" :messages="$errors->get('no_rekam_medis')" />
                    </div>
                    <div class="flex gap-4 mt-4">
                        <x-text-input class="flex-2" id="dob" type="text" name="dob" label="DOB"
                            value="{{ old('tanggal_lahir', $insiden?->pasien?->tanggal_lahir->format('Y-m-d')) }}"
                            readonly placeholder="DOB" />
                        <x-text-input class="flex-1" id="dob" type="text" name="dob" label="DOB"
                            value="{{ old('tanggal_lahir', $insiden?->pasien?->tanggal_lahir->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan %d Hari')) }}"
                            readonly placeholder="DOB" />
                        <x-text-input class="flex-1" id="gender" type="text" name="gender" label="Gender"
                            value="{{ old('jenis_kelamin', $insiden?->pasien?->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') }}"
                            readonly placeholder="gender" />
                    </div>

                    <x-input-error class="mt-2" :messages="$errors->get('pasien_id')" />
                </div>
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
                    <p class="text-sm text-gray-600">Sebelum mengirim laporan, pastikan data yang diinput sudah benar.
                    </p>
                    <p class="text-sm text-gray-600">Informasi tambahan : Nama anda akan tercatat sebagai seseorang yang
                        mengirimkan laporan insiden ini.</p>

                    <div class="flex items-center gap-4 mt-4">
                        <x-primary-button>Submit</x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>