<?php
// app/Models/SiteSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description',
    ];

    // ============================================
    // متدها
    // ============================================

    /**
     * دریافت مقدار تنظیمات
     */
    public static function get($key, $default = null)
    {
        $settings = self::getAllCached();

        if (!isset($settings[$key])) {
            return $default;
        }

        $value = $settings[$key];

        // تبدیل بر اساس نوع
        $type = self::getType($key);

        if ($type === 'json') {
            return json_decode($value, true) ?: $default;
        }

        return $value;
    }

    /**
     * ذخیره مقدار تنظیمات
     */
    public static function set($key, $value, $type = 'text')
    {
        $setting = self::where('setting_key', $key)->first();

        if ($type === 'json' && is_array($value)) {
            $value = json_encode($value);
        }

        if ($setting) {
            $setting->setting_value = $value;
            $setting->setting_type = $type;
            $setting->save();
        } else {
            self::create([
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_type' => $type,
            ]);
        }

        // پاک کردن کش
        Cache::forget('site_settings');

        return true;
    }

    /**
     * دریافت همه تنظیمات با کش
     */
    public static function getAllCached()
    {
        return Cache::remember('site_settings', 3600, function () {
            return self::pluck('setting_value', 'setting_key')->toArray();
        });
    }

    /**
     * دریافت نوع تنظیمات
     */
    public static function getType($key)
    {
        $setting = self::where('setting_key', $key)->first();
        return $setting ? $setting->setting_type : 'text';
    }

    /**
     * پاک کردن کش
     */
    public static function clearCache()
    {
        Cache::forget('site_settings');
    }

    /**
     * بررسی وجود تنظیمات
     */
    public static function exists($key)
    {
        return self::where('setting_key', $key)->exists();
    }

    // ============================================
    // Boot - پاک کردن کش خودکار
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            self::clearCache();
        });

        static::deleted(function () {
            self::clearCache();
        });
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeByType($query, $type)
    {
        return $query->where('setting_type', $type);
    }
}
