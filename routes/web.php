<?php

use Illuminate\Support\Facades\Route;

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth');
Route::middleware('auth')->group(function () {
    require __DIR__ . '/dashboard.php';
    require __DIR__ . '/invitation/invitation.php';
});
    require __DIR__ . '/auth/register.php';
    require __DIR__ . '/auth/login.php';
