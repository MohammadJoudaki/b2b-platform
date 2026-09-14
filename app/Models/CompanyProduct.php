<?php
// app/Models/CompanyProduct.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'seller_product_id',
        'seller_id',
        'price',
        'price_usd',
        'price_thousand_toman',
        'stock',
        'custom_commission',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_usd' => 'decimal:2',
        'price_thousand_toman' => 'decimal:2',
        'custom_commission' => 'decimal:2',
        'stock' => 'integer',
    ];

    // ============================================
    // روابط
    // ============================================

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sellerProduct()
    {
        return $this->belongsTo(SellerProduct::class, 'seller_product_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * دریافت نام محصول (از seller_product)
     */
    public function getProductName()
    {
        return $this->sellerProduct ? $this->sellerProduct->name : 'نامشخص';
    }

    /**
     * بررسی موجودی
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
     * محاسبه کمیسیون
     */
    public function getCommission()
    {
        $percent = $this->custom_commission
            ?: ($this->company ? $this->company->commission_rate : 0);

        return $this->price * ($percent / 100);
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

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
