<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    require __DIR__ . '/dashboard.php';
    require __DIR__ . '/invitation/invitation.php';
    Route::post('logout', [AuthController::class, "logout"])->name('logout');
});
Route::middleware(AuthMiddleware::class)->group(function () {
    require __DIR__ . '/auth/register.php';
    require __DIR__ . '/auth/login.php';
});