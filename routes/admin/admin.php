<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function(){
Route::get('admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
Route::get('admin/users',[AdminController::class,'users'])->name('admin.users');
Route::patch('admin/users/{user}/ban',[AdminController::class,'ban'])->name('admin.ban');
Route::patch('admin/users/{user}/unban',[AdminController::class,'unban'])->name('admin.unban');
});