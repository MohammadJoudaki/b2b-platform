<?php
// app/Models/Message.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'sender_type',
        'sender_id',
        'receiver_type',
        'receiver_id',
        'message',
        'attachments',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // ============================================
    // ثابت‌ها
    // ============================================

    const TYPE_MANAGER = 'manager';
    const TYPE_SELLER = 'seller';
    const TYPE_COMPANY = 'company';

    // ============================================
    // روابط
    // ============================================

    /**
     * مکالمه مربوطه
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * فرستنده (polymorphic)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * گیرنده (polymorphic)
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
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
     * بررسی خوانده شده
     */
    public function isRead()
    {
        return $this->is_read;
    }

    /**
     * دریافت نام فرستنده
     */
    public function getSenderName()
    {
        return $this->sender ? $this->sender->getDisplayName() : 'نامشخص';
    }

    /**
     * بررسی داشتن پیوست
     */
    public function hasAttachments()
    {
        return !empty($this->attachments) && is_array($this->attachments);
    }

    /**
     * تعداد پیوست‌ها
     */
    public function getAttachmentsCount()
    {
        return $this->hasAttachments() ? count($this->attachments) : 0;
    }

    /**
     * بررسی ارسال توسط کاربر خاص
     */
    public function isSentBy($userId, $userType = null)
    {
        if ($this->sender_id != $userId) {
            return false;
        }
        if ($userType && $this->sender_type !== $userType) {
            return false;
        }
        return true;
    }

    /**
     * بررسی دریافت توسط کاربر خاص
     */
    public function isReceivedBy($userId, $userType = null)
    {
        if ($this->receiver_id != $userId) {
            return false;
        }
        if ($userType && $this->receiver_type !== $userType) {
            return false;
        }
        return true;
    }

    // ============================================
    // Boot - بروزرسانی زمان مکالمه
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::created(function ($message) {
            if ($message->conversation_id) {
                $conversation = Conversation::find($message->conversation_id);
                if ($conversation) {
                    $conversation->updateLastMessageTime();
                }
            }
        });
    }

    // ============================================
    // Scopes
    // ============================================

    /**
     * پیام‌های خوانده نشده
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * پیام‌های خوانده شده
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * پیام‌های یک مکالمه
     */
    public function scopeForConversation($query, $conversationId)
    {
        return $query->where('conversation_id', $conversationId);
    }

    /**
     * پیام‌های دریافتی یک کاربر
     */
    public function scopeForReceiver($query, $userId, $userType = null)
    {
        $query->where('receiver_id', $userId);
        if ($userType) {
            $query->where('receiver_type', $userType);
        }
        return $query;
    }

    /**
     * پیام‌های ارسالی یک کاربر
     */
    public function scopeForSender($query, $userId, $userType = null)
    {
        $query->where('sender_id', $userId);
        if ($userType) {
            $query->where('sender_type', $userType);
        }
        return $query;
    }

    /**
     * مرتب‌سازی بر اساس تاریخ
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}
