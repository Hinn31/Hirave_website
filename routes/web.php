<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\ProductDetailController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Web\ProductController2;

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
