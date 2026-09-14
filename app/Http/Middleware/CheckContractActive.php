<?php
// app/Http/Middleware/CheckContractActive.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckContractActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // فقط برای شرکت‌ها و فروشندگان
        if ($user->isCompany() || $user->isSeller()) {
            // بررسی تاریخ قرارداد
            if ($user->contract_date && $user->contract_end_date) {
                if (now()->gt($user->contract_end_date)) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'قرارداد شما منقضی شده است.',
                        ], 403);
                    }

                    return redirect()
                        ->route($user->getRolePrefix() . '.dashboard')
                        ->with('warning', 'قرارداد شما منقضی شده است. لطفاً با مدیر تماس بگیرید.');
                }
            }
        }

        return $next($request);
    }
}
