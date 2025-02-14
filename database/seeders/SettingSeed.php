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
        $faker = \Faker\Factory::create('id_ID');

        $data = [
            'site_name'        => 'Insiden Keselamatan Pasien',
            'site_description' => 'Solusi praktis untuk mencatat dan menilai risiko insiden demi meningkatkan keselamatan pasien',
            'site_logo'        => 'images/logo.png',

            'faskes_name'      => 'Nama Fasilitas Kesehatan',
            'faskes_address'   => $faker->address,
        ];

        foreach ($data as $key => $value) {
            $model->create([
                'key'   => $key,
                'value' => $value,
            ]);
        }
    }
}
