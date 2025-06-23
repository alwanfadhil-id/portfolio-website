<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    /**
     * Mendapatkan setting berdasarkan key
     */
    public static function get($key, $default = null)
    {
        return Setting::get($key, $default);
    }

    /**
     * Menyimpan setting
     */
    public static function set($key, $value, $type = 'text')
    {
        return Setting::set($key, $value, $type);
    }

    /**
     * Mendapatkan semua setting dalam format array
     */
    public static function all()
    {
        $settings = Setting::all();
        $result = [];
        
        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->value;
        }
        
        return $result;
    }
}