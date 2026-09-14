<?php
// app/Models/SitePage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_key',
        'title',
        'content',
        'meta_title',
        'meta_description',
        'status',
    ];

    // ============================================
    // ثابت‌های کلید صفحات
    // ============================================

    const KEY_HOME = 'home';
    const KEY_ABOUT = 'about';
    const KEY_SERVICES = 'services';
    const KEY_PROJECTS = 'projects';
    const KEY_BLOG = 'blog';
    const KEY_CONTACT = 'contact';

    // ============================================
    // متدها
    // ============================================

    /**
     * بررسی فعال بودن
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * دریافت صفحه بر اساس کلید
     */
    public static function findByKey($key)
    {
        return self::where('page_key', $key)->first();
    }

    /**
     * دریافت محتوای صفحه یا مقدار پیش‌فرض
     */
    public static function getContent($key, $default = '')
    {
        $page = self::findByKey($key);
        return $page ? $page->content : $default;
    }

    /**
     * دریافت عنوان صفحه یا مقدار پیش‌فرض
     */
    public static function getTitle($key, $default = '')
    {
        $page = self::findByKey($key);
        return $page ? $page->title : $default;
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
