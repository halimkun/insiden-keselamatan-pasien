<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Insiden>
 */
class InsidenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kasusInsiden = [
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
        ];

        $tgl_masuk_pasien = $this->faker->dateTimeBetween("-5 Months", "now");

        return [
            "tgl_pasien_masuk"        => $tgl_masuk_pasien,
            "tanggal_insiden"         => $this->faker->dateTimeBetween($tgl_masuk_pasien, (clone $tgl_masuk_pasien)->modify('+5 days'))->format('Y-m-d'),
            "waktu_insiden"           => $this->faker->time(),
            "insiden"                 => $this->faker->sentence(6),
            "kronologi"               => $this->faker->sentence(24),
            "jenis_pelapor"           => $this->faker->randomElement(['karyawan', 'pengunjung', 'pasien', 'keluarga']),
            "jenis_pelapor_lainnya"   => null,
            "korban_insiden"          => 'pasien',
            "korban_insiden_lainnya"  => null,
            "layanan_insiden"         => $this->faker->randomElement(['ranap', 'ralan', 'ugd']),
            "layanan_insiden_lainnya" => null,
            "kasus_insiden"           => $this->faker->randomElement($kasusInsiden),
            "kasus_insiden_lainnya"   => null,
            "tempat_kejadian"         => $this->faker->randomElement(['ruang perawatan', 'ruang operasi', 'ruang ugd', 'ruang ralan', 'ruang isolasi']),
            "dampak_insiden"          => $this->faker->randomElement(['minor', 'moderat', 'mayor']),
            "tindakan_id"             => null,
            "pernah_terjadi"          => $this->faker->randomElement([1, 0]),
            "status_pelapor"          => $this->faker->randomElement(['Penemu Insiden', 'Terlibat Langsung']),
            "grading_id"              => null,
        ];
    }
}
