<?php

use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;
// dd('rrrrrr');
Route::post('colocation/{colocation}/send', [InvitationController::class, 'send'])->name('invitation.send');
Route::get('invitaion/accept/{token}', [InvitationController::class, 'accept'])->name('invitation.accept');
Route::get('invitation/refuse/{token}',[InvitationController::class,'refuse'])->name('invitation.refuse');