<?php
// app/Models/SellerProduct.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SellerProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'seller_id',
        'category_id',
        'company_name',
        'name',
        'slug',
        'description',
        'price',
        'price_usd',
        'price_thousand_toman',
        'unit_type',
        'unit_quantity',
        'stock',
        'commission_percent',
        'catalog_file',
        'brochure_file',
        'images',
        'image',
        'meta_title',
        'meta_description',
        'tags',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'price_usd' => 'decimal:2',
        'price_thousand_toman' => 'decimal:2',
        'unit_quantity' => 'decimal:2',
        'commission_percent' => 'decimal:2',
        'stock' => 'integer',
    ];

    // ============================================
    // روابط
    // ============================================

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function category()
    {
        return $this->belongsTo(SellerCategory::class, 'category_id');
    }

    public function sellerOrders()
    {
        return $this->hasMany(SellerOrder::class, 'product_id');
    }

    public function companyProducts()
    {
        return $this->hasMany(CompanyProduct::class, 'seller_product_id');
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * بررسی موجود بودن
     */
    public function isInStock()
    {
        return $this->stock > 0;
    }

    /**
     * بررسی فعال بودن
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * دریافت تصویر اصلی
     */
    public function getMainImageUrl()
    {
        if ($this->image) {
            return asset('uploads/products/' . $this->image);
        }

        if (!empty($this->images) && is_array($this->images)) {
            return asset('uploads/products/' . $this->images[0]);
        }

        return asset('assets/images/no-image.png');
    }

    /**
     * دریافت قیمت با تخفیف (اگر تخفیفی وجود دارد)
     */
    public function getFinalPrice()
    {
        return $this->price;
    }

    /**
     * کاهش موجودی
     */
    public function decreaseStock($quantity)
    {
        if ($this->stock < $quantity) {
            return false;
        }
        $this->stock -= $quantity;
        $this->save();
        return true;
    }

    /**
     * افزایش موجودی
     */
    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }

    // ============================================
    // Boot - تولید خودکار Slug
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . uniqid();
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

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeBySeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                     ->orWhere('description', 'like', "%{$term}%")
                     ->orWhere('tags', 'like', "%{$term}%");
    }
}
