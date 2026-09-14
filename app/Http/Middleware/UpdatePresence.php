<?php
// app/Http/Middleware/UpdatePresence.php

namespace App\Http\Middleware;

use App\Models\UserPresence;
use Closure;
use Illuminate\Http\Request;

class UpdatePresence
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
        if (auth()->check()) {
            $user = auth()->user();
            $userType = $user->getUserType();

            if ($userType) {
                // بروزرسانی حضور (فقط هر ۳۰ ثانیه یک‌بار)
                $presence = UserPresence::where('user_id', $user->id)
                                        ->where('user_type', $userType)
                                        ->first();

                if (!$presence || $presence->last_seen->diffInSeconds(now()) > 30) {
                    UserPresence::updatePresence($user->id, $userType);
                }
            }
        }

        return $next($request);
    }
}
