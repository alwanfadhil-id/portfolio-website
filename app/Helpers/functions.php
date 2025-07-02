<?php

use App\Helpers\SettingsHelper;

if (!function_exists('setting')) {
    /**
     * Get setting value by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return SettingsHelper::get($key, $default);
    }
}

if (!function_exists('settings')) {
    /**
     * Get all settings as array
     * 
     * @return array
     */
    function settings()
    {
        return SettingsHelper::all();
    }
}