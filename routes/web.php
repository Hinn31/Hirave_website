<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

// Reset password
Route::get('/reset-password', function() {
    return view('reset_password');
});
