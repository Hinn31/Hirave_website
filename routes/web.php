<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\ProductDetailController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Web\ProductController2;

Route::get('/products/search', [ProductController2::class, 'search'])->name('products.search');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

//Reset_password
Route::get('/forgot-password', function () {
    return view('auth.forgot_password');
})->name('forgot.password.form');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])
    ->name('sendOtp');

Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyForm'])
    ->name('verify.form');

Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
    ->name('verify-otp');

Route::get('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])
    ->name('resend-otp');

Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])
    ->name('reset.form');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('reset-password');

Route::get('/success', function () {
    return view('auth.success');
})->name('forgot.password.success');

Route::get('/dashboard', function () {
    return view('test');
})->name('dashboard');

Route::get('/filter-products', function() {
    return view('components.filter-bar');
});

Route::get('/product-card', function() {
    return view('components.product-card');
});

Route::get('/categories-card', function() {
    return view('components.categories-card');
});

Route::get('/Productpage', [ProductController::class, 'productPage'])->name('product.page');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/home', [ProductController::class, 'productPage'])->name('home.page');

Route::get('/trang-chu', [ProductController::class, 'getBestSellers']);
Route::get('api/product/{id}', [ProductDetailController::class,'show']);
Route::get('/product/{id}', [ProductDetailController::class, 'productDetail']);
Route::get('/products/search', [ProductController2::class, 'search'])->name('products.search');

