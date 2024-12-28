<?php

namespace App\Helpers;

use App\Models\Settings;

class SettingHelper
{
    public static function get(string $key, $default = null)
    {
        $setting = Settings::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, string $value)
    {
        $setting = Settings::where('key', $key)->first();
        if ($setting) {
            $setting->value = $value;
            $setting->save();
        } else {
            (new Settings())->create([
                'key' => $key,
                'value' => $value
            ]);
        }
    }
}
