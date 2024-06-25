<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SearchController;

Auth::routes();

// Routes for authenticated users
Route::middleware('auth')->group(function () {
    // Common home route
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // User-specific routes
    Route::middleware('user-access:user')->group(function () {
        Route::get('/home', [HomeController::class, 'userHome'])->name('user.home');
    });

    // Admin-specific routes
    Route::middleware('user-access:admin')->group(function () {
        Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
        Route::resource('users', UserController::class)->except(['show']); // Resourceful routes for users
        Route::resource('products', ProductController::class); // Resourceful routes for products
        Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    });

    // Like and comment routes
    Route::post('/products/{product}/like', [ProductController::class, 'like'])->name('products.like');
    Route::post('/products/{product}/comment', [ProductController::class, 'comment'])->name('products.comment');
});

// Public routes
Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get('/search', [SearchController::class, 'search'])->name('search');
