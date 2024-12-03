<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PasienData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===== ===== ===== ===== =====  Pasien
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i <= rand(18, 25); $i++) {
            \App\Models\Pasien::create([
                'nama'           => $faker->name,
                'nik'            => $faker->nik,
                'no_rekam_medis' => $faker->unique()->randomNumber(8),
                'tempat_lahir'   => $faker->city,
                'tanggal_lahir'  => $faker->date,
                'jenis_kelamin'  => $faker->randomElement(['L', 'P']),
                'no_telp'        => $faker->phoneNumber,
                'email'          => $faker->email,
                'alamat'         => $faker->address,
            ]);
        }
    }
}
