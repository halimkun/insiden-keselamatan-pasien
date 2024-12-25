<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InsidenHelper
{
    public static function getImpactLevel(string $impact): int
    {
        $impactData = collect([
            'Tidak Signifikan' => 1,
            'Minor'            => 2,
            'Moderat'         => 3,
            'Mayor'            => 4,
            'Katastropik'      => 5,
        ]);

        return $impactData->get(Str::title($impact));
    }

    /**
     * Menghitung probabilitas berdasarkan jumlah insiden dalam periode waktu tertentu.
     *
     * @param int $jenisInsidenId
     * @param int $unitId
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    public static function getProbabilityLevel(int $jenisInsidenId, int $unitId): int
    {
        // periode kebelakang
        $period = 5; // 5 tahun

        // Tanggal sekarang
        $endDate   = Carbon::today();
        $startDate = Carbon::today()->subYears($period);

        // Hitung jumlah insiden dalam periode waktu
        $frekuensi = DB::table('insiden')
            ->where('jenis_insiden_id', $jenisInsidenId)
            ->where('unit_id', $unitId)
            ->whereBetween('tanggal_insiden', [$startDate, $endDate])
            ->whereNull('deleted_at') // Abaikan soft deletes
            ->count();

        // Hitung probabilitas
        $probability = $frekuensi / $period;

        // Kategori probabilitas
        if ($frekuensi == 0) {
            $level = 1;
        } elseif ($probability <= 0.2) {
            $level = 2;
        } elseif ($probability <= 1) {
            $level = 3;
        } elseif ($probability <= 5) {
            $level = 4;
        } else {
            $level = 5;
        }

        return $level;
    }

    public static function getRiskGrading(int $probability, int $impact): string
    {
        // Matriks Grading Risiko berdasarkan tabel
        $matrix = [
            1 => ['Rendah', 'Rendah', 'Moderat', 'Tinggi', 'Ekstrim'],         // Probabilitas 1
            2 => ['Rendah', 'Rendah', 'Moderat', 'Tinggi', 'Ekstrim'],         // Probabilitas 2
            3 => ['Rendah', 'Moderat', 'Tinggi', 'Ekstrim', 'Ekstrim'],        // Probabilitas 3
            4 => ['Moderat', 'Moderat', 'Tinggi', 'Ekstrim', 'Ekstrim'],      // Probabilitas 4
            5 => ['Moderat', 'Moderat', 'Tinggi', 'Ekstrim', 'Ekstrim'],      // Probabilitas 5
        ];

        // Ambil kategori berdasarkan matriks
        return $matrix[$probability][$impact - 1];
    }

    public static function riskGradingToColor(string $riskGrading): string
    {
        $color = [
            'Rendah'  => 'biru',
            'Moderat' => 'hijau',
            'Tinggi'  => 'kuning',
            'Ekstrim' => 'merah',
        ];

        return $color[$riskGrading];
    }

    /**
     * Mendapatkan kategori probabilitas berdasarkan frekuensi dan periode waktu.
     *
     * @param int $frekuensi
     * @param string $startDate
     * @param string $endDate
     * @return string
     */
    private static function getProbabilityCategory(int $level): string
    {
        $category = [
            1 => 'Sangat Jarang / Rare',
            2 => 'Jarang / Unlikely',
            3 => 'Mungkin / Possible',
            4 => 'Sering / Likely',
            5 => 'Sangat Sering / Almost Certain',
        ];

        return $category[$level];
    }
}
