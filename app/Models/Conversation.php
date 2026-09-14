<?php
// app/Models/Conversation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'seller_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // ============================================
    // روابط
    // ============================================

    /**
     * مدیر مکالمه
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * فروشنده مکالمه
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * پیام‌های این مکالمه
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * آخرین پیام
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * دریافت طرف مقابل برای یک کاربر
     */
    public function getOtherUser($userId)
    {
        if ($this->manager_id == $userId) {
            return $this->seller;
        }
        if ($this->seller_id == $userId) {
            return $this->manager;
        }
        return null;
    }

    /**
     * تعداد پیام‌های خوانده نشده برای یک کاربر
     */
    public function getUnreadCountFor($userId)
    {
        return $this->messages()
                    ->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->count();
    }

    /**
     * علامت‌گذاری همه پیام‌ها به عنوان خوانده شده برای یک کاربر
     */
    public function markAllAsReadFor($userId)
    {
        $this->messages()
             ->where('receiver_id', $userId)
             ->where('is_read', false)
             ->update([
                 'is_read' => true,
                 'read_at' => now(),
             ]);
    }

    /**
     * بروزرسانی زمان آخرین پیام
     */
    public function updateLastMessageTime()
    {
        $this->last_message_at = now();
        $this->save();
    }

    /**
     * ایجاد یا دریافت مکالمه بین دو کاربر
     */
    public static function findOrCreate($managerId, $sellerId)
    {
        $conversation = self::where('manager_id', $managerId)
                           ->where('seller_id', $sellerId)
                           ->first();

        if (!$conversation) {
            $conversation = self::create([
                'manager_id' => $managerId,
                'seller_id' => $sellerId,
                'last_message_at' => now(),
            ]);
        }

        return $conversation;
    }

    // ============================================
    // Scopes
    // ============================================

    /**
     * مکالمات با پیام‌های اخیر
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('last_message_at', 'desc');
    }

    /**
     * مکالمات یک کاربر
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('manager_id', $userId)
                     ->orWhere('seller_id', $userId);
    }
}
