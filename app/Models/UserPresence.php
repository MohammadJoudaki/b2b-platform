<?php
// app/Models/UserPresence.php

// app/Models/UserPresence.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPresence extends Model
{
    use HasFactory;

    protected $table = 'user_presence';

    /**
     * ✅ غیرفعال کردن timestamps
     */
    public $timestamps = false;

    protected $fillable = [
        'user_type',
        'user_id',
        'last_seen',
        'is_online',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
        'is_online' => 'boolean',
    ];

    // ============================================
    // ثابت‌ها
    // ============================================

    const TYPE_MANAGER = 'manager';
    const TYPE_SELLER = 'seller';
    const TYPE_COMPANY = 'company';
    const TYPE_ADMIN = 'admin';

    // زمان انقضای آنلاین (به ثانیه)
    const ONLINE_TIMEOUT = 60;

    // ============================================
    // متدها
    // ============================================

    /**
     * بروزرسانی وضعیت آنلاین
     */
    public static function updatePresence($userId, $userType)
    {
        $presence = self::where('user_id', $userId)
                        ->where('user_type', $userType)
                        ->first();

        if ($presence) {
            $presence->last_seen = now();
            $presence->is_online = true;
            $presence->save();
        } else {
            $presence = self::create([
                'user_id' => $userId,
                'user_type' => $userType,
                'last_seen' => now(),
                'is_online' => true,
            ]);
        }

        return $presence;
    }


    /**
     * علامت‌گذاری آفلاین
     */
    public function markAsOffline()
    {
        $this->is_online = false;
        $this->last_seen = now();
        $this->save();
    }

    /**
     * بررسی آنلاین بودن (با timeout)
     */
    public function isOnlineNow()
    {
        if (!$this->is_online) {
            return false;
        }

        $diff = now()->diffInSeconds($this->last_seen);
        return $diff <= self::ONLINE_TIMEOUT;
    }

    /**
     * دریافت وضعیت آنلاین برای کاربر
     */
    public static function getOnlineStatus($userId, $userType)
    {
        $presence = self::where('user_id', $userId)
                        ->where('user_type', $userType)
                        ->first();

        if (!$presence) {
            return false;
        }

        return $presence->isOnlineNow();
    }

    /**
     * دریافت زمان آخرین بازدید برای کاربر
     */
    public static function getLastSeen($userId, $userType)
    {
        $presence = self::where('user_id', $userId)
                        ->where('user_type', $userType)
                        ->first();

        return $presence ? $presence->last_seen : null;
    }

    /**
     * پاک کردن حضورهای قدیمی
     */
    public static function cleanupOld($minutes = 5)
    {
        return self::where('last_seen', '<', now()->subMinutes($minutes))
                   ->update(['is_online' => false]);
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeOnline($query)
    {
        return $query->where('is_online', true)
                     ->where('last_seen', '>=', now()->subSeconds(self::ONLINE_TIMEOUT));
    }

    public function scopeOffline($query)
    {
        return $query->where('is_online', false)
                     ->orWhere('last_seen', '<', now()->subSeconds(self::ONLINE_TIMEOUT));
    }

    public function scopeByType($query, $type)
    {
        return $query->where('user_type', $type);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
