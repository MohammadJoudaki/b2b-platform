<?php
// app/Http/Controllers/Auth/AuthenticatedSessionController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // بروزرسانی آخرین ورود
        $user->updateLastLogin();

        // محاسبه URL هدایت
        $redirectUrl = route($user->getRolePrefix() . '.dashboard');

        // اگر درخواست AJAX بود، JSON برگردان
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => $redirectUrl,
                'user' => [
                    'name' => $user->getDisplayName(),
                    'role' => $user->role,
                ],
            ]);
        }

        return redirect()->intended($redirectUrl);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
