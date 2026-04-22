<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/category/{id}/news', [NewsController::class, 'byCategory'])->name('category.news');
Route::get('/news/{id}/json', [NewsController::class, 'getNewsJson'])->name('news.json');

// ==================== AUTHENTICATION ROUTES ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==================== ADMIN ROUTES ====================
Route::middleware('auth')->group(function () {
    // Category Management
    Route::resource('categories', CategoryController::class);
    
    // News Management (exclude show because already defined in public)
    Route::resource('news', NewsController::class)->except(['show']);
    
    // Upload image for summernote
    Route::post('/news/upload-image', [NewsController::class, 'uploadImage'])->name('news.uploadImage');
});
