<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update') }} Insiden
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('insiden.update', $insiden->id) }}" role="form" enctype="multipart/form-data" class="flex flex-col gap-4 lg:gap-8">
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
                    <input type="hidden" class="mb-4" readonly name="pasien_id" value="{{ old('pasien_id', $insiden?->pasien?->id) }}" />

                    <div class="flex flex-col md:flex-row items-start gap-4">
                        <x-text-input 
                            readonly
                            class="w-full md:w-auto flex-2" 
                            id="no_rekam_medis" 
                            type="text" 
                            name="no_rekam_medis"
                            label="No. Rekam Medis"
                            placeholder="No. Rekam Medis" 
                            value="{{ old('no_rekam_medis', $insiden?->pasien?->no_rekam_medis) }}" 
                        />
                        <x-text-input 
                            readonly 
                            class="w-full md:w-auto flex-1" 
                            id="nama" 
                            type="text" 
                            name="nama" 
                            label="Nama"
                            placeholder="Nama"
                            value="{{ old('nama', $insiden?->pasien?->nama) }}" 
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('no_rekam_medis')" />
                    </div>
                    <div class="flex flex-col md:flex-row items-start gap-4 mt-4">
                        <x-text-input 
                            readonly 
                            class="w-full md:w-auto flex-2" 
                            id="dob" 
                            type="text" 
                            name="dob" 
                            label="DOB"
                            placeholder="DOB" 
                            value="{{ old('tanggal_lahir', $insiden?->pasien?->tanggal_lahir->format('Y-m-d')) }}"
                        />
                        <x-text-input 
                            readonly 
                            class="w-full md:w-auto flex-1" 
                            id="dob" 
                            type="text" 
                            name="dob" 
                            label="DOB"
                            placeholder="DOB"
                            value="{{ old('tanggal_lahir', $insiden?->pasien?->tanggal_lahir->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan %d Hari')) }}"
                        />
                        <x-text-input 
                            readonly 
                            class="w-full md:w-auto flex-2" 
                            id="gender" 
                            type="text" 
                            name="gender" 
                            label="Gender"
                            placeholder="gender"
                            value="{{ old('jenis_kelamin', $insiden?->pasien?->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') }}"
                        />
                        <x-text-input 
                            readonly 
                            class="w-full md:w-auto flex-1" 
                            id="gender" 
                            type="text" 
                            name="gender" 
                            label="Gender"
                            placeholder="Gender"
                            value="{{ old('jenis_kelamin', $insiden?->pasien?->penanggungBiaya->jenis_penanggung) }}"
                        />
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

        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8" id="grading-insiden">
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

                <div id="auto-grading">
                    @php
                        $probability = \App\Helpers\InsidenHelper::getProbabilityLevel($insiden->jenis_insiden_id, $insiden->unit_id);
                        $impact = \App\Helpers\InsidenHelper::getImpactLevel($insiden->dampak_insiden);
    
                        $riskGrading = \App\Helpers\InsidenHelper::getRiskGrading($probability, $impact);
                    @endphp
    
                    <div class="mt-6">
                        <x-grading-info title="Auto Grading System" :riskGrading="$riskGrading" :jenis_insiden_id="old('jenis_insiden_id', $insiden?->jenis_insiden_id)" :unit_id="old('unit_id', $insiden?->unit_id)">
                            <p class="text-sm font-base">Berdasarkan data yang telah diinput, sistem memberikan grading insiden ini sebagai <span class="font-bold underline capitalize grading-text">{{ \App\Helpers\InsidenHelper::riskGradingToColor($riskGrading) }}</span>.</p>
                            <p class="text-xs font-base">Perhitungan grading insiden ini dilakukan dengan rumus: <kbd class="bg-gray-800 rounded px-1.5 text-white font-semibold">SKOR RISIKO = DAMPAK x PROBABILITAS</kbd>. Dengan nilai <span class="font-bold">probabilitas</span> sebesar <kbd class="bg-gray-800 rounded px-1.5 text-white font-semibold">{{ $probability }}</kbd> dan <span class="font-bold">dampak</span> sebesar <kbd class="bg-gray-800 rounded px-1.5 text-white font-semibold">{{ $impact }}</kbd>, maka <span class="font-bold">skor risiko</span> adalah <kbd class="bg-gray-800 rounded px-1.5 text-white font-semibold">{{ $probability * $impact }}</kbd>.</p>
                        </x-grading-info>                    
                    </div>
                </div>

                @can('grading_insiden')
                    <div class="mt-6">
                        @include('insiden.form-grading')
                    </div>
                @endcan
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
                            <h2 class="text-lg font-semibold text-indigo-500">Validasi & Kirim Laporan</h2>
                            <p class="text-sm text-gray-600">Anda diharuskan untuk memvalidasi data yang telah diinput sebelum mengirim laporan.</p>
                        </div>
                    </div>
                </header>

                <div class="mt-4">
                    <canvas id="signature-pad" class="signature-pad border" width="460" height="150"></canvas>
                    <input type="text" hidden name="created_sign" id="created_sign" class="signature-pad-input" value="{{ old('created_sign', $insiden->created_sign) }}">

                    {{-- button clear and validasi --}}
                    <div class="flex items-center gap-4 mt-4">
                        <button type="button" id="clear" class="btn btn-sm btn-danger">Clear</button>
                    </div>
                </div>

                <div class="mt-4">
                    <x-input-label for="investigasi_sederhana" value="Investigasi Sederhana" />
                    <textarea name="investigasi_sederhana" id="investigasi_sederhana" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="investigasi sederhana">{{ old('investigasi_sederhana', $insiden?->investigasi_sederhana) }}</textarea>
                
                    <x-input-error class="mt-2" :messages="$errors->get('investigasi_sederhana')" />
                </div>

                <div class="mt-6">
                    <p class="text-sm text-gray-600">Sebelum mengirim laporan, pastikan data yang diinput sudah benar.</p>
                    <p class="text-sm text-gray-600">Informasi tambahan : Nama anda akan tercatat sebagai seseorang yang mengirimkan laporan insiden ini.</p>

                    <div class="flex items-center gap-4 mt-4">
                        <x-primary-button>Submit</x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            function checkAndSubmit() {
                // Ambil semua nilai dari elemen input
                const jenisInsiden = $('input[name="jenis_insiden_id"]:checked').val();
                const unitId = $('#unit_id').val();
                const dampakInsiden = $('input[name="dampak_insiden"]:checked').val();

                // Periksa apakah semua nilai sudah terisi
                if (jenisInsiden && unitId && dampakInsiden) {
                    console.log('Semua nilai sudah terisi');
                    
                    // AJAX request
                    $.ajax({
                        url: '{{ route("grading.by-data") }}', // Ganti dengan endpoint Anda
                        method: 'POST',
                        data: {
                            jenis_id: jenisInsiden,
                            unit_id: unitId,
                            impact: dampakInsiden,
                            _token: $('meta[name="csrf-token"]').attr('content') // Tambahkan CSRF token jika diperlukan
                        },
                        success: function (response) {
                            $('#auto-grading').html("<div class='mt-6'>" + response.html + "</div>");
                            $('input[name="grading_risiko"]').each(function() {
                                if ($(this).val() == response.color) {
                                    $(this).prop('checked', true);
                                }
                            });
                        },
                        error: function (xhr) {
                            console.error('Request gagal:', xhr);
                        }
                    });
                } else {
                    console.log('Tunggu, semua nilai belum terisi');
                }
            }
            
            function checkInsidenTerkait() {
                if (!$('input[name="jenis_insiden_id"]:checked').val()) {
                    return;
                }

                $.ajax({
                    url: '{{ route("insiden.get-terkait") }}', // Ganti dengan endpoint Anda
                    method: 'POST',
                    data: {
                        jenis_insiden_id: $('input[name="jenis_insiden_id"]:checked').val(),
                        unit_id: $('#unit_id').val(),
                        _token: $('meta[name="csrf-token"]').attr('content') // Tambahkan CSRF token jika diperlukan
                    },
                    success: function (response) {
                        $('#insiden-terkait').html(response.html);
                        $('input[name="pernah_terjadi"]').each(function() {
                            if ($(this).val() == response.pernah_terjadi_unit_lain) {
                                $(this).prop('checked', true);
                            }
                        });
                    },
                    error: function (xhr) {
                        console.error('Request gagal:', xhr);
                    }
                });
            }

            $(document).ready(function() {
                const insidenData = @json($insiden);

                // Signature Pad
                const canvas = document.querySelector("canvas");
                const clearButton = document.getElementById('clear');
                const signaturePad = new SignaturePad(canvas, {
                    penColor: 'rgb(0, 0, 0)',
                    backgroundColor: 'rgb(255, 255, 255)',
                    minWidth: 0.5,
                    maxWidth: 2,
                    throttle: 16,
                    minDistance: 0,
                    velocityFilterWeight: 0.9,
                });

                clearButton.addEventListener('click', function() {
                    signaturePad.clear();
                    $('input[name="created_sign"]').val('');
                });

                if (insidenData.created_sign) {
                    signaturePad.fromDataURL(insidenData.created_sign);
                }

                // =================
                const savedGrading = '{{ old('grading_risiko', $insiden?->grading?->grading_risiko) }}';
                const autoGrading = $('.grading-text').text().toLowerCase();
                const gradingRisiko = $('input[name="grading_risiko"]');

                if (!savedGrading && autoGrading) {
                    gradingRisiko.each(function() {
                        if ($(this).val() === autoGrading) {
                            $(this).prop('checked', true);
                        }
                    });
                } else {
                    gradingRisiko.each(function() {
                        if ($(this).val() === savedGrading) {
                            $(this).prop('checked', true);
                        }
                    });
                }

                $('input[name="jenis_insiden_id"], #unit_id, input[name="dampak_insiden"]').on('change', checkAndSubmit);

                // form submit prevent
                $('form').submit(function(e) {
                    e.preventDefault();
                    const form = $(this);

                    // check if signature is empty
                    if (signaturePad.isEmpty()) {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Tanda tangan anda tidak boleh kosong',
                            icon: 'warning',
                        });
                        return;
                    }

                    // fill the signature input
                    $('input[name="created_sign"]').val(signaturePad.toDataURL());

                    // if selected grading is same with auto grading show confirm dialog
                    if ($('input[name="grading_risiko"]:checked').val() != autoGrading) {
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
                            }
                        });
                    } else {
                        form[0].submit();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>