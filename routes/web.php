<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/catalog', [ProductController::class, 'catalog'])->name('catalog');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/basket', [BasketController::class, 'index'])->name('basket');
    Route::post('/basket/add/{product}', [BasketController::class, 'add'])->name('basket.add');
    Route::put('/basket/update/{item}', [BasketController::class, 'update'])->name('basket.update');
    Route::delete('/basket/remove/{item}', [BasketController::class, 'remove'])->name('basket.remove');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
