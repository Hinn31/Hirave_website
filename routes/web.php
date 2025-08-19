<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\ProductDetailController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Web\ProductController2;
use App\Http\Controllers\Api\User\ProductManagementController;

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth - Register/Login
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Auth - Forgot Password
Route::get('/forgot-password', function () {
    return view('auth.forgot_password');
})->name('forgot.password.form');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('sendOtp');
Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyForm'])->name('verify.form');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('verify-otp');
Route::get('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('resend-otp');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');
Route::get('/success', function () {
    return view('auth.success');
})->name('forgot.password.success');

// Dashboard
Route::get('/dashboard', function () {
    return view('test');
})->name('dashboard');

// Products
Route::get('/Productpage', [ProductController::class, 'productPage'])->name('product.page');
Route::get('/home', [ProductController::class, 'productPage'])->name('home.page');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/trang-chu', [ProductController::class, 'getBestSellers']);
Route::get('/product/{id}', [ProductDetailController::class, 'productDetail']);
Route::get('/products/search', [ProductController2::class, 'search'])->name('products.search');

// Profile
Route::get('/profile/user/{id}', [UserController::class, 'show'])->name('profile.show');
Route::post('/users/{id}', [UserController::class, 'update'])->name('profile.update');

// Pages
Route::get('/payment', function() { return view('pages.payment'); });
Route::get('/cart', function() { return view('pages.cart'); })->name('cart.page');
Route::get('/about', function() { return view('pages.about-us'); });
Route::get('/contact', function() { return view('pages.contacts'); })->name('contacts');

// Components (nội dung tách riêng)
Route::get('/filter-products', function() { return view('components.filter-bar'); });
Route::get('/product-card', function() { return view('components.product-card'); });
Route::get('/categories-card', function() { return view('components.categories-card'); });
Route::get('/successs_one', function() { return view('components.success_one'); });

Route::get('/successs_one', function () {
    return view('components.success_one');
})->name('component.success_one');

// routes/web.php
Route::get('/order_management', function () {
    return view('pages.order_management'); // trỏ đến file resources/views/test-ui.blade.php
});

Route::prefix('admin/product-management')->group(function () {
    Route::get('/', [ProductManagementController::class, 'index'])->name('product-management.index');
    Route::get('/create', [ProductManagementController::class, 'create'])->name('product-management.create');
    Route::post('/', [ProductManagementController::class, 'store'])->name('product-management.store');
    Route::get('/{id}/edit', [ProductManagementController::class, 'edit'])->name('product-management.edit');
    Route::put('/{id}', [ProductManagementController::class, 'update'])->name('product-management.update');
    Route::delete('/{id}', [ProductManagementController::class, 'destroy'])->name('product-management.destroy');
    Route::get('/search', [ProductManagementController::class, 'search'])->name('product-management.search');
});
Route::get('/messages_managements', function () {
    $messages = [
        (object)[
            'id' => 1,
            'first_name' => 'Võ Thị Thu Hiền',
            'last_name' => 'Hiền31',
            'phone' => '0876068001',
            'email' => 'hien.vo26@student.passerellesnumeriques.org',
            'message' => 'Xin chào shop'
        ],
        (object)[
            'id' => 2,
            'first_name' => 'Nguyễn Văn A',
            'last_name' => 'An',
            'phone' => '01-01-2000',
            'email' => 'vana@example.com',
            'message' => 'Tôi muốn hỏi thêm thông tin'
        ],
    ];

    // chỉ gọi tới file messages_managements.blade.php
return view('pages.messages_managements', compact('messages'));
})->name('messages.index');


Route::get('/users', function () {
    return 'Trang quản lý User';
})->name('users.index');

Route::get('/orders', function () {
    return 'Trang quản lý User';
})->name('orders.index');
