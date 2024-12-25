<?php

namespace App\Helpers;

use Carbon\Carbon;

class CustomHelper
{
    /**
     * Get short month name by month number.
     *
     * @param int $month
     * @return string
     */
    public static function getShortMonthName(int $month): string
    {
        return Carbon::create(null, $month, null)->shortMonthName;
    }

    /**
     * Get month name by month number.
     *
     * @param int $month
     * @return string
     */
    public static function getMonthName(int $month): string
    {
        return Carbon::create(null, $month, null)->monthName;
    }
}