<?php
// app/Models/FinancialPayment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_record_id',
        'payer_type',
        'amount',
        'payment_method',
        'reference_number',
        'description',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // ============================================
    // ثابت‌ها
    // ============================================

    const PAYER_CUSTOMER = 'customer';
    const PAYER_MANAGEMENT_TO_COMPANY = 'management_to_company';
    const PAYER_MANAGEMENT_TO_SELLER = 'management_to_seller';

    // ============================================
    // روابط
    // ============================================

    public function financialRecord()
    {
        return $this->belongsTo(FinancialRecord::class);
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * بررسی پرداخت از طرف مشتری
     */
    public function isFromCustomer()
    {
        return $this->payer_type === self::PAYER_CUSTOMER;
    }

    /**
     * بررسی پرداخت به شرکت
     */
    public function isToCompany()
    {
        return $this->payer_type === self::PAYER_MANAGEMENT_TO_COMPANY;
    }

    /**
     * بررسی پرداخت به فروشنده
     */
    public function isToSeller()
    {
        return $this->payer_type === self::PAYER_MANAGEMENT_TO_SELLER;
    }

    /**
     * برچسب فارسی نوع پرداخت
     */
    public function getPayerTypeLabel()
    {
        $labels = [
            self::PAYER_CUSTOMER => 'پرداخت مشتری',
            self::PAYER_MANAGEMENT_TO_COMPANY => 'پرداخت به شرکت',
            self::PAYER_MANAGEMENT_TO_SELLER => 'پرداخت به فروشنده',
        ];

        return isset($labels[$this->payer_type]) ? $labels[$this->payer_type] : 'نامشخص';
    }

    // ============================================
    // Boot
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->paid_at)) {
                $payment->paid_at = now();
            }
        });
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeFromCustomer($query)
    {
        return $query->where('payer_type', self::PAYER_CUSTOMER);
    }

    public function scopeToCompany($query)
    {
        return $query->where('payer_type', self::PAYER_MANAGEMENT_TO_COMPANY);
    }

    public function scopeToSeller($query)
    {
        return $query->where('payer_type', self::PAYER_MANAGEMENT_TO_SELLER);
    }
}
