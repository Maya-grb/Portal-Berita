<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;


Route::get('/', [NewsController::class, 'index']);

Route::get('/admin', function () {
    return view('admin.dashboard');
});
Route::resource('categories', CategoryController::class);
Route::resource('categories', \App\Http\Controllers\CategoryController::class);

Route::controller(NewsController::class)->prefix('news')->group(function () {
    Route::get('/', 'index')->name('news.index');
    Route::get('/create', 'create')->name('news.create');
    Route::post('/store', 'store')->name('news.store');
    Route::get('/{news}/edit', 'edit')->name('news.edit');
    Route::put('/{news}', 'update')->name('news.update');
    Route::delete('/{news}', 'destroy')->name('news.destroy');
    Route::post('/upload-image', 'uploadImage')->name('news.uploadImage');
});