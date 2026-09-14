<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_level',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    // ============================================
    // روابط
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * بررسی داشتن دسترسی خاص
     */
    public function hasPermission($permission)
    {
        // مدیر کل همه دسترسی‌ها را دارد
        if ($this->admin_level === 'super_admin') {
            return true;
        }

        // بررسی دسترسی‌های اختصاصی
        $permissions = $this->permissions ?? [];
        return in_array($permission, $permissions) || in_array('*', $permissions);
    }

    /**
     * بررسی سطح مدیر
     */
    public function isSuperAdmin()
    {
        return $this->admin_level === 'super_admin';
    }

    public function isAdmin()
    {
        return in_array($this->admin_level, ['super_admin', 'admin']);
    }

    public function isEditor()
    {
        return $this->admin_level === 'editor';
    }

    /**
     * دریافت نام نمایشی
     */
    public function getDisplayName()
    {
        return $this->user ? $this->user->getDisplayName() : 'مدیر';
    }
}
