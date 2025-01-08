<?php

namespace App\Helpers;

use Carbon\Carbon;

class UsiaHelper
{
    public static function kelompokUsiaData()
    {
        return [
            "1" => "0-1 Bulan",
            "2" => "> 1 Bulan - 1 Tahun",
            "3" => "> 1 Tahun - 5 Tahun",
            "4" => "> 5 Tahun - 15 Tahun",
            "5" => "> 15 Tahun - 30 Tahun",
            "6" => "> 30 Tahun - 65 Tahun",
            "7" => "> 65 Tahun"
        ];
    }

    public static function getKelompokUsia(Carbon $tanggal_lahir)
    {
        $usia = $tanggal_lahir->diffInYears(Carbon::now());

        if ($usia < 1) {
            return 1;
        } elseif ($usia >= 1 && $usia < 5) {
            return 2;
        } elseif ($usia >= 5 && $usia < 15) {
            return 3;
        } elseif ($usia >= 15 && $usia < 30) {
            return 4;
        } elseif ($usia >= 30 && $usia < 65) {
            return 5;
        } elseif ($usia >= 65) {
            return 6;
        }
    }
}
