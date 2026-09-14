<?php
// app/Http/Requests/Auth/LoginRequest.php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login_role'  => ['required', 'in:seller,company'],
            'phone'       => ['required_if:login_role,seller', 'nullable', 'string'],
            'unique_code' => ['required_if:login_role,company', 'nullable', 'string'],
            'password'    => ['required', 'string'],
        ];
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $loginRole = $this->input('login_role');
        $password  = $this->input('password');
        $remember  = $this->boolean('remember');

        // ورود فروشنده: با شماره تلفن
        if ($loginRole === 'seller') {
            $this->authenticateSeller($password, $remember);
        }
        // ورود شرکت: با شناسه یکتا
        elseif ($loginRole === 'company') {
            $this->authenticateCompany($password, $remember);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * احراز هویت فروشنده با شماره تلفن
     */
    protected function authenticateSeller($password, $remember)
    {
        $phone = $this->normalizePhone($this->input('phone'));

        $user = User::where('phone', $phone)
                    ->where('role', 'seller')
                    ->first();

        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'phone' => __('auth.failed'),
            ]);
        }

        if (!Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'password' => __('auth.failed'),
            ]);
        }

        if (!$user->isActive()) {
            throw ValidationException::withMessages([
                'phone' => __('حساب کاربری شما غیرفعال است.'),
            ]);
        }

        // بررسی وجود رکورد در جدول sellers
        if (!$user->seller) {
            throw ValidationException::withMessages([
                'phone' => __('اطلاعات فروشنده یافت نشد. لطفاً با پشتیبانی تماس بگیرید.'),
            ]);
        }

        Auth::login($user, $remember);
    }

    /**
     * احراز هویت شرکت با شناسه یکتا
     */
    protected function authenticateCompany($password, $remember)
    {
        $uniqueCode = strtoupper(trim($this->input('unique_code')));

        $user = User::where('unique_code', $uniqueCode)
                    ->whereIn('role', ['company_manager', 'company_admin', 'company_user'])
                    ->first();

        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'unique_code' => __('auth.failed'),
            ]);
        }

        if (!Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'password' => __('auth.failed'),
            ]);
        }

        if (!$user->isActive()) {
            throw ValidationException::withMessages([
                'unique_code' => __('حساب کاربری شما غیرفعال است.'),
            ]);
        }

        // بررسی وجود رکورد در جدول companies
        if (!$user->company) {
            throw ValidationException::withMessages([
                'unique_code' => __('اطلاعات شرکت یافت نشد. لطفاً با پشتیبانی تماس بگیرید.'),
            ]);
        }

        Auth::login($user, $remember);
    }

    /**
     * یکسان‌سازی شماره تلفن
     */
    protected function normalizePhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strpos($phone, '98') === 0) {
            $phone = '0' . substr($phone, 2);
        }

        if (strpos($phone, '9') === 0) {
            $phone = '0' . $phone;
        }

        return $phone;
    }

    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'password' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey()
    {
        $identifier = $this->input('phone') ?? $this->input('unique_code') ?? 'unknown';
        return Str::transliterate(Str::lower($identifier) . '|' . $this->ip());
    }
}
