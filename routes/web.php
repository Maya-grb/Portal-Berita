<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news/{id}/json', [NewsController::class, 'getNewsJson'])->name('news.json');
Route::get('/category/{id}/news', [NewsController::class, 'byCategory'])->name('category.news');

// Guest routes (login only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes (protected)
Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('news', NewsController::class)->except(['show']);
    Route::post('/news/upload-image', [NewsController::class, 'uploadImage'])->name('news.uploadImage');
});