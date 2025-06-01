<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.info');

    Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::delete('/profile', [ProfileController::class, 'delete'])->name('profile.delete');
});

//  Listing Routes
Route::get('/', [ListingController::class, 'index'])->name('home');
Route::resource('listing', ListingController::class)->except('index');

// Admin Routes
Route::middleware(['auth', 'verified', Admin::class])
    ->controller(AdminController::class)
    ->group(function () {
        Route::get('/admin', 'index')->name('index');
        Route::get('/admin/{user}', 'show')->name('show');
        Route::put('/admin/{user}/role', 'role')->name('role');
        Route::put('/admin/{listing}/status', 'updateStatus')->name('status');
    });


// Blog Routes
Route::group(
    [
        'controller' => BlogController::class,
        'prefix' => 'blogs',
        'as' => 'blogs.'
    ],
    function () {
        Route::get('/', 'show')->name('show');
    }
);

// Auth Routes 
// require __DIR__ . '/auth.php';
require base_path('routes/auth.php');
