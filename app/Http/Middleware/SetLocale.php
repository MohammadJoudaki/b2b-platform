<?php
// app/Http/Middleware/SetLocale.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // اولویت: Session → User → Config
        $locale = session('locale');

        if (!$locale && auth()->check()) {
            $locale = auth()->user()->language;
        }

        if (!$locale) {
            $locale = config('app.locale', 'fa');
        }

        if (in_array($locale, ['fa', 'en'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
