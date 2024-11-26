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
            'Radiologi',
            'Nifas'
        ];

        foreach ($units as $unit) {
            Unit::create(['nama_unit' => $unit]);
        }

        // ======================================== Penanggung Biaya
        $penanggungBiaya = [
            'BPJS Kesehatan',
            'Mandiri Health',
            'Asuransi Sinar Mas'
        ];

        foreach ($penanggungBiaya as $biaya) {
            PenanggungBiaya::create(['jenis_penanggung' => $biaya]);
        }

        // ======================================== Jenis Insiden
        $jenisInsiden = [
            'Kejadian Potensial Cedera',
            'Kejadian Nyaris Cedera',
            'Kejadian Tidak Cedera',
            'Kejadian Tidak Diharapkan',
            'Kejadian Sentinel'
        ];

        foreach ($jenisInsiden as $jenisInsiden) {
            JenisInsiden::create(['nama_jenis_insiden' => $jenisInsiden]);
        }
    }
}
