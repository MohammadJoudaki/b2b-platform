<?php
// app/Models/Company.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'slug',
        'logo',
        'description',
        'economic_code',
        'national_id',
        'registration_number',
        'commission_rate',
        'company_type',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
    ];

    // ============================================
    // روابط
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sellers()
    {
        return $this->hasMany(Seller::class);
    }

    public function companyProducts()
    {
        return $this->hasMany(CompanyProduct::class);
    }

    public function companyOrders()
    {
        return $this->hasMany(CompanyOrder::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class);
    }

    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    // ============================================
    // متدها
    // ============================================

    public function getDisplayName()
    {
        return $this->company_name;
    }

    public function getLogoUrl()
    {
        if ($this->logo) {
            return asset('uploads/companies/' . $this->logo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->company_name) . '&background=d4a847&color=fff';
    }

    public function isActive()
    {
        return $this->user && $this->user->status === 'active';
    }

    public function getActiveContract()
    {
        return $this->contracts()
                    ->where('status', 'active')
                    ->where('end_date', '>=', now())
                    ->first();
    }

    // ============================================
    // Boot - تولید خودکار Slug
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->slug)) {
                $company->slug = Str::slug($company->company_name) . '-' . uniqid();
            }
        });
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('status', 'active');
        });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('company_type', $type);
    }
}
