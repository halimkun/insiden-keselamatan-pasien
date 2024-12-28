<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = new \App\Models\Settings();

        $data = [
            'site_name'        => 'Insiden Keselamatan Pasien',
            'site_description' => 'Solusi praktis untuk mencatat dan menilai risiko insiden demi meningkatkan keselamatan pasien',
            'site_logo'        => 'logo.png',

            'faskes_name'      => 'RSUD Daerah Sini',
            'faskes_address'   => 'Jl. Mayjen Prof. Dr. Moestopo No.6-8, Airlangga, Kec. Gubeng, Kota SBY, Jawa Timur 60286',
        ];

        foreach ($data as $key => $value) {
            $model->create([
                'key'   => $key,
                'value' => $value,
            ]);
        }
    }
}
