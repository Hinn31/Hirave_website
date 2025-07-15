<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});
//Reset_password
Route::get('/forgot-password', function () {
    return view('auth.forgot_password');
})->name('forgot.password.form');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])
    ->name('forgot.password.send');

Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyForm'])
    ->name('forgot.password.verify.form');

Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
    ->name('forgot.password.verify');
Route::get('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('forgot.password.resend');

Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])
    ->name('forgot.password.reset.form');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('forgot.password.reset');

Route::get('/success', function () {
    return view('auth.success');
})->name('forgot.password.success');
