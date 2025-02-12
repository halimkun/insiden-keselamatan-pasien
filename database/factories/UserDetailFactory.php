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
        $units = \App\Models\Unit::all();

        return [
            'user_id'    => null,
            'unit_id'    => $units->random()->id,
            'jabatan'    => $this->faker->randomElement(['Ketua', 'Pelaksana']),
            'departemen' => $units->random()->nama_unit,
            'no_hp'      => $this->faker->phoneNumber,
        ];
    }
}
