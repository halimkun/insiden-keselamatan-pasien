<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Investigasi
        </h2>
    </x-slot>

    <div class="flex flex-col 2xl:flex-row items-start gap-3">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg w-full 2xl:w-2/5 sticky top-0">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Detail Insiden</h1>
                        <p class="mt-2 text-sm text-gray-700">Informasi Singkat Insiden Rumah Sakit</p>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8">
                        <div class="py-2 align-middle">
                            @foreach ([
                                "Insiden Yang Terjadi" => $insiden->insiden,
                                "Tanggal Insiden" => \Carbon\Carbon::parse($insiden->tanggal_insiden)->isoFormat('ddd, D MMM Y') . " " . $insiden->waktu_insiden . " WIB",
                                "Jenis Insiden" => $insiden->jenis->nama_jenis_insiden . " ( " . $insiden->jenis->alias . " ) ",
                                "Nama Pasien" => $insiden->pasien->nama,
                                "Nomor Rekam Medis" => $insiden->pasien->no_rekam_medis,
                                "Tanggal Lahir" => \Carbon\Carbon::parse($insiden->pasien->tanggal_lahir)->isoFormat('D MMMM Y'),
                                "Usia" => \Carbon\Carbon::parse($insiden->pasien->tanggal_lahir)->age . " Tahun",
                                "Jenis Kelamin" => $insiden->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                            ] as $label => $value)
                                <div class="{{ $loop->last ? '' : 'mb-3' }}">
                                    <p class="text-gray-700 text-sm font-base">{{ $label }}</p>
                                    <p class="text-gray-900 font-medium">{{ $value }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg w-full">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Buat Investigasi</h1>
                        <p class="mt-2 text-sm text-gray-700">Buat investigasi insiden rumah sakit.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" href="{{ route('investigasi.index') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                            <x-icons.arrow-back class="h-5 w-5" />
                            Kembali
                        </a>
                    </div>
                </div>
    
                <div class="flow-root">
                    <div class="mt-8">
                        <div class="py-2 align-middle">
                            <div class="mb-6">
                                <div class="border-2 border-gray-400 bg-gray-200 rounded-lg">
                                    <div class="p-4">
                                        <h1 class="text-base font-semibold leading-3 text-gray-900">Kronologi</h1>
                                        <p class="mt-2 text-sm text-gray-700">{{ $insiden->kronologi }}</p>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('insiden.investigasi.store', $insiden->id) }}" role="form"
                                enctype="multipart/form-data">
                                @csrf
    
                                @include('investigasi.form')

                                <div class="flex items-center justify-end gap-4 mt-10">
                                    <x-primary-button>Submit</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>