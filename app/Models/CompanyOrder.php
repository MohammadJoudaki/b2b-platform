<?php
// app/Models/CompanyOrder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'company_id',
        'seller_order_id',
        'seller_id',
        'product_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'address',
        'quantity',
        'unit_price',
        'total_price',
        'shipping_cost',
        'discount',
        'status',
        'payment_method',
        'shipping_method',
        'notes',
        'company_note',
        'order_date',
        'delivery_date',
        'confirmed_at',
        'processing_at',
        'ready_at',
        'delivered_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'order_date' => 'date',
        'delivery_date' => 'date',
        'confirmed_at' => 'datetime',
        'processing_at' => 'datetime',
        'ready_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // ============================================
    // روابط
    // ============================================

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sellerOrder()
    {
        return $this->belongsTo(SellerOrder::class, 'seller_order_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function product()
    {
        return $this->belongsTo(SellerProduct::class, 'product_id');
    }

    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class, 'order_id');
    }

    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class, 'order_id');
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * قیمت نهایی
     */
    public function getFinalPrice()
    {
        return $this->total_price + $this->shipping_cost - $this->discount;
    }

    /**
     * بررسی تکمیل شدن
     */
    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    /**
     * بررسی قابل لغو
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * تغییر وضعیت به تایید شده
     */
    public function confirm()
    {
        $this->status = 'confirmed';
        $this->confirmed_at = now();
        $this->save();
    }

    /**
     * تغییر وضعیت به در حال پردازش
     */
    public function process()
    {
        $this->status = 'processing';
        $this->processing_at = now();
        $this->save();
    }

    /**
     * تغییر وضعیت به آماده
     */
    public function markAsReady()
    {
        $this->status = 'ready';
        $this->ready_at = now();
        $this->save();
    }

    /**
     * تغییر وضعیت به تحویل شده
     */
    public function deliver()
    {
        $this->status = 'delivered';
        $this->delivered_at = now();
        $this->save();
    }

    /**
     * لغو سفارش
     */
    public function cancel()
    {
        $this->status = 'cancelled';
        $this->save();
    }

    // ============================================
    // Boot
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'CO-' . strtoupper(uniqid());
            }
            if (empty($order->order_date)) {
                $order->order_date = now()->toDateString();
            }
        });
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
