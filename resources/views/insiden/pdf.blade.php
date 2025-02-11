<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PDF Print - Laporan Insiden</title>

    {{-- <link rel="stylesheet" href="{{ asset('build/assets/print.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('build/assets/pdf.css') }}">

    <style>
        body {
            font-family: 'Times New Roman', Times, serif
        }
        .dejavu {
            font-family: 'DejaVu Sans', sans-serif;
        }
    </style>
</head>

<body>
    <div class="mb-4">
        <h1 class="text-xl font-bold text-center">LAPORAN INSIDEN</h1>
        <h1 class="text-lg text-center">(INTERNAL)</h1>
    </div>

    <div class="w-full border-2 rounded-lg p-1 text-center mb-4 bg-yellow-50 border-yellow-100">
        <p class="text-center">RAHASIA, TIDAK BOLEH DIFOTOCOPY, DILAPORKAN MAKSIMAL 2 x 24 JAM</p>
    </div>

    <div class="main font-medium">
        <table class="table w-full">
            <tr>
                <td style="width: 20px;"><p class="text-lg">I.</p></td>
                <td><p class="text-lg">DATA PASIEN</p></td>
            </tr>
        </table>

        <div class="ml-6 mt-3 mb-7">
            <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                <tbody>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Nama Pasien</th>
                        <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->pasien->nama }}</td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">No. Rekam Medis</th>
                        <td class="leading-none py-2 m-0">: {{ $insiden->pasien->no_rekam_medis }}</td>
                        <th class="text-left leading-none py-2 m-0">Ruangan</th>
                        <td class="leading-none py-2 m-0">: ...................................</td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tanggal Lahir</th>
                        <td class="leading-none py-2 m-0">: {{ $insiden->pasien->tanggal_lahir->translatedFormat('d F Y') }}</td>
                        <th class="text-left leading-none py-2 m-0">Umur</th>
                        <td class="leading-none py-2 m-0">: {{ $insiden->pasien->tanggal_lahir->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan %d Hari') }}</td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Jenis Kelamin</th>
                        <td class="leading-none py-2 m-0" colspan="3"> 
                            <table class="w-fit">
                                <tr>
                                    <td style="width: 7px;">:</td>
                                    <td style="width: 200px;"><p><span class="dejavu pr-1">{!! $insiden->pasien->jenis_kelamin == 'L' ? '&#9745;' : '&#9744;' !!}</span> Laki-laki</p></td>
                                    <td style="width: 200px;"><p><span class="dejavu pr-1">{!! $insiden->pasien->jenis_kelamin == 'P' ? '&#9745;' : '&#9744;' !!}</span> Perempuan</p></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0"  style="width: 150px;">Kelompok Umur</th>
                        <td class="leading-none py-2 m-0" colspan="3"> 
                            <table class="table-auto">
                                <tbody>
                                    @foreach (\App\Helpers\UsiaHelper::kelompokUsiaData() as $key => $item)
                                        @if ($loop->index % 2 === 0)
                                            <tr>
                                        @endif
                                                <td style="width: 200px">
                                                    <p>
                                                        {{ $loop->first ? ':' : '' }} 
                                                        <span class="dejavu pr-1 {{ !$loop->first ? 'ml-2' : '' }} ">{!! \App\Helpers\UsiaHelper::getKelompokUsia($insiden->pasien->tanggal_lahir) == $key ? '&#9745;' : '&#9744;' !!}</span>
                                                        {!! $item !!}
                                                    </p>
                                                </td>
                                        @if ($loop->index % 2 === 1 || $loop->last)
                                            @if ($loop->last && $loop->index % 2 === 0)
                                                <td style="width: 200px"></td>
                                            @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0"  style="width: 150px;">Penanggung Biaya Pasien</th>
                        <td class="leading-none py-2 m-0" colspan="3"> 
                            <table class="w-fit">
                                @foreach ([
                                    'pribadi'         => 'Pribadi',
                                    'bpjs'            => 'BPJS',
                                    'asuransi_swasta' => 'Asuransi Swasta',
                                    'lainnya'         => 'Lainnya : ............................ ( sebutkan )'
                                ] as $key => $item)
                                    @if ($loop->index % 2 === 0)
                                        <tr>
                                    @endif
                                            <td style="width: {{ $loop->index % 2 === 0 ? '200px' : '300px' }}">
                                                <p>
                                                    {{ $loop->first ? ':' : '' }} 
                                                    <span class="dejavu pr-1 {{ !$loop->first ? 'ml-2' : '' }} ">{!! '&#9744;' !!}</span>
                                                    {!! $item !!}
                                                </p>
                                            </td>
                                    @if ($loop->index % 2 === 1 || $loop->last)
                                        @if ($loop->last && $loop->index % 2 === 0)
                                            <td style="width: 200px"></td>
                                        @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tanggal Masuk RS</th>
                        <td class="leading-none py-2 m-0">: {{ $insiden->tgl_pasien_masuk->translatedFormat('d F Y') }}</td>
                        <th class="text-left leading-none py-2 m-0">Jam</th>
                        <td class="leading-none py-2 m-0">: ...................................</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table class="table w-full">
            <tr>
                <td style="width: 20px;"><p class="text-lg">II.</p></td>
                <td><p class="text-lg">RINCIAN KEJADIAN</p></td>
            </tr>
        </table>

        <div class="ml-6 mt-3 mb-7">
            <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                <tbody>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Insiden</th>
                        <td class="leading-none py-2 m-0" colspan="3">: {{ $insiden->insiden }}</td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Tanggal Kejadian</th>
                        <td class="leading-none py-2 m-0">: {{ $insiden->tanggal_insiden->translatedFormat('d F Y') }}</td>
                        <th class="text-left leading-none py-2 m-0" style="width: 10px;">Jam</th>
                        <td class="leading-none py-2 m-0">: {{ $insiden->waktu_insiden }}</td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Kronologi Kejadian</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>{{ $insiden->kronologi }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Jenis Insiden</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>
                                        @foreach ([
                                            'KNC'      => 'Kejadian Nyaris Cedera / (Near miss)',
                                            'KTD'      => 'Kejadian Tidak diharapkan / (Adverse Event)',
                                            'SENTINEL' => 'Kejadian Sentinel / (Sentinel Event)',
                                            'KTC'      => 'Kejadian Tidak Cedera / (Non-Sentinel Event)',
                                            'KPC'      => 'Kejadian Potensial Cedera / (Potential Event)'
                                        ] as $key => $item)
                                            <p><span class="dejavu pr-1">{!! $insiden->jenis->alias == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Orang Pertama Yang Melaporkan</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>
                                        @foreach ([
                                            'karyawan'   => 'Karyawan (Dokter, Perawat, dll)',
                                            'pengunjung' => 'Pengunjung',
                                            'pasien'     => 'Pasien',
                                            'keluarga'   => 'Keluarga / Pendamping Pasien',
                                            'lainnya'    => 'Lainnya : ' . ($insiden->jenis_pelapor_lainnya ? $insiden->jenis_pelapor_lainnya : '............................................................................................ ( sebutkan )')
                                        ] as $key => $item)
                                            <p><span class="dejavu pr-1">{!! $insiden->jenis_pelapor == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Insiden Menyangkut Pasien</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>
                                        @foreach ([
                                            'ranap'   => 'Rawat Inap',
                                            'ralan'   => 'Rawat Jalan',
                                            'ugd'     => 'UGD',
                                            'lainnya' => 'Lainnya : ' . ($insiden->layanan_insiden_lainnya ? $insiden->layanan_insiden_lainnya : '............................................................................................ ( sebutkan )')
                                        ] as $key => $item)
                                            <p><span class="dejavu pr-1">{!! $insiden->layanan_insiden == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0" style="width: 150px;">Lokasi Kejadian</th>
                        <td class="leading-none py-2 m-0">: {{ $insiden->tempat_kejadian }}</td>
                        <th class="text-left leading-none py-2 m-0">Unit</th>
                        <td class="leading-none py-2 m-0">: {{ $insiden->unit->nama_unit }}</td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Insiden terjadi pada pasien</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            @php
                                $kasus = array_map('trim', explode(',', $insiden->kasus_insiden));
                            @endphp

                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>
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
                                        ] as $key => $item)
                                            <p><span class="dejavu pr-1">{!! in_array($item, $kasus) ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Akibat Insiden Terhadap Pasien</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>
                                        @foreach ([
                                            'katastropik'      => 'Kematian',
                                            'mayor'            => 'Cedera Irriversibel / Berat',
                                            'moderat'          => 'Cedera Reversibel / Sedang',
                                            'minor'            => 'Cedera Ringan',
                                            'tidak signifikan' => 'Tidak Cedera',
                                        ] as $key => $item)
                                            <p><span class="dejavu pr-1">{!! $insiden->dampak_insiden == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Tindakan Pasca Insiden</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td><p class="leading-5">{{ $insiden->tindakan->tindakan }}</p></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top border-b">
                        <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;">Tindakan Dilakukan Oleh</th>
                        <td class="leading-none py-2 m-0" colspan="3">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>
                                        @foreach ([
                                            'dokter'  => 'Dokter',
                                            'perawat' => 'Perawat',
                                            'petugas' => 'Petugas Lainnya : ' . ($insiden->tindakan->oleh == 'petugas' ? $insiden->tindakan->detail : '.............................................................................. ( sebutkan )'),
                                            'tim'     => 'Tim : ' . ($insiden->tindakan->oleh == 'tim' ? $insiden->tindakan->detail : '.................................................................................................. ( sebutkan )')
                                        ] as $key => $item)
                                            <p><span class="dejavu pr-1">{!! $insiden->tindakan->oleh == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="align-top">
                        <th class="text-left leading-none py-2 m-0 align-top" style="width: 150px;" colspan="3">Apakah kejadian yang sama pernah terjadi di Unit Kerja lain</th>
                        <td class="leading-none py-2 m-0" colspan="1">
                            <table class="w-fit">
                                <tr class="align-top">
                                    <td style="width: 7px;">:</td>
                                    <td>
                                        @foreach ([
                                            '1'      => 'Ya',
                                            '0'      => 'Tidak',
                                        ] as $key => $item)
                                            <p><span class="dejavu pr-1">{!! $insiden->pernah_terjadi == $key ? '&#9745;' : '&#9744;' !!}</span>{!! $item !!}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- @if ($insiden->pernah_terjadi && $terkait)
            <div class="mt-5" style="font-size: 12pt; font-weight: normal;">
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

        <table class="table w-full">
            <tr>
                <td style="width: 20px;"><p class="text-lg">III.</p></td>
                <td><p class="text-lg">GRADING RISIKO</p></td>
            </tr>
        </table>

        <div class="ml-6 mt-3">
            <table class="table w-full">
                <tr>
                    @foreach ([
                        'biru' => "blue",
                        'hijau' => "green",
                        'kuning' => "yellow",
                        'merah' => "red",
                    ] as $key => $item)
                    <td class="w-full border px-2 py-1 text-center border-{{ $item }}-500 {{ \Str::lower($insiden->grading?->grading_risiko) == $key ? 'bg-' . $item . '-500 text-white' : 'bg-white text-' . $item . '-500' }}">
                        <p class="font-bold">{{ strtoupper($key) }}</p>
                    </td>
                    @endforeach
                </tr>
            </table>

            <div class="my-8"></div>

            <table class="table w-full" style="font-size: 12pt; font-weight: normal;">
                <tr>
                    <td class="w-full">
                        <p class="font-bold">Pembuat Laporan</p>
                        <p class="text-xs">{{ $insiden->created_at?->translatedFormat('l, d F Y') }}</p>

                        @if ($insiden->created_sign)
                            <img src="data:image/png;base64,{{ $insiden->created_sign }}" alt="ttd" class="h-[100px]">
                        @else
                            <div style="padding-top: 50px; padding-bottom: 50px;"></div>
                        @endif

                        <p class="font-bold text-sm">{{ $insiden->oleh->name }}</p>
                    </td>
                    <td class="w-full">
                        <p class="font-bold">Penerima Laporan</p>
                        <p class="text-xs">{{ $insiden->received_at?->translatedFormat('d F Y') ?? '-'}}</p>

                        @if ($insiden->received_sign)
                            <img src="data:image/png;base64,{{ $insiden->received_sign }}" alt="ttd" class="h-[100px]">
                        @else
                            <div style="padding-top: 50px; padding-bottom: 50px;"></div>
                        @endif

                        <p class="font-bold">{{ $insiden->penerima->name ?? '-' }}</p>
                    </td>
                </tr>
            </table>

            {{-- <div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td class='border border-gray-400 p-2 w-[50%]'>
                                <p class="font-bold">Pembuat Laporan</p>
                                <p class="text-xs">{{ $insiden->created_at?->translatedFormat('d F Y') }}</p>
                                <div class="flex items-center justify-start load-ttd-pembuat">
                                    @if ($insiden->created_sign)
                                        <img src="{{ $insiden->created_sign }}" alt="ttd" class="h-[100px]">
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
                                    <div class="flex items-center justify-start load-ttd-penerima">
                                        @if ($insiden->received_sign)
                                            <img src="{{ $insiden->received_sign }}" alt="ttd" class="h-[100px]">
                                        @endif
                                    </div>
                                    <p class="font-bold">{{ $insiden->penerima->name ?? '-' }}</p>
                                </div>                                    
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> --}}
        </div>
    </div>
</body>

</html>