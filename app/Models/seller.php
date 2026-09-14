<?php
// app/Models/Seller.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Seller extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'store_name',
        'slug',
        'store_description',
        'store_status',
        'website',
        'instagram',
        'telegram',
        'whatsapp',
    ];

    // ============================================
    // روابط
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function categories()
    {
        return $this->hasMany(SellerCategory::class);
    }

    public function products()
    {
        return $this->hasMany(SellerProduct::class);
    }

    public function customers()
    {
        return $this->hasMany(SellerCustomer::class);
    }

    public function orders()
    {
        return $this->hasMany(SellerOrder::class);
    }

    public function messages()
    {
        return $this->hasMany(SellerMessage::class);
    }

    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class);
    }

    // ============================================
    // متدها
    // ============================================

    public function getDisplayName()
    {
        return $this->store_name ?: ($this->user ? $this->user->getDisplayName() : 'فروشنده');
    }

    public function isActive()
    {
        return $this->store_status === 'active'
            && $this->user
            && $this->user->status === 'active';
    }

    // ============================================
    // Boot
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($seller) {
            if (empty($seller->slug)) {
                $name = $seller->store_name ?: uniqid();
                $seller->slug = Str::slug($name) . '-' . uniqid();
            }
        });
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('store_status', 'active');
    }
}
