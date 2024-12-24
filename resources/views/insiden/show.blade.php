<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Lihat Detail Insiden
        </h2>
    </x-slot>

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <div class="w-full">
            <header class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="text-lg font-semibold text-gray-900">Detail Insiden</h2>
                    <p class="mt-1 text-sm text-gray-600">Detail insiden {{ $insiden->tanggal_insiden?->translatedFormat('l, j F Y') }}</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a type="button" href="{{ route('insiden.index') }}" class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                        <x-icons.arrow-back class="h-5 w-5" />
                        Back
                    </a>
                </div>
            </header>

            <div class="flow-root">
                <div class="mt-8">
                    <div class="w-full">
                        <x-separator text="pasien" color="text-gray-500" />

                        <div class="mt-3">
                            <dl class="divide-y divide-gray-100">

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Nama</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $insiden->pasien->nama }}</dd>
                                </div>

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">NIK</dt>
                                    <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <kbd class="rounded-md bg-black px-1.5 py-0.5 leading-none tracking-wider text-white">{{ $insiden->pasien->nik }}</kbd>
                                    </dd>
                                </div>

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">No Rekam Medis</dt>
                                    <dd class="mt-1 text-xs leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <kbd
                                            class="rounded-md bg-black px-1.5 py-0.5 leading-none tracking-wider text-white">{{ $insiden->pasien->no_rekam_medis }}</kbd>
                                    </dd>
                                </div>

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Tempat Lahir</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $insiden->pasien->tempat_lahir }}</dd>
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
                                    <dt class="text-sm font-medium leading-6 text-gray-900">No. Telepon</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $insiden->pasien->no_telp }}</dd>
                                </div>

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Email</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <a href="mailto:{{ $insiden->pasien->email }}" class="hover:underline">{{ $insiden->pasien->email }}</a>
                                    </dd>
                                </div>

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Alamat</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $insiden->pasien->alamat }}</dd>
                                </div>

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Tanggal Masuk Pasien</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $insiden->tgl_pasien_masuk->translatedFormat('l, j F Y') }}</dd>
                                </div>

                            </dl>
                        </div>

                        <x-separator text="insiden" color="text-gray-500" />

                        <div class="mt-3 mb-5">
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
                                    <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">Dampak Insiden Terhadap Pasien</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->dampak_insiden }}</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">
                                        Orang Pertama Yang Melaporkan
                                        @if ($insiden->jenis_pelapor == 'lainnya')
                                            <p class="text-xs text-gray-500">Lainnya</p>
                                        @endif
                                    </dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">
                                        {{ $insiden->jenis_pelapor == 'lainnya' ? $insiden->jenis_pelapor_lainnya : $insiden->jenis_pelapor }}
                                    </dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">
                                        Insiden Terjadi Pada
                                        @if ($insiden->korban_insiden == 'lainnya')
                                            <p class="text-xs text-gray-500">Lainnya</p>
                                        @endif
                                    </dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">
                                        {{ $insiden->korban_insiden == 'lainnya' ? $insiden->korban_insiden_lainnya : $insiden->korban_insiden }}
                                    </dd>
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
                                    <dt class="text-sm font-medium leading-6 text-gray-900 capitalize">
                                        <p>Insiden terjadi pada pasien</p>
                                        <p class="text-xs text-gray-500">(sesuai kasus penyakit / spesialisasi)</p>
                                    </dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        @php
                                            $kasusExploded = explode(',', $insiden->kasus_insiden);
                                        @endphp

                                        <ul class="list-disc list-inside">
                                            @foreach ($kasusExploded as $kasus)
                                                @if (\Str::contains($kasus, 'lainnya'))
                                                    <li>Lainnya -- {{ $insiden->kasus_insiden_lainnya }}</li>
                                                @else
                                                    <li>{{ $kasus }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
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

                        <x-separator text="Tindakan Pasca Insiden" color="text-gray-500" />

                        <div class="mt-3 mb-5">
                            <dl class="divide-y divide-gray-100">

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Pernah Terjadi di Unit Lain </dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->pernah_terjadi ? 'Ya' : 'Tidak' }}</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Status Pelapor</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->status_pelapor }}</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Tindakan dilakukan Oleh</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">
                                        {{ $insiden->tindakan->oleh }}

                                        @if ($insiden->tindakan->oleh == 'tim')
                                            <p>{{ $insiden->tindakan->detail }}</p>
                                        @endif

                                        @if ($insiden->tindakan->oleh == 'petugas')
                                            <p>{{ $insiden->tindakan->detail }}</p>
                                        @endif
                                    </dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Tindakan Yang dilakukan</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $insiden->tindakan->tindakan }}</dd>
                                </div>

                            </dl>
                        </div>

                        <x-separator text="Grading" color="text-gray-500" />

                        <div class="mt-3 mb-5">
                            <dl class="divide-y divide-gray-100">

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Hasil Grading</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <div class="flex gap-2 items-center justify-start">
                                            @if (!$insiden?->grading)
                                                -
                                            @endif

                                            @if (\Str::lower($insiden?->grading?->grading_risiko) == 'hijau')
                                                <div class="h-3 w-3 bg-emerald-400 rounded-full"></div>
                                                {{ $insiden?->grading?->grading_risiko }}
                                            @endif

                                            @if (\Str::lower($insiden?->grading?->grading_risiko) == 'biru')
                                                <div class="h-3 w-3 bg-blue-400 rounded-full"></div>
                                                {{ $insiden?->grading?->grading_risiko }}
                                            @endif

                                            @if (\Str::lower($insiden?->grading?->grading_risiko) == 'kuning')
                                                <div class="h-3 w-3 bg-amber-400 rounded-full"></div>
                                                {{ $insiden?->grading?->grading_risiko }}
                                            @endif

                                            @if (\Str::lower($insiden?->grading?->grading_risiko) == 'merah')
                                                <div class="h-3 w-3 bg-rose-400 rounded-full"></div>
                                                {{ $insiden?->grading?->grading_risiko }}
                                            @endif

                                        </div>
                                    </dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Dilakukan Oleh</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $insiden?->grading?->user?->name ?? '-' }}</dd>
                                </div>

                            </dl>

                            @if (!$insiden?->grading)
                                @can('grading_insiden')
                                    {{-- button open modal --}}
                                    <div class="mt-4 flex justify-end">
                                        <button type="button" class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 grading-modal-button">
                                            Grading Insiden
                                        </button>
                                    </div>
                                @endcan
                            @endif
                        </div>

                        <x-separator text="Detail Laporan" color="text-gray-500" />

                        <div class="mt-3">
                            <dl class="divide-y divide-gray-100">

                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Dibuat Oleh</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->oleh->name }}</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Dibuat Pada</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->created_at?->translatedFormat('l, j F Y H:i') }}</dd>
                                </div>
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Terakhir Diubah</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 capitalize">{{ $insiden->updated_at?->translatedFormat('l, j F Y H:i') }}</dd>
                                </div>

                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('grading_insiden')
        @php
            $probability = \App\Helpers\InsidenHelper::getProbabilityLevel($insiden->jenis_insiden_id, $insiden->unit_id);
            $impact = \App\Helpers\InsidenHelper::getImpactLevel($insiden->dampak_insiden);

            $riskGrading = \App\Helpers\InsidenHelper::getRiskGrading($probability, $impact);
        @endphp

        <dialog class="modal" id="grading-modal">
            <div class="modal-box max-w-4xl">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>

                <h3 class="text-lg font-bold text-gray-700">Grading Insiden</h3>
                <p class="mt-1"> Pilih grading risiko insiden ini. Grading risiko adalah penilaian tingkat risiko insiden yang terjadi berdasarkan dampak dan keparahan insiden.</p>
                
                <div class="my-5">
                    <x-grading-info title="Auto Grading System" :riskGrading="$riskGrading">
                        <p class="text-sm font-base">Berdasarkan data yang telah diinput, sistem memberikan grading insiden ini sebagai <span class="font-bold underline capitalize grading-text">{{ \App\Helpers\InsidenHelper::riskGradingToColor($riskGrading) }}</span>.</p>
                    </x-grading-info> 
                </div>

                <div class="mt-5">
                    <form action="{{ route('grading.store') }}" method="post" id="grading-form">
                        @csrf

                        <x-text-input type="hidden" readonly name="insiden_id" :value="$insiden->id" />

                        @include('insiden.form-grading')

                        <div class="mt-5 flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                Simpan Grading
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
        
        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('.grading-modal-button').on('click', function() {
                        document.getElementById('grading-modal').showModal();
                    });
    
                    const autoGrading = $('.grading-text').text().toLowerCase();
                    const gradingRisiko = $('input[name="grading_risiko"]');

    
                    gradingRisiko.each(function() {
                        if ($(this).val() === autoGrading) {
                            $(this).prop('checked', true);
                        }
                    });

                    // grading-form on submit
                    $('#grading-form').on('submit', function(e) {
                        e.preventDefault();
                        const form = $(this);
                        const selectedGrading = form.find('input[name="grading_risiko"]:checked').val();

                        if (selectedGrading != autoGrading) {
                            document.getElementById('grading-modal').close();
                            
                            Swal.fire({
                                title: 'Konfirmasi Grading Insiden',
                                text: 'Apakah anda yakin ingin mengirim laporan insiden ini dengan grading yang berbeda dengan sistem auto grading ?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Kirim Laporan',
                                cancelButtonText: 'Batal',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form[0].submit();
                                } else {
                                    document.getElementById('grading-modal').showModal();
                                }
                            });
                        } else {
                            form[0].submit();
                        }
                    });
                });
            </script>
        @endpush
    @endcan
</x-app-layout>