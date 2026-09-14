<?php
// app/Models/SellerCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SellerCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'status',
        'order_num',
    ];

    // ============================================
    // روابط
    // ============================================

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function parent()
    {
        return $this->belongsTo(SellerCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(SellerCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(SellerProduct::class, 'category_id');
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * دریافت همه زیردسته‌ها به صورت بازگشتی
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    /**
     * بررسی اصلی بودن (بدون والد)
     */
    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    // ============================================
    // Boot - تولید خودکار Slug
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name) . '-' . uniqid();
            }
        });
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_num', 'asc');
    }
}
