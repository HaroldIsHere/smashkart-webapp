<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/add-to-cart/{id}', [MainController::class, 'addToCart'])->name('add.to.cart');
Route::delete('/cart/remove-by-name/{name}', [MainController::class, 'removeByName'])->name('cart.removeByName');

// Product routes
Route::get('/products/bagView/{name}', [LinkController::class, 'bagView'])->name('products.bagView');
Route::get('/products/badView/{name}', [LinkController::class, 'badView'])->name('products.badView');
Route::get('/products/shoeView/{name}', [LinkController::class, 'shoeView'])->name('products.shoeView');
Route::get('/products/accessoriesView/{name}', [LinkController::class, 'accessoriesView'])->name('products.accessoriesView');
Route::get('/products/appView/{name}', [LinkController::class, 'appView'])->name('products.appView');

Route::get('/products/bags', [LinkController::class, 'bag'])->name('products.bags');
Route::get('/products/productLibrary/{category}', [LinkController::class, 'productLibrary'])->name('products.productLibrary');


// Cart routes
Route::get('/cart', [LinkController::class, 'cart'])->name('cart.index');
Route::post('/cart/update-quantity/{name}', [LinkController::class, 'updateQuantity']);
Route::get('/cart/summary', [LinkController::class, 'cartSummary']);
Route::get('/cart/count', [\App\Http\Controllers\LinkController::class, 'count']);
Route::get('/cart/mini', [\App\Http\Controllers\LinkController::class, 'mini']);

// Payment routes
Route::get('/history', [LinkController::class, 'history'])->middleware('auth')->name('payment.history');


Route::get('/cart/count', function () {
    return response()->json(['count' => count(session('cart', []))]);
});

Route::post('/cart/add/{type}/{id}', [MainController::class, 'addToCart'])->name('cart.add');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Authenticated user routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/acc', [LinkController::class, 'account'])->name('acc.acc');
    // Payment routes
    Route::get('/checkout', [LinkController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [LinkController::class, 'processCheckout'])->name('checkout.process');
});

// Admin routes
require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [LinkController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [LinkController::class, 'users'])->name('users');
    Route::get('/settings', [LinkController::class, 'settings'])->name('settings');
    Route::get('/report-inventory', [LinkController::class, 'reportInventory'])->name('reportInventory'); // <-- Add this line
    Route::post('/logout', [LinkController::class, 'logout'])->name('logout');
    Route::get('/adminPage', [LinkController::class, 'adminPage'])->name('adminPage');
    Route::get('/orders', [LinkController::class, 'orderManagement'])->name('orders');
    Route::patch('/transaction/{transaction}/status', [LinkController::class, 'updateStatus'])->name('transaction.status');
});

