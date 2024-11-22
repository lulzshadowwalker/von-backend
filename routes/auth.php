<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('auth.register');

Route::post('/auth/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('auth.login');

Route::post('/auth/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('auth.password.email');

//  TODO: Postman documentation
Route::post('/auth/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('auth.password.store');

//  TODO: Postman documentation
Route::get('/auth/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('auth.verification.verify');

//  TODO: Postman documentation
Route::post('/auth/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('auth.verification.send');

Route::post('/auth/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('auth.logout');
