<?php
// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // بررسی لاگین بودن
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // بررسی نقش کاربر
        if (!in_array($user->role, $roles)) {
            // اگر درخواست AJAX بود
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'شما دسترسی لازم را ندارید.',
                ], 403);
            }

            // هدایت به داشبورد مربوط به نقش خودش
            return redirect()
                ->route($user->getRolePrefix() . '.dashboard')
                ->with('error', 'شما دسترسی لازم را ندارید.');
        }

        // بررسی فعال بودن کاربر
        if (!$user->isActive()) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'حساب کاربری شما غیرفعال است.');
        }

        return $next($request);
    }
}
