<?php
// app/Models/Notification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender_type',
        'sender_id',
        'title',
        'message',
        'link',
        'icon',
        'color',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // ============================================
    // ثابت‌ها
    // ============================================

    const SENDER_SYSTEM = 'system';
    const SENDER_SELLER = 'seller';
    const SENDER_COMPANY = 'company';
    const SENDER_ADMIN = 'admin';

    // ============================================
    // روابط
    // ============================================

    /**
     * کاربر گیرنده
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * فرستنده (اگر مدیر/فروشنده/شرکت باشد)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
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

    /**
     * بررسی سیستم بودن
     */
    public function isFromSystem()
    {
        return $this->sender_type === self::SENDER_SYSTEM;
    }

    /**
     * دریافت نام فرستنده
     */
    public function getSenderName()
    {
        $labels = [
            self::SENDER_SYSTEM => 'سیستم',
            self::SENDER_SELLER => 'فروشنده',
            self::SENDER_COMPANY => 'شرکت',
            self::SENDER_ADMIN => 'مدیر',
        ];

        return isset($labels[$this->sender_type])
            ? $labels[$this->sender_type]
            : 'نامشخص';
    }

    // ============================================
    // متد استاتیک برای ایجاد اعلان
    // ============================================

    /**
     * ایجاد اعلان جدید
     */
    public static function createNotification($userId, $title, $message, $options = [])
    {
        return self::create(array_merge([
            'user_id' => $userId,
            'sender_type' => self::SENDER_SYSTEM,
            'title' => $title,
            'message' => $message,
            'icon' => 'fa-bell',
            'color' => 'gold',
            'is_read' => false,
        ], $options));
    }

    /**
     * ایجاد اعلان برای چند کاربر
     */
    public static function createForMultiple($userIds, $title, $message, $options = [])
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = self::createNotification($userId, $title, $message, $options);
        }
        return $notifications;
    }

    // ============================================
    // Scopes
    // ============================================

    /**
     * اعلان‌های خوانده نشده
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * اعلان‌های خوانده شده
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * اعلان‌های یک کاربر
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * اعلان‌های اخیر
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * اعلان‌های امروز
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now()->toDateString());
    }
}
