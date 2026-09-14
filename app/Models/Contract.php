<?php
// app/Models/Contract.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'contract_number',
        'contract_date',
        'start_date',
        'end_date',
        'contract_type',
        'company_representative',
        'company_representative_title',
        'manager_representative',
        'manager_representative_title',
        'terms',
        'special_conditions',
        'payment_terms',
        'commission_rate',
        'status',
        'company_confirmed',
        'manager_confirmed',
        'company_confirmed_at',
        'manager_confirmed_at',
        'company_notes',
        'company_response_status',
        'company_response_date',
        'signed_at',
        'confirmed_at',
    ];

    protected $casts = [
        'contract_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'commission_rate' => 'decimal:2',
        'company_confirmed' => 'boolean',
        'manager_confirmed' => 'boolean',
        'company_confirmed_at' => 'datetime',
        'manager_confirmed_at' => 'datetime',
        'company_response_date' => 'datetime',
        'signed_at' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    // ============================================
    // روابط
    // ============================================

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // ============================================
    // متدها
    // ============================================

    /**
     * بررسی فعال بودن قرارداد
     */
    public function isActive()
    {
        return $this->status === 'active'
            && $this->start_date <= now()
            && $this->end_date >= now();
    }

    /**
     * بررسی منقضی شدن
     */
    public function isExpired()
    {
        return $this->end_date < now();
    }

    /**
     * بررسی تایید نهایی
     */
    public function isFullyConfirmed()
    {
        return $this->company_confirmed && $this->manager_confirmed;
    }

    /**
     * بررسی در انتظار تایید
     */
    public function isPending()
    {
        return in_array($this->status, ['pending', 'pending_manager']);
    }

    /**
     * تایید توسط شرکت
     */
    public function confirmByCompany()
    {
        $this->company_confirmed = true;
        $this->company_confirmed_at = now();
        $this->company_response_status = 'accepted';
        $this->company_response_date = now();

        if ($this->manager_confirmed) {
            $this->status = 'active';
            $this->confirmed_at = now();
        } else {
            $this->status = 'pending_manager';
        }

        $this->save();
    }

    /**
     * تایید توسط مدیر
     */
    public function confirmByManager()
    {
        $this->manager_confirmed = true;
        $this->manager_confirmed_at = now();

        if ($this->company_confirmed) {
            $this->status = 'active';
            $this->confirmed_at = now();
        }

        $this->save();
    }

    /**
     * رد توسط شرکت
     */
    public function rejectByCompany($notes = null)
    {
        $this->company_response_status = 'rejected';
        $this->company_response_date = now();
        $this->company_notes = $notes;
        $this->status = 'terminated';
        $this->save();
    }

    /**
     * خاتمه قرارداد
     */
    public function terminate()
    {
        $this->status = 'terminated';
        $this->save();
    }

    /**
     * دریافت روزهای باقی‌مانده
     */
    public function getRemainingDays()
    {
        if ($this->isExpired()) {
            return 0;
        }
        return now()->diffInDays($this->end_date);
    }

    // ============================================
    // Boot
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contract) {
            if (empty($contract->contract_number)) {
                $contract->contract_number = 'CTR-' . date('Ymd') . '-' . rand(1000, 9999);
            }
        });
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('end_date', '>=', now());
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'pending_manager']);
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
