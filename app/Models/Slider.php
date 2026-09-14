<?php
// app/Models/Slider.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'button_text',
        'order_num',
        'status',
    ];

    protected $casts = [
        'order_num' => 'integer',
    ];

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
     * دریافت URL تصویر
     */
    public function getImageUrl()
    {
        if ($this->image) {
            // اگر لینک کامل بود
            if (strpos($this->image, 'http') === 0) {
                return $this->image;
            }

            // اگر از assets باشد
            if (strpos($this->image, 'assets/') === 0) {
                return asset($this->image);
            }

            // اگر از uploads باشد
            return asset('uploads/sliders/' . $this->image);
        }

        return asset('assets/images/slider-default.jpg');
    }

    /**
     * دریافت لینک دکمه
     */
    public function getButtonLink()
    {
        return $this->link ?: '#';
    }

    /**
     * بررسی داشتن دکمه
     */
    public function hasButton()
    {
        return !empty($this->button_text);
    }

    /**
     * دریافت اسلایدرهای فعال
     */
    public static function getActiveSliders()
    {
        return self::active()->ordered()->get();
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_num', 'asc');
    }
}
