<?php
// routes/web.php

use Illuminate\Support\Facades\Route;

// Frontend
require __DIR__ . '/frontend.php';

// Auth
require __DIR__ . '/auth.php';

// Management Panel
Route::middleware(['auth', 'role:super_admin,admin,editor'])
    ->prefix('management')
    ->name('management.')
    ->group(function () {
        require __DIR__ . '/management.php';
    });

// Company Panel
Route::middleware(['auth', 'role:company_manager,company_admin,company_user'])
    ->prefix('company')
    ->name('company.')
    ->group(function () {
        require __DIR__ . '/company.php';
    });

// Seller Panel
Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        require __DIR__ . '/seller.php';
    });
    // Language Switch
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fa', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');
