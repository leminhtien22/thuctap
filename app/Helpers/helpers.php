<?php

if (!function_exists('change_locale')) {
    function change_locale($locale = 'vi') {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
}

if (!function_exists('get_locale')) {
    function get_locale() {
        return session('locale', config('app.locale'));
    }
}
