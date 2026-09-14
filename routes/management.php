<?php
// routes/management.php

use Illuminate\Support\Facades\Route;
Route::get('/dashboard', function () {
    return view('management.dashboard');
})->name('dashboard');
