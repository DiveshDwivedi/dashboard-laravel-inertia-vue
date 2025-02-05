<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::inertia('/', 'Home')->middleware('verified')->name('home');

// Route::get('/register', [RegisterController::class, 'create'])->name('register');
// Route::post('/register', [RegisterController::class, 'store']);

Route::resource('/product', RegisterController::class);
// require __DIR__ . '/auth.php';

require base_path('routes/auth.php');