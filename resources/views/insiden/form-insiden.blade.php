<div class="space-y-6">

    <div class="w-full">
        <x-input-label for="tgl_pasien_masuk" value="Tanggal Pasien Masuk" />
        <x-text-input id="tgl_pasien_masuk" name="tgl_pasien_masuk" type="date" class="mt-1 block w-full" :value="old('tgl_pasien_masuk', $insiden?->tgl_pasien_masuk?->format('Y-m-d'))" autocomplete="tgl_pasien_masuk" placeholder="Tanggal Insiden" />

        <x-input-error class="mt-2" :messages="$errors->get('tgl_pasien_masuk')" />
    </div>

    <div class="flex gap-3">
        <div class="w-full">
            <x-input-label for="tanggal_insiden" :value="__('Tanggal Insiden')" />
            <x-text-input id="tanggal_insiden" name="tanggal_insiden" type="date" class="mt-1 block w-full" :value="old('tanggal_insiden', $insiden?->tanggal_insiden?->format('Y-m-d'))" autocomplete="tanggal_insiden" placeholder="Tanggal Insiden" />

            <x-input-error class="mt-2" :messages="$errors->get('tanggal_insiden')" />
        </div>
        <div class="w-full">
            @php
                $waktuInsiden = explode(':', $insiden?->waktu_insiden);
                if (count($waktuInsiden) >= 2) {
                    $waktuInsiden = $waktuInsiden[0] . ':' . $waktuInsiden[1];
                } else {
                    $waktuInsiden = '';
                }
            @endphp

            <x-input-label for="waktu_insiden" :value="__('Jam Insiden')" />
            <x-text-input id="waktu_insiden" name="waktu_insiden" type="time" class="mt-1 block w-full" :value="old('waktu_insiden', $waktuInsiden)" autocomplete="waktu_insiden" placeholder="Waktu Insiden" />

            <x-input-error class="mt-2" :messages="$errors->get('waktu_insiden')" />
        </div>
    </div>

    <div class="w-full">
        <x-input-label for="insiden" value="Insiden Yang Terjadi" />
        <x-text-input id="insiden" name="insiden" type="text" class="mt-1 block w-full" :value="old('insiden', $insiden?->insiden)" autocomplete="insiden" placeholder="misal: pasien jatuh, lupa memberikan obat, dll" />

        <x-input-error class="mt-2" :messages="$errors->get('insiden')" />
    </div>

    <div class="w-full">
        <x-input-label for="kronologi" :value="__('Kronologi')" />
        <textarea id="kronologi" name="kronologi" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" autocomplete="kronologi" placeholder="Kronologi insiden">{{ old('kronologi', $insiden?->kronologi) }}</textarea>

        <x-input-error class="mt-2" :messages="$errors->get('kronologi')" />
    </div>

    <div class="w-full">
        <x-input-label for="jenis_insiden_id" value="Jenis Insiden" />
        <div class="mt-1 grid grid-cols-2 gap-3 lg:grid-cols-3">
            @foreach ($jenisInsiden as $jenis)
                <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="radio" value="{{ $jenis->id }}" {{ old('jenis_insiden_id', $insiden?->jenis_insiden_id) == $jenis->id ? 'checked' : '' }} name="jenis_insiden_id" class="radio radio-xs checked:bg-red-500" />
                        <span class="label-text">{{ $jenis->nama_jenis_insiden }} / {{ $jenis->alias }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        
        <x-input-error class="mt-2" :messages="$errors->get('jenis_insiden_id')" />
    </div>

    <div class="w-full">
        <x-input-label for="jenis_pelapor" value="Orang Pertama Yang Melaporkan" />
        <div class="mt-1 grid grid-cols-2 gap-3 lg:grid-cols-3">
            @foreach ([
                'karyawan' => 'Karyawan (Dokter, Perawat, dll)',
                'pengunjung' => 'Pengunjung',
                'pasien' => 'Pasien',
                'keluarga' => 'Keluarga / Pendamping Pasien',
                'lainnya' => 'Lainnya ',
            ] as $value => $label)
                <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                    <label class="label cursor-pointer items-center justify-start gap-2">
                        <input type="radio" value="{{ $value }}" {{ old('jenis_pelapor', $insiden?->jenis_pelapor) == $value ? 'checked' : '' }} name="jenis_pelapor" class="radio radio-xs checked:bg-red-500" />
                        <span class="label-text">{{ $label }}</span>
                    </label>
                </div>
            @endforeach

        </div>

        <div class="mt-3 w-full hidden p-3 rounded-lg bg-indigo-50 px-4" id="jenis_pelapor_lainnya_wrapper">
            <x-input-label for="jenis_pelapor_lainnya" value="Jenis Pelapor Lainnya" />
            <x-text-input id="jenis_pelapor_lainnya" name="jenis_pelapor_lainnya" type="text" class="w-full" :value="old('jenis_pelapor_lainnya', $insiden?->jenis_pelapor_lainnya)" autocomplete="jenis_pelapor_lainnya" placeholder="Jenis Pelapor Lainnya" />
            <x-input-error class="mt-2" :messages="$errors->get('jenis_pelapor_lainnya')" />
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('jenis_pelapor')" />
    </div>

    <div class="w-full">
        <x-input-label for="korban_insiden" value="Insiden terjadi pada" />
        <div class="mt-1 grid grid-cols-2 items-center lg:grid-cols-3 gap-3">
            @foreach ([
                'pasien' => 'Pasien',
                'lainnya' => 'Lainnya ',
            ] as $value => $label)
                <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                    <label class="label cursor-pointer items-center justify-start gap-2">
                        <input type="radio" value="{{ $value }}" {{ old('korban_insiden', $insiden?->korban_insiden) == $value ? 'checked' : '' }} name="korban_insiden" class="radio radio-xs checked:bg-red-500" />
                        <span class="label-text">{{ $label }}</span>
                    </label>
                </div>
            @endforeach
        </div>

        <div class="mt-3 w-full hidden p-3 rounded-lg bg-indigo-50 px-4" id="korban_insiden_lainnya_wrapper">
            <x-input-label for="korban_insiden_lainnya" value="Korban Insiden Lainnya" />
            <x-text-input id="korban_insiden_lainnya" name="korban_insiden_lainnya" type="text" class="w-full" :value="old('korban_insiden_lainnya', $insiden?->korban_insiden_lainnya)" autocomplete="korban_insiden_lainnya" placeholder="Korban Insiden Lainnya" />
            <x-input-error class="mt-2" :messages="$errors->get('korban_insiden_lainnya')" />
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('korban_insiden')" />
    </div>

    <div class="w-full">
        <x-input-label for="layanan_insiden" value="Insiden Menyangkut Pasien" />
        <div class="mt-1 grid grid-cols-2 items-center lg:grid-cols-3 gap-3">
            @foreach ([
                'ranap' => 'Rawat Inap',
                'ralan' => 'Rawat Jalan',
                'ugd' => 'UGD',
                'lainnya' => 'Lainnya ',
            ] as $value => $label)
                <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                    <label class="label cursor-pointer items-center justify-start gap-2">
                        <input type="radio" value="{{ $value }}" {{ old('layanan_insiden', $insiden?->layanan_insiden) == $value ? 'checked' : '' }} name="layanan_insiden" class="radio radio-xs checked:bg-red-500" />
                        <span class="label-text">{{ $label }}</span>
                    </label>
                </div>
            @endforeach
        </div>

        <div class="mt-3 w-full hidden p-3 rounded-lg bg-indigo-50 px-4" id="layanan_insiden_lainnya_wrapper">
            <x-input-label for="layanan_insiden_lainnya" value="Layanan Insiden Lainnya" />
            <x-text-input id="layanan_insiden_lainnya" name="layanan_insiden_lainnya" type="text" class="w-full" :value="old('layanan_insiden_lainnya', $insiden?->layanan_insiden_lainnya)" autocomplete="layanan_insiden_lainnya" placeholder="Layanan Insiden Lainnya" />
            <x-input-error class="mt-2" :messages="$errors->get('layanan_insiden_lainnya')" />
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('layanan_insiden')" />
    </div>

    <div class="w-full">
        @php
            $kasusArray = array_map('trim', explode(',', $insiden?->kasus_insiden));
        @endphp

        <x-input-label for="kasus_insiden" value="Insiden terjadi pada pasien ( sesuai kasus penyakit / spesialisasi )" />
        <div class="mt-1 grid grid-cols-2 items-start lg:grid-cols-3 gap-3">
            @foreach ([
                'Penyakit Dalam dan Subspesialiasinya',
                'Anak dan Subspesialiasinya',
                'Bedah dan Subspesialiasinya',
                'Obstetri Gynekologi dan Subspesialiasinya',
                'THT dan Subspesialiasinya',
                'Mata dan Subspesialiasinya',
                'Safar dan Subspesialiasinya',
                'Anastesi dan Subspesialiasinya',
                'Kulit & Kelamin dan Subspesialiasinya',
                'Jantung dan Subspesialiasinya',
                'Paru Dalam dan Subspesialiasinya',
                'Jiwa Dalam dan Subspesialiasinya',
                'Orthopedi Dalam dan Subspesialiasinya'
            ] as $kasus)
                <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                    <label class="label cursor-pointer items-center justify-start gap-2">
                        <input type="checkbox" value="{{ $kasus }}" name="kasus_insiden[]" class="checkbox checkbox-xs rounded checked:bg-red-500" {{ in_array($kasus, old('kasus_insiden', $kasusArray)) ? 'checked' : '' }} />
                        <span class="label-text">{{ $kasus }}</span>
                    </label>
                </div>
            @endforeach

            <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                <label class="label cursor-pointer items-center justify-start gap-2 p-0.5 m-0">
                    <input type="checkbox" value="lainnya" name="kasus_insiden[]" class="checkbox checkbox-xs rounded checked:bg-red-500" {{ in_array('lainnya', old('kasus_insiden', [])) ? 'checked' : '' }} {{ in_array('lainnya', $kasusArray) ? 'checked' : '' }} />
                    <x-text-input id="kasus_insiden_lainnya" name="kasus_insiden_lainnya" type="text" class="input-sm w-full" :value="old('kasus_insiden_lainnya', $insiden?->kasus_insiden_lainnya)" autocomplete="kasus_insiden_lainnya" placeholder="Kasus Insiden Lainnya" />
                </label>
                <div class="ml-7">
                    <x-input-error class="mt-1" :messages="$errors->get('kasus_insiden_lainnya')" />
                </div>
            </div>
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('kasus_insiden')" />
    </div>

    <div class="flex flex-col gap-3 lg:flex-row">
        <div class="w-full">
            <x-input-label for="tempat_kejadian" :value="__('Tempat Kejadian')" />
            <x-text-input id="tempat_kejadian" name="tempat_kejadian" type="text" class="mt-1 block w-full" :value="old('tempat_kejadian', $insiden?->tempat_kejadian)" autocomplete="tempat_kejadian" placeholder="Tempat Kejadian" />

            <x-input-error class="mt-2" :messages="$errors->get('tempat_kejadian')" />
        </div>

        <div class="w-full">
            <x-input-label for="unit_id" value="Unit / Departemen terkait yang menyebabkan insiden" />
            <select id="unit_id" name="unit_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">-- Pilih Unit --</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id', $insiden?->unit_id) == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                @endforeach
            </select>

            <x-input-error class="mt-2" :messages="$errors->get('unit_id')" />
        </div>
    </div>

    <div class="w-full">
        <x-input-label for="dampak_insiden" value="Dampak Insiden Terhadap Pasien" />
        <div class="mt-1 grid grid-cols-2 gap-3 lg:grid-cols-3">
            @foreach ([
                'kematian' => 'Kematian',
                'cedera berat' => 'Cedera Irriversibel / Berat',
                'cedera sedang' => 'Cedera Reversibel / Sedang',
                'cedera ringan' => 'Cedera Ringan',
                'tidak cedera' => 'Tidak Cedera',
            ] as $value => $label)
                <div class="form-control rounded-lg border border-gray-200 p-0.5 px-3 transition-all duration-300 ease-in-out hover:bg-gray-200">
                    <label class="label cursor-pointer items-center justify-start gap-2">
                        <input type="radio" value="{{ $value }}" {{ old('dampak_insiden', $insiden?->dampak_insiden) == $value ? 'checked' : '' }} name="dampak_insiden" class="radio radio-xs checked:bg-red-500" />
                        <span class="label-text">{{ $label }}</span>
                    </label>
                </div>
            @endforeach
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('dampak_insiden')" />
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Jenis Insiden
            $('input[name="jenis_insiden_id"]').on('change', function() {
                $('input[name="jenis_insiden_id"]').parent().parent().removeClass('bg-indigo-100 hover:bg-indigo-200');

                if ($(this).is(':checked')) {
                    $(this).parent().parent().addClass('bg-indigo-100 hover:bg-indigo-200');
                }
            });

            // Jenis Pelapor
            if ($('input[name="jenis_pelapor"]:checked').val() === 'lainnya') {
                $('#jenis_pelapor_lainnya_wrapper').removeClass('hidden');
            }

            $('input[name="jenis_pelapor"]').on('change', function() {
                $('input[name="jenis_pelapor"]').parent().parent().removeClass('bg-indigo-100 hover:bg-indigo-200');

                if ($(this).is(':checked')) {
                    $(this).parent().parent().addClass('bg-indigo-100 hover:bg-indigo-200');
                }

                if ($(this).val() === 'lainnya') {
                    $('#jenis_pelapor_lainnya_wrapper').removeClass('hidden');
                } else {
                    $('#jenis_pelapor_lainnya_wrapper').addClass('hidden');
                }
            });

            // Korban Insiden
            if ($('input[name="korban_insiden"]:checked').val() === 'lainnya') {
                $('#korban_insiden_lainnya_wrapper').removeClass('hidden');
            }

            $('input[name="korban_insiden"]').on('change', function() {
                $('input[name="korban_insiden"]').parent().parent().removeClass('bg-indigo-100 hover:bg-indigo-200');

                if ($(this).is(':checked')) {
                    $(this).parent().parent().addClass('bg-indigo-100 hover:bg-indigo-200');
                }

                if ($(this).val() === 'lainnya') {
                    $('#korban_insiden_lainnya_wrapper').removeClass('hidden');
                } else {
                    $('#korban_insiden_lainnya_wrapper').addClass('hidden');
                }
            });

            // Layanan Insiden
            if ($('input[name="layanan_insiden"]:checked').val() === 'lainnya') {
                $('#layanan_insiden_lainnya_wrapper').removeClass('hidden');
            }

            $('input[name="layanan_insiden"]').on('change', function() {
                $('input[name="layanan_insiden"]').parent().parent().removeClass('bg-indigo-100 hover:bg-indigo-200');
                
                if ($(this).is(':checked')) {
                    $(this).parent().parent().addClass('bg-indigo-100 hover:bg-indigo-200');
                }

                if ($(this).val() === 'lainnya') {
                    $('#layanan_insiden_lainnya_wrapper').removeClass('hidden');
                } else {
                    $('#layanan_insiden_lainnya_wrapper').addClass('hidden');
                }
            });

            // Dampak Insiden
            $('input[name="dampak_insiden"]').on('change', function() {
                $('input[name="dampak_insiden"]').parent().parent().removeClass('bg-indigo-100 hover:bg-indigo-200');

                if ($(this).is(':checked')) {
                    $(this).parent().parent().addClass('bg-indigo-100 hover:bg-indigo-200');
                }
            });

            // Kasus Insiden
            if ($('input[name="kasus_insiden[]"]:checked').val() === 'lainnya') {
                $('#kasus_insiden_lainnya').removeClass('hidden');
            }
            
            $('input[name="kasus_insiden[]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).parent().parent().addClass('bg-indigo-100 hover:bg-indigo-200');
                } else {
                    $(this).parent().parent().removeClass('bg-indigo-100 hover:bg-indigo-200');
                }
            });
        });
    </script>
@endpush
