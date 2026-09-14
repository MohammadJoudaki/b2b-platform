<?php
// app/Models/SellerMessage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'sender_name',
        'sender_email',
        'sender_phone',
        'subject',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // ============================================
    // روابط
    // ============================================

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * علامت‌گذاری به عنوان خوانده شده
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            $this->save();
        }
    }

    /**
     * علامت‌گذاری به عنوان خوانده نشده
     */
    public function markAsUnread()
    {
        $this->is_read = false;
        $this->read_at = null;
        $this->save();
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeBySeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }
}
