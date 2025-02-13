<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetail>
 */
class UserDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $units      = \App\Models\Unit::inRandomOrder()->first();
        $unit_id    = $units->id;
        $departemen = $units->nama_unit;

        $jabatan    = \App\Models\Jabatan::where('nama', 'like', "%$departemen%")
            ->whereNot('nama', 'Kepala Unit Sistem Informasi Dan Teknologi')
            ->inRandomOrder()->first();

        if (!$jabatan) {
            $jabatan = \App\Models\Jabatan::inRandomOrder()->first();
        }

        return [
            'user_id'    => null,
            'unit_id'    => $unit_id,
            'jabatan_id' => $jabatan->id,
            'departemen' => $departemen,
            'no_hp'      => $this->faker->phoneNumber,
        ];
    }
}
