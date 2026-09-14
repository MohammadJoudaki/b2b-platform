<?php
// app/Models/FinancialRecord.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'company_id',
        'seller_id',
        'order_total',
        'customer_paid_amount',
        'customer_remaining',
        'company_income',
        'seller_income',
        'system_income',
        'company_paid',
        'company_remaining',
        'seller_paid',
        'seller_remaining',
        'transaction_type',
        'status',
    ];

    protected $casts = [
        'order_total' => 'decimal:2',
        'customer_paid_amount' => 'decimal:2',
        'customer_remaining' => 'decimal:2',
        'company_income' => 'decimal:2',
        'seller_income' => 'decimal:2',
        'system_income' => 'decimal:2',
        'company_paid' => 'decimal:2',
        'company_remaining' => 'decimal:2',
        'seller_paid' => 'decimal:2',
        'seller_remaining' => 'decimal:2',
    ];

    // ============================================
    // روابط
    // ============================================

    public function order()
    {
        return $this->belongsTo(CompanyOrder::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(SellerCustomer::class, 'customer_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function payments()
    {
        return $this->hasMany(FinancialPayment::class);
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * بررسی تکمیل شدن
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * بررسی جزئی بودن
     */
    public function isPartial()
    {
        return $this->status === 'partial';
    }

    /**
     * بررسی تسویه کامل مشتری
     */
    public function isCustomerSettled()
    {
        return $this->customer_remaining <= 0;
    }

    /**
     * بررسی تسویه کامل شرکت
     */
    public function isCompanySettled()
    {
        return $this->company_remaining <= 0;
    }

    /**
     * بررسی تسویه کامل فروشنده
     */
    public function isSellerSettled()
    {
        return $this->seller_remaining <= 0;
    }

    /**
     * پرداخت مشتری
     */
    public function customerPay($amount)
    {
        $this->customer_paid_amount += $amount;
        $this->customer_remaining = $this->order_total - $this->customer_paid_amount;
        $this->updateStatus();
        $this->save();
    }

    /**
     * پرداخت به شرکت
     */
    public function payToCompany($amount)
    {
        $this->company_paid += $amount;
        $this->company_remaining = $this->company_income - $this->company_paid;
        $this->updateStatus();
        $this->save();
    }

    /**
     * پرداخت به فروشنده
     */
    public function payToSeller($amount)
    {
        $this->seller_paid += $amount;
        $this->seller_remaining = $this->seller_income - $this->seller_paid;
        $this->updateStatus();
        $this->save();
    }

    /**
     * بروزرسانی وضعیت
     */
    public function updateStatus()
    {
        if ($this->customer_remaining <= 0
            && $this->company_remaining <= 0
            && $this->seller_remaining <= 0) {
            $this->status = 'completed';
        } elseif ($this->customer_paid_amount > 0
            || $this->company_paid > 0
            || $this->seller_paid > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'pending';
        }
    }

    /**
     * درصد پیشرفت تسویه
     */
    public function getSettlementProgress()
    {
        if ($this->order_total <= 0) {
            return 100;
        }
        return round(($this->customer_paid_amount / $this->order_total) * 100, 2);
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeBySeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }
}
