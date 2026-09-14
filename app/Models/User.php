<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_code',
        'username',
        'password',
        'full_name',
        'email',
        'phone',
        'address',
        'bio',
        'avatar',
        'logo',
        'role',
        'status',
        'last_login',
        'contract_date',
        'contract_end_date',
        'manager_note',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'contract_date' => 'date',
        'contract_end_date' => 'date',
    ];

    // ============================================
    // روابط (Relationships)
    // ============================================

    /**
     * شرکت متصل به این کاربر
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    /**
     * فروشنده متصل به این کاربر
     */
    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    /**
     * مدیر متصل به این کاربر
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * اعلان‌های این کاربر
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * اعلان‌های خوانده نشده
     */
    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    /**
     * پیام‌های ارسالی
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id')
                    ->where('sender_type', $this->getUserType());
    }

    /**
     * پیام‌های دریافتی
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')
                    ->where('receiver_type', $this->getUserType());
    }

    /**
     * مکالمات به عنوان مدیر
     */
    public function managerConversations()
    {
        return $this->hasMany(Conversation::class, 'manager_id');
    }

    /**
     * مکالمات به عنوان فروشنده
     */
    public function sellerConversations()
    {
        return $this->hasMany(Conversation::class, 'seller_id');
    }

    /**
     * وضعیت آنلاین
     */
    public function presence()
    {
        return $this->hasOne(UserPresence::class, 'user_id')
                    ->where('user_type', $this->getUserType());
    }

    // ============================================
    // متدهای کمکی (Helper Methods)
    // ============================================

    /**
     * بررسی مدیر کل بودن
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    /**
     * بررسی مدیر بودن
     */
    public function isAdmin()
    {
        return in_array($this->role, ['super_admin', 'admin', 'editor']);
    }

    /**
     * بررسی شرکت بودن
     */
    public function isCompany()
    {
        return in_array($this->role, ['company_manager', 'company_admin', 'company_user']);
    }

    /**
     * بررسی فروشنده بودن
     */
    public function isSeller()
    {
        return $this->role === 'seller';
    }

    /**
     * بررسی فعال بودن
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * دریافت نوع کاربر برای جداول polymorphic
     */
    public function getUserType()
    {
        if ($this->isAdmin()) {
            return 'manager';
        }
        if ($this->isCompany()) {
            return 'company';
        }
        if ($this->isSeller()) {
            return 'seller';
        }
        return null;
    }

    /**
     * دریافت پیشوند مسیر بر اساس نقش
     */
    public function getRolePrefix()
    {
        if ($this->isAdmin()) {
            return 'management';
        }
        if ($this->isCompany()) {
            return 'company';
        }
        if ($this->isSeller()) {
            return 'seller';
        }
        return '';
    }

    /**
     * دریافت نام نمایشی
     */
    public function getDisplayName()
    {
        return $this->full_name ?: $this->username;
    }

    /**
     * دریافت آواتار پیش‌فرض
     */
    public function getAvatarUrl()
    {
        if ($this->avatar) {
            return asset('uploads/avatars/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->getDisplayName()) . '&background=d4a847&color=fff';
    }

    /**
     * بروزرسانی زمان آخرین ورود
     */
    public function updateLastLogin()
    {
        $this->last_login = now();
        $this->save();
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['super_admin', 'admin', 'editor']);
    }

    public function scopeCompanies($query)
    {
        return $query->whereIn('role', ['company_manager', 'company_admin', 'company_user']);
    }

    public function scopeSellers($query)
    {
        return $query->where('role', 'seller');
    }
}
