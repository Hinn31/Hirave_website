<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\ProductFilterController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\ProductDetailController;
use App\Http\Controllers\Api\User\ContactController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\MessageController;

Route::resource('messages', MessageController::class);
// Lấy danh sách đơn hàng
Route::get('/orders', [OrderController::class, 'index']);

// Tạo đơn hàng mới
Route::post('/orders', [OrderController::class, 'store']);

// Cập nhật đơn hàng
Route::put('/orders/{id}', [OrderController::class, 'update']);

// Xóa đơn hàng
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// User
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/users', function () {
    return User::all();
});

// Products
Route::get('/products/filter', [ProductFilterController::class, 'filter']); // lọc nâng cao
Route::get('/search', [ProductController::class, 'search']);               // tìm kiếm
Route::apiResource('products', ProductController::class);                 // CRUD products

// Cart
Route::prefix('cart')->middleware('auth:sanctum')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
});

// Reviews
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reviews', [ProductDetailController::class, 'store'])->name('reviews.store');
});

// Contact
Route::post('/contact/send', [ContactController::class, 'store'])->name('contact.send');

