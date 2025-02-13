<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\JenisInsiden;
use App\Models\PenanggungBiaya;
use Illuminate\Database\Seeder;

class MasterData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ======================================== Unit
        $units = [
            'Casemix',
            'Farmasi',
            'Radiologi',
            'Nifas',
            'Gizi',
            'Kamar Operasi',
            'Patologi',
            'Laundry',
            'Laboratorium',
            'Persalinan',
            'Perinatologi',
            "UGD / IGD",
            "Poliklinik",
            "Rekam Medis",
            "Keuangan Dan Akuntansi",
            "Sistem Informasi Dan Teknologi",
            "IPSRS",
            "VK"
        ];

        sort($units);

        foreach ($units as $unit) {
            Unit::create(['nama_unit' => $unit]);
        }

        // ======================================== Penanggung Biaya
        $penanggungBiaya = [
            'BPJS Kesehatan',
            'Jamkesda',
            'Umum / Pribadi',
            'Asuransi Swasta',
            'Pemerintah',
            'Perusahaan',
            'Lain-Lain'
        ];

        foreach ($penanggungBiaya as $biaya) {
            PenanggungBiaya::create(['jenis_penanggung' => $biaya]);
        }

        // ======================================== Jenis Insiden
        $jenisInsiden = [
            [
                "alias" => "KPC",
                "nama_jenis_insiden" =>  "Kejadian Potensial Cedera",
            ],
            [
                "alias" => "KNC",
                "nama_jenis_insiden" =>  "Kejadian Nyaris Cedera",
            ],
            [
                "alias" => "KTC",
                "nama_jenis_insiden" =>  "Kejadian Tidak Cedera",
            ],
            [
                "alias" => "KTD",
                "nama_jenis_insiden" =>  "Kejadian Tidak Diharapkan",
            ],
            [
                "alias" => "SENTINEL",
                "nama_jenis_insiden" =>  "Kejadian Sentinel"
            ],
        ];

        foreach ($jenisInsiden as $jenisInsiden) {
            JenisInsiden::create($jenisInsiden);
        }
    }
}
