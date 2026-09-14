<?php
// app/Models/SellerCustomer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerCustomer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'seller_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'job_title',
        'company',
        'description',
        'contact_time',
        'contact_date',
        'status',
        'source',
        'notes',
    ];

    protected $casts = [
        'contact_date' => 'date',
    ];

    // ============================================
    // روابط
    // ============================================

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function orders()
    {
        return $this->hasMany(SellerOrder::class, 'customer_id');
    }

    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class, 'customer_id');
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * نام کامل مشتری
     */
    public function getFullName()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * بررسی مشتری واقعی بودن
     */
    public function isCustomer()
    {
        return $this->status === 'customer';
    }

    /**
     * بررسی سرنخ (Lead) بودن
     */
    public function isLead()
    {
        return $this->status === 'lead';
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCustomers($query)
    {
        return $query->where('status', 'customer');
    }

    public function scopeLeads($query)
    {
        return $query->where('status', 'lead');
    }

    public function scopeBySeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('first_name', 'like', "%{$term}%")
              ->orWhere('last_name', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%");
        });
    }
}
