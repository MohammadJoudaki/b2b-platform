<?php
// app/Helpers/helpers.php

use App\Models\SiteSetting;
use App\Models\User;

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        static $settings = null;
        if ($settings === null) {
            $settings = cache()->remember('site_settings', 3600, function () {
                return SiteSetting::pluck('setting_value', 'setting_key')->toArray();
            });
        }
        return $settings[$key] ?? $default;
    }
}

if (!function_exists('format_price')) {
    function format_price($amount, $with_currency = true)
    {
        $formatted = number_format((float) $amount);
        if ($with_currency && app()->getLocale() === 'fa') {
            return $formatted . ' Toman';
        }
        return $formatted;
    }
}

if (!function_exists('is_rtl')) {
    function is_rtl()
    {
        return app()->getLocale() === 'fa';
    }
}

if (!function_exists('direction')) {
    function direction()
    {
        return is_rtl() ? 'rtl' : 'ltr';
    }
}

if (!function_exists('user_role_prefix')) {
    function user_role_prefix()
    {
        $user = auth()->user();
        if (!$user) {
            return '';
        }

        switch ($user->role) {
            case 'super_admin':
            case 'admin':
            case 'editor':
                return 'management';

            case 'company_manager':
            case 'company_admin':
            case 'company_user':
                return 'company';

            case 'seller':
                return 'seller';

            default:
                return '';
        }
    }
}

if (!function_exists('generate_unique_code')) {
    function generate_unique_code($prefix = 'HSC', $length = 10)
    {
        $attempts = 0;
        do {
            $random = bin2hex(random_bytes(8));
            $short = substr($random, 0, $length);
            $upper = strtoupper($short);
            $code = $prefix . '-' . $upper;
            $attempts++;
        } while (User::where('unique_code', $code)->exists() && $attempts < 10);

        return $code;
    }
}
