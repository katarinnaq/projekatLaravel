<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;



use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/', [ProductController::class, 'home'])->name('home');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('products', App\Http\Controllers\ProductController::class);
Route::resource('categories', App\Http\Controllers\CategoryController::class);

Route::resource('carts', App\Http\Controllers\CartController::class);

Route::resource('cart-items', App\Http\Controllers\CartItemController::class);

Route::resource('orders', App\Http\Controllers\OrderController::class);

Route::resource('order-items', App\Http\Controllers\OrderItemController::class);


// ruta za kategorije - samo admin

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
});

// ruta za listu svih proizvoda i edit - samo admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.edit');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.create');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::patch('/orders/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');
});


Route::post('/cart/checkout', [CartController::class, 'checkout'])
    ->middleware('auth')
    ->name('cart.checkout');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

