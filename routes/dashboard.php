<?php

use App\Http\Controllers\ColocationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [ColocationController::class, 'dashboard'])->name('dashboard');

    Route::resource('colocation', ColocationController::class);
    Route::post('colocation/{colocation}/cancel', [ColocationController::class, 'cancel'])
    ->name('colocation.cancel');
    // Route::resource('categories', CategoryController::class)->only(['index','store','destroy']);

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});