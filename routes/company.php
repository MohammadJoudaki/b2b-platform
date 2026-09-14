<?php
// routes/company.php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return 'پنل شرکت - داشبورد';
})->name('dashboard');
