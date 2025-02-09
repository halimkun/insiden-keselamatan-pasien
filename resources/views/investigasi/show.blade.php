<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $investigasi->name ?? __('Show') . " " . __('Investigasi') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="w-full">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Show') }} Investigasi</h1>
                    <p class="mt-2 text-sm text-gray-700">Details of {{ __('Investigasi') }}.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a type="button" href="{{ route('investigasi.index') }}" class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                        <x-icons.arrow-back class="h-5 w-5" />
                        Back
                    </a>
                </div>
            </div>

            <div class="flow-root">
                <div class="mt-8 overflow-x-auto">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <x-separator text="pasien" color="text-gray-500" />

                        <div class="mt-6" id="pasien-detail">
                            <dl class="divide-y divide-gray-100">

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Nama</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $insiden->pasien->nama }}</dd>
                                </div>

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">No Rekam Medis</dt>
                                    <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <kbd
                                            class="rounded-md bg-black px-1.5 py-0.5 leading-none tracking-wider text-white">{{ $insiden->pasien->no_rekam_medis }}</kbd>
                                    </dd>
                                </div>

                                <div class="items-start px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Tanggal Lahir</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <p class="leading-6">{{ $insiden->pasien->tanggal_lahir->format('d F Y') }}</p>
                                        <p class="text-[0.8rem] font-semibold leading-none">{{ $insiden->pasien->tanggal_lahir->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan %d Hari') }}</p>
                                    </dd>
                                </div>

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Jenis Kelamin</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        @if ($insiden->pasien->jenis_kelamin == 'P')
                                            Perempuan
                                        @elseif($insiden->pasien->jenis_kelamin == 'L')
                                            Laki-laki
                                        @endif
                                    </dd>
                                </div>

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Tanggal Masuk Pasien</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $insiden->tgl_pasien_masuk->translatedFormat('l, j F Y') }}</dd>
                                </div>

                            </dl>
                        </div>

                        <x-separator text="insiden" color="text-gray-500 my-6" />

                        <div id="insiden-detail">
                            <dl class="divide-y divide-gray-200">

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">Insiden Yang Terjadi</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->insiden }}</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">Waktu Insiden</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">
                                        <p>{{ $insiden->tanggal_insiden?->translatedFormat('l, j F Y') }}</p>
                                        <p>{{ $insiden->waktu_insiden }}</p>
                                    </dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">Jenis Insiden</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->jenis->nama_jenis_insiden }} ({{ $insiden->jenis->alias }})</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">
                                        Insiden Menyangkut Pasien
                                        @if ($insiden->layanan_insiden == 'lainnya')
                                            <p class="text-xs text-gray-500">Lainnya</p>
                                        @endif
                                    </dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">
                                        @if ($insiden->layanan_insiden == 'ranap')
                                            Rawat Inap
                                        @endif

                                        @if ($insiden->layanan_insiden == 'ralan')
                                            Rawat Jalan
                                        @endif

                                        @if ($insiden->layanan_insiden == 'ugd')
                                            Unit Gawat Darurat (UGD)
                                        @endif

                                        @if ($insiden->layanan_insiden == 'lainnya')
                                            {{ $insiden->layanan_insiden_lainnya }}
                                        @endif
                                    </dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">Kronologi Kejadian</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->kronologi }}</dd>
                                </div>

                            </dl>
                        </div>

                        <x-separator text="Investigasi" color="text-gray-500 my-6" />

                        <div id="investigasi-detail">
                            <dl class="divide-y divide-gray-100">
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Penyebab Langsung</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $investigasi->penyebab_langsung }}</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Penyebab Awal</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $investigasi->penyebab_awal }}</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Tanggal Investigasi</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 flex items-center justify-start">
                                        {{ $investigasi->tanggal_mulai }}
                                        <span class="mx-2 font-semibold">s/d</span>
                                        {{ $investigasi->tanggal_selesai }}
                                    </dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Tanggal Pengesahan</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $investigasi->tanggal_pengesahan }}</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <x-badges.investigasi-status :investigasi="$investigasi" />
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <x-separator text="Rekomendasi" color="text-gray-500 my-6" />

                        <div id="investigasi-detail">
                            <dl class="divide-y divide-gray-100">
                                @foreach ($investigasi->rekomendasi as $item)
                                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Rekomendasi Jangka {{ $item->jangka_waktu }}</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                            <p>{{ $item->rekomendasi }}</p>

                                            <div class="mt-2">
                                                <p  class="leading-4 text-xs"><span class="font-semibold">Batas Waktu : </span> {{ \Carbon\Carbon::parse($item->batas_waktu)->translatedFormat('l, j F Y') }}</p>
                                                <p  class="leading-4 text-xs"><span class="font-semibold">Penanggung Jawab : </span> {{ $item->penanggungJawab->name }}</p>
                                            </div>
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
