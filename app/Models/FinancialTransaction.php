<?php
// app/Models/FinancialTransaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'company_id',
        'seller_id',
        'order_total',
        'company_commission_percent',
        'seller_commission_percent',
        'system_commission_percent',
        'company_income',
        'seller_income',
        'system_income',
        'transaction_type',
        'status',
    ];

    protected $casts = [
        'order_total' => 'decimal:2',
        'company_commission_percent' => 'decimal:2',
        'seller_commission_percent' => 'decimal:2',
        'system_commission_percent' => 'decimal:2',
        'company_income' => 'decimal:2',
        'seller_income' => 'decimal:2',
        'system_income' => 'decimal:2',
    ];

    // ============================================
    // ثابت‌ها
    // ============================================

    const TYPE_ORDER = 'order';
    const TYPE_COMMISSION = 'commission';
    const TYPE_REFUND = 'refund';

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // ============================================
    // روابط
    // ============================================

    public function order()
    {
        return $this->belongsTo(CompanyOrder::class, 'order_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * بررسی تکمیل شدن
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * محاسبه درآمدها
     */
    public function calculateIncomes()
    {
        $this->company_income = $this->order_total * ($this->company_commission_percent / 100);
        $this->seller_income = $this->order_total * ($this->seller_commission_percent / 100);
        $this->system_income = $this->order_total * ($this->system_commission_percent / 100);

        return $this;
    }

    /**
     * تایید تراکنش
     */
    public function complete()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->save();
    }

    /**
     * لغو تراکنش
     */
    public function cancel()
    {
        $this->status = self::STATUS_CANCELLED;
        $this->save();
    }

    /**
     * درصد کل کمیسیون
     */
    public function getTotalCommissionPercent()
    {
        return $this->company_commission_percent
            + $this->seller_commission_percent
            + $this->system_commission_percent;
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeOrders($query)
    {
        return $query->where('transaction_type', self::TYPE_ORDER);
    }

    public function scopeCommissions($query)
    {
        return $query->where('transaction_type', self::TYPE_COMMISSION);
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
