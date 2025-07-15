<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;


// Route::get('/register', function () {
//     return view('auth.register');
// });

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

Route::get('/dashboard', function () {
    return view('test');
})->name('dashboard');

