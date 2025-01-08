<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nama"           => $this->faker->name,
            "nik"            => $this->faker->nik,
            "no_rekam_medis" => $this->faker->randomNumber(8),
            "tempat_lahir"   => $this->faker->city,
            "tanggal_lahir"  => $this->faker->date(),
            "jenis_kelamin"  => $this->faker->randomElement(["L", "P"]),
            "no_telp"        => $this->faker->phoneNumber,
            "email"          => $this->faker->email,
            "alamat"         => $this->faker->address,
        ];
    }
}
