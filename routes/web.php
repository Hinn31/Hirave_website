<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

// Reset password
Route::get('/forgot-password', function() {
    return view('forgot_password');
});
Route::get('/verification', function() {
    return view('verification');
});
