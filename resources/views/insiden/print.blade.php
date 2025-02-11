<x-app-layout>
    {{-- button generate pdf --}}
    <div class="flex items-center justify-end mb-4 max-w-[215mm] lg:mx-auto">
        <a href="{{ route('insiden.pdf', $insiden->id) }}" class="bg-primary flex gap-2 items-center justify-center px-4 py-2 rounded-lg font-medium shadow text-sm text-white">
            <x-icons.print class="h-4 w-4" />
            PDF
        </a>
    </div>

    <div class="f4 bg-white lg:mx-auto shadow-lg rounded-lg text-gray-800">
        <div class="mb-4">
            <h1 class="text-xl font-bold text-center">LAPORAN INSIDEN</h1>
            <h1 class="text-xl font-bold text-center">(INTERNAL)</h1>
        </div>

        <div class="w-full border-2 rounded-lg p-1 text-center mb-4 bg-yellow-50 border-yellow-100">
            <p class="font-bold text-center">RAHASIA, TIDAK BOLEH DIFOTOCOPY, DILAPORKAN MAKSIMAL 2 x 24 JAM</p>
        </div>

        <div class="main font-medium">
            <div class="section flex gap-3">
                <div class="w-6">
                    <p class="font-bold">I.</p>
                </div>
                <p class="font-bold">DATA PASIEN</p>
            </div>

            <div class="ml-9 mt-3 mb-7">
                <table class="table">
                    <tbody>
                        <tr class="">
                            <th class="leading-none py-2 m-0 w-[160px]">Nama Pasien</th>
                            <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->pasien->nama }}</td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 w-[160px]">No. Rekam Medis</th>
                            <td class="leading-none py-2 m-0">: {{ $insiden->pasien->no_rekam_medis }}</td>
                            <th class="leading-none py-2 m-0">Ruangan</th>
                            <td class="leading-none py-2 m-0">: ...................................</td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 w-[160px]">Tanggal Lahir</th>
                            <td class="leading-none py-2 m-0">: {{ $insiden->pasien->tanggal_lahir->translatedFormat('d F Y') }}</td>
                            <th class="leading-none py-2 m-0">Umur</th>
                            <td class="leading-none py-2 m-0">: {{ $insiden->pasien->tanggal_lahir->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan %d Hari') }}</td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 w-[160px]">Jenis Kelamin</th>
                            <td class="leading-none py-2 m-0" colspan="3"> 
                                <div class="inline-flex gap-1">
                                    : <div class="inline-flex gap-4">
                                        <div class="flex gap-2">
                                            {!! $insiden->pasien->jenis_kelamin == 'L' ? '&#128505;' : '&#9744;' !!}
                                            <p>Laki-laki</p>
                                        </div>
                                        <div class="flex gap-2">
                                            {!! $insiden->pasien->jenis_kelamin == 'P' ? '&#128505;' : '&#9744;' !!}
                                            <p>Perempuan</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class=" align-top">
                            <th class="leading-none py-2 m-0 w-[160px] align-top">Kelompok Umur</th>
                            <td class="leading-none py-2 m-0" colspan="3"> 
                                <div class="inline-flex gap-1">
                                    : <div class="grid grid-cols-2 gap-2 gap-x-6">
                                        @foreach (\App\Helpers\UsiaHelper::kelompokUsiaData() as $key => $item)
                                            <div class="flex gap-2">
                                                {!! \App\Helpers\UsiaHelper::getKelompokUsia($insiden->pasien->tanggal_lahir) == $key ? '&#128505;' : '&#9744;' !!}
                                                <p>{!! $item !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class=" align-top">
                            <th class="leading-none py-2 m-0 w-[160px] align-top">Penanggung Biaya Pasien</th>
                            <td class="leading-none py-2 m-0" colspan="3"> 
                                <div class="inline-flex gap-1">
                                    : <div class="grid grid-cols-2 gap-2 gap-x-6">
                                        @foreach ([
                                            'pribadi'         => 'Pribadi',
                                            'bpjs'            => 'BPJS',
                                            'asuransi_swasta' => 'Asuransi Swasta',
                                            'lainnya'         => 'Lainnya : <br /><br /> ............................ ( sebutkan )'
                                        ] as $key => $item)
                                            <div class="flex gap-2">
                                                {!! '&#9744;' !!}
                                                <p>{!! $item !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 w-[160px]">Tanggal Masuk RS</th>
                            <td class="leading-none py-2 m-0">: {{ $insiden->tgl_pasien_masuk->translatedFormat('d F Y') }}</td>
                            <th class="leading-none py-2 m-0">Jam</th>
                            <td class="leading-none py-2 m-0">: ...................................</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="section flex gap-3">
                <div class="w-6">
                    <p class="font-bold">II.</p>
                </div>
                <p class="font-bold">RINCIAN KEJADIAN</p>
            </div>

            <div class="ml-9 mt-3 mb-7">
                <table class="table">
                    <tbody>
                        <tr class="">
                            <th class="leading-none py-2 m-0 w-[160px]">Insiden</th>
                            <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->insiden }}</td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 w-[160px]">Tanggal Kejadian</th>
                            <td class="leading-none py-2 m-0">: {{ $insiden->tanggal_insiden->translatedFormat('d F Y') }}</td>
                            <th class="leading-none py-2 m-0">Jam</th>
                            <td class="leading-none py-2 m-0">: {{ $insiden->waktu_insiden }}</td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 align-top w-[160px]">Kronologi Kejadian</th>
                            <td class="leading-none py-2 m-0" colspan="3">
                                <div class="inline-flex gap-1">
                                    : <p class="leading-5">{{ $insiden->kronologi }}</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 align-top w-[160px]">Jenis Insiden</th>
                            <td class="leading-none py-2 m-0" colspan="3">
                                <div class="inline-flex gap-1">
                                    : <div class="grid grid-cols-1 gap-2 gap-x-6">
                                        @foreach ([
                                            'KNC'      => 'Kejadian Nyaris Cedera / (Near miss)',
                                            'KTD'      => 'Kejadian Tidak diharapkan / (Adverse Event)',
                                            'SENTINEL' => 'Kejadian Sentinel / (Sentinel Event)',
                                            'KTC'      => 'Kejadian Tidak Cedera / (Non-Sentinel Event)',
                                            'KPC'      => 'Kejadian Potensial Cedera / (Potential Event)'
                                        ] as $key => $item)
                                            <div class="flex gap-2">
                                                {!! $insiden->jenis->alias == $key ? '&#128505;' : '&#9744;' !!}
                                                <p>{!! $item !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 align-top w-[160px]">Orang Pertama Yang Melaporkan</th>
                            <td class="leading-none py-2 m-0" colspan="3">
                                <div class="inline-flex gap-1">
                                    : <div class="grid grid-cols-1 gap-2 gap-x-6">
                                        @foreach ([
                                            'karyawan'   => 'Karyawan (Dokter, Perawat, dll)',
                                            'pengunjung' => 'Pengunjung',
                                            'pasien'     => 'Pasien',
                                            'keluarga'   => 'Keluarga / Pendamping Pasien',
                                            'lainnya'    => 'Lainnya : ' . ($insiden->jenis_pelapor_lainnya ? $insiden->jenis_pelapor_lainnya : '......................................................................... ( sebutkan )')
                                        ] as $key => $item)
                                            <div class="flex gap-2">
                                                {!! $insiden->jenis_pelapor == $key ? '&#128505;' : '&#9744;' !!}
                                                <p>{!! $item !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 align-top w-[160px]">Insiden Menyangkut Pasien</th>
                            <td class="leading-none py-2 m-0" colspan="3">
                                <div class="inline-flex gap-1">
                                    : <div class="grid grid-cols-1 gap-2 gap-x-6">
                                        @foreach ([
                                            'ranap'   => 'Rawat Inap',
                                            'ralan'   => 'Rawat Jalan',
                                            'ugd'     => 'UGD',
                                            'lainnya' => 'Lainnya : ' . ($insiden->layanan_insiden_lainnya ? $insiden->layanan_insiden_lainnya : '......................................................................... ( sebutkan )')
                                        ] as $key => $item)
                                            <div class="flex gap-2">
                                                {!! $insiden->layanan_insiden == $key ? '&#128505;' : '&#9744;' !!}
                                                <p>{!! $item !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 w-[160px]">Lokasi Kejadian</th>
                            <td class="leading-none py-2 m-0">: {{ $insiden->tempat_kejadian }}</td>
                            <th class="leading-none py-2 m-0">Unit</th>
                            <td class="leading-none py-2 m-0">: {{ $insiden->unit->nama_unit }}</td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 align-top w-[160px]">Insiden terjadi pada pasien</th>
                            <td class="leading-none py-2 m-0" colspan="3">
                                @php
                                    $kasus = array_map('trim', explode(',', $insiden->kasus_insiden));
                                @endphp

                                <div class="inline-flex gap-1">
                                    : <div class="grid grid-cols-1 gap-2 gap-x-6">
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
                                            'Paru dan Subspesialiasinya',
                                            'Jiwa dan Subspesialiasinya',
                                            'Orthopedi dan Subspesialiasinya'
                                        ] as $item)
                                            <div class="flex gap-2">
                                                {!! in_array($item, $kasus) ? '&#128505;' : '&#9744;' !!}
                                                <p>{!! $item !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 align-top w-[160px]">Akibat Insiden Terhadap Pasien</th>
                            <td class="leading-none py-2 m-0" colspan="3">
                                <div class="inline-flex gap-1">
                                    : <div class="grid grid-cols-1 gap-2 gap-x-6">
                                        @foreach ([
                                            'katastropik'      => 'Kematian',
                                            'mayor'            => 'Cedera Irriversibel / Berat',
                                            'moderat'          => 'Cedera Reversibel / Sedang',
                                            'minor'            => 'Cedera Ringan',
                                            'tidak signifikan' => 'Tidak Cedera',
                                        ] as $key => $item)
                                            <div class="flex gap-2">
                                                {!! $insiden->dampak_insiden == $key ? '&#128505;' : '&#9744;' !!}
                                                <p>{!! $item !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 align-top w-[160px]">Tindakan Pasca Insiden</th>
                            <td class="leading-none py-2 m-0" colspan="3">
                                <div class="inline-flex gap-1">
                                    : <p class="leading-5">{{ $insiden->tindakan->tindakan }}</p>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 align-top w-[160px]">Tindakan Dilakukan Oleh</th>
                            <td class="leading-none py-2 m-0" colspan="3">
                                <div class="inline-flex gap-1">
                                    : <div class="grid grid-cols-1 gap-2 gap-x-6">
                                        @foreach ([
                                            'dokter'  => 'Dokter',
                                            'perawat' => 'Perawat',
                                            'petugas' => 'Petugas Lainnya : ' . ($insiden->tindakan->oleh == 'petugas' ? $insiden->tindakan->detail : '........................................................... ( sebutkan )'),
                                            'tim'     => 'Tim : ' . ($insiden->tindakan->oleh == 'tim' ? $insiden->tindakan->detail : '................................................................................ ( sebutkan )')
                                        ] as $key => $item)
                                            <div class="flex gap-2">
                                                {!! $insiden->tindakan->oleh == $key ? '&#128505;' : '&#9744;' !!}
                                                <p>{!! $item !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <th class="leading-none py-2 m-0 align-top w-[160px]" colspan="3">Apakah kejadian yang sama pernah terjadi di Unit Kerja lain</th>
                            <td class="leading-none py-2 m-0" colspan="1">
                                <div class="inline-flex gap-1">
                                    : <div class="grid grid-cols-2 gap-2 gap-x-2">
                                        @foreach ([
                                            '1'      => 'Ya',
                                            '0'      => 'Tidak',
                                        ] as $key => $item)
                                            <div class="flex gap-2">
                                                {!! $insiden->pernah_terjadi == $key ? '&#128505;' : '&#9744;' !!}
                                                <p>{!! $item !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- @if ($insiden->pernah_terjadi && $terkait)
                <div class="mt-5">
                    <p class="font-bold mb-3">Insiden Terkait Yang Terjadi Pada Unit Kerja Lain.</p>
                    @foreach ($terkait as $item)
                    <div class="px-4 py-2 border rounded-lg {{ $loop->last ? '' : 'mb-3' }}" style="background-color: #f7f7f7;">
                        <h3 class="font-bold">{{ $item->insiden }}</h3>
                        <p class="text-xs">{{ $item->tanggal_insiden->translatedFormat('d F Y') }} | {{ $item->waktu_insiden }}</p>
                        <hr class="my-2">
                        <p class="text-sm">{{ $item->tindakan->tindakan }}</p>
                    </div>
                    @endforeach
                </div>
                @endif --}}
            </div>

            <div class="section flex gap-3">
                <div class="w-6">
                    <p class="font-bold">III.</p>
                </div>
                <p class="font-bold">GRADING RISIKO</p>
            </div>

            <div class="ml-9 mt-3">
                <div class="flex gap-3 w-full">
                    @foreach ([
                        'biru' => "blue",
                        'hijau' => "green",
                        'kuning' => "yellow",
                        'merah' => "red",
                    ] as $key => $item)
                    <div class="w-full border rounded-lg px-2 py-1 text-center border-{{ $item }}-500 {{ \Str::lower($insiden->grading?->grading_risiko) == $key ? 'bg-' . $item . '-500 text-white' : 'bg-white text-' . $item . '-500' }}">
                        <p class="font-bold">{{ strtoupper($key) }}</p>
                    </div>
                    @endforeach
                </div>

                <hr class="my-5">

                <div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class='border border-gray-400 p-2 w-[50%]'>
                                    <p class="font-bold">Pembuat Laporan</p>
                                    <p class="text-xs">{{ $insiden->created_at?->translatedFormat('d F Y') }}</p>
                                    <div class="{{ $insiden->created_sign ? '' : 'my-5' }} flex items-center justify-start load-ttd-pembuat">
                                        @if ($insiden->created_sign)
                                            <img src="{{ $insiden->created_sign }}" alt="ttd" class="h-[100px]">
                                        @else
                                            <button class="btn btn-xs btn-primary btn-ttd-pembuat">Beri Tanda Tangan</button>
                                        @endif
                                    </div>
                                    <p class="font-bold">{{ $insiden->oleh->name }}</p>
                                </td>
                                <td class='border border-gray-400 p-2 w-[50%]'>
                                    <div class="flex flex-col h-full justify-between">
                                        <div>
                                            <p class="font-bold">Penerima Laporan</p>
                                            <p class="text-xs">{{ $insiden->received_at?->translatedFormat('d F Y') ?? '-'}}</p>
                                        </div>
                                        <div class="{{ $insiden->received_sign ? '' : 'my-5' }} flex items-center justify-start load-ttd-penerima">
                                            @if ($insiden->received_sign)
                                                <img src="{{ $insiden->received_sign }}" alt="ttd" class="h-[100px]">
                                            @else
                                                <button class="btn btn-xs btn-primary btn-ttd-penerima">Beri Tanda Tangan</button>
                                            @endif
                                        </div>
                                        <p class="font-bold">{{ $insiden->penerima->name ?? '-' }}</p>
                                    </div>                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <dialog id="signPadModal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold leading-none">Tanda Tangan <span class="siapa"></span></h3>
            <p class="mb-4 mt-1">Buat tanda tangan anda dibawah ini</p>

            <canvas id="signature-pad" class="signature-pad border" width="460" height="150"></canvas>

            <div class="modal-action flex items-center justify-between gap-2">
                {{-- clear button --}}
                <button class="btn btn-sm py-2 px-4" id="clear">Clear</button>
                
                <div class="flex gap-2">
                    <form method="dialog">
                        <!-- if there is a button in form, it will close the modal -->
                        <button class="btn btn-sm py-2 px-4 btn-ghost">Close</button>
                    </form>
                    <form method="post" id="form-ttd" action="{{ route('insiden.ttd', $insiden->id) }}">
                        @csrf
                        <input type="hidden" name="ttd" id="ttd">
                        <input type="hidden" name="type">
                        <button class="btn btn-sm py-2 px-4 btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </dialog>

    @push('scripts')
    <script>
        $(document).ready(function() {
            const canvas = document.querySelector("canvas");
            const signaturePad = new SignaturePad(canvas, {
                penColor: 'rgb(0, 0, 0)',
                backgroundColor: 'rgb(255, 255, 255)',
                minWidth: 0.5,
                maxWidth: 2,
                throttle: 16,
                minDistance: 0,
                velocityFilterWeight: 0.9,
            });

            const signPadModal = document.getElementById('signPadModal');
            const clearButton = document.getElementById('clear');

            clearButton.addEventListener('click', function() {
                signaturePad.clear();
            });

            $('.btn-ttd-pembuat').on('click', function() {
                signPadModal.showModal();
                signPadModal.querySelector('.siapa').innerText = 'Pembuat Laporan';
                signPadModal.querySelector('#form-ttd input[name="type"]').value = 'pembuat';
            });

            $('.btn-ttd-penerima').on('click', function() {
                signPadModal.showModal();
                signPadModal.querySelector('.siapa').innerText = 'Penerima Laporan';
                signPadModal.querySelector('#form-ttd input[name="type"]').value = 'penerima';
            });

            // form submit
            signPadModal.querySelector('#form-ttd').addEventListener('submit', function(e) {
                e.preventDefault();
                const ttd = signaturePad.toDataURL();
                signPadModal.querySelector('#ttd').value = ttd;

                const formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        signPadModal.close();
                        Swal.showLoading();
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.close();

                            Swal.fire({
                                icon: 'success',
                                title: 'Success !',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                const data = response.data;
                                if (formData.get('type') == 'pembuat') {
                                    $('.load-ttd-pembuat').html(`<img src="${data.created_sign}" alt="ttd" class="h-[100px]">`);
                                    $('.load-ttd-pembuat').closest('div').removeClass('my-5');
                                } else {
                                    // $('.load-ttd-penerima').html(`<img src="${data.received_sign}" alt="ttd" class="h-[100px]">`);
                                    location.reload()
                                }
                            })
                        }
                    },
                    complete: function () {
                        signaturePad.clear();
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: response.responseJSON.message || 'Something went wrong.',
                            showConfirmButton: true,
                            timer: 2000
                        }).then(() => {
                            signPadModal.showModal();
                        });
                    }
                });

            });
        });
    </script>
    @endpush
</x-app-layout>