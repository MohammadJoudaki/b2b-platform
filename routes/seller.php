<?php
// routes/seller.php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return 'پنل فروشنده - داشبورد';
})->name('dashboard');
