<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories management
    Route::resource('categories', CategoryController::class);
    
    // Products management
    Route::resource('products', ProductController::class);
    Route::delete('products/images/{id}', [ProductController::class, 'deleteImage'])->name('products.delete-image');
});