<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;

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


