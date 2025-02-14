<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [AuthenticateController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticateController::class, 'store']);

    Route::get('/login/{provider}', [AuthenticateController::class, 'redirectToProvider'])->name('redirect');
    Route::get('/provider/{callback}', [AuthenticateController::class, 'handleProviderCallback'])->name('callback');


    // reset password 
    Route::get('/forgot-password', [ResetPasswordController::class, 'requestPassword'])->name('password.request');

    Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetForm'])->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'resetHnadler'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticateController::class, 'logout'])->name('logout');

    // ---------- Email Verifications -------------
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'handler'])->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');

    //  -------- confirm password ---------
    Route::get('/confirm-password', [ConfirmPasswordController::class, 'create'])->name('password.confirm');

    Route::post('/confirm-password', [ConfirmPasswordController::class, 'confirmPassword'])->middleware('throttle:6,1');
});