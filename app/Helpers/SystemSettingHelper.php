<?php

if (!function_exists('get_system_config')) {
    function get_system_config($key, $default = null)
    {
        $config = \DB::table('configurations')
            ->where('config_key', $key)
            ->first();

        return $config ? $config->value : $default;
    }
}