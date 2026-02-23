<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
Route::get('register', [AuthController::class, "showRegister"])->name('register');
Route::post('register', [AuthController::class, "register"]);