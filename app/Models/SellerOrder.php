<?php
// app/Models/SellerOrder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SellerOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'seller_id',
        'product_id',
        'customer_id',
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
        'payment_status',
        'payment_method',
        'shipping_method',
        'notes',
        'order_date',
        'delivery_date',
        'paid_at',
        'shipped_at',
        'completed_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'order_date' => 'date',
        'delivery_date' => 'date',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // ============================================
    // روابط
    // ============================================

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function product()
    {
        return $this->belongsTo(SellerProduct::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(SellerCustomer::class, 'customer_id');
    }

    public function companyOrders()
    {
        return $this->hasMany(CompanyOrder::class, 'seller_order_id');
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * محاسبه قیمت نهایی
     */
    public function getFinalPrice()
    {
        return $this->total_price + $this->shipping_cost - $this->discount;
    }

    /**
     * بررسی پرداخت شده
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * بررسی تکمیل شده
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * بررسی قابل لغو بودن
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * علامت‌گذاری به عنوان پرداخت شده
     */
    public function markAsPaid()
    {
        $this->payment_status = 'paid';
        $this->paid_at = now();
        $this->save();
    }

    /**
     * تغییر وضعیت
     */
    public function changeStatus($status)
    {
        $this->status = $status;

        if ($status === 'shipped' && !$this->shipped_at) {
            $this->shipped_at = now();
        }

        if ($status === 'completed' && !$this->completed_at) {
            $this->completed_at = now();
        }

        $this->save();
    }

    // ============================================
    // Boot - تولید خودکار شماره سفارش
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'SO-' . strtoupper(uniqid());
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

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeBySeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
