<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\ProductFilterController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/users', function () {
    return User::all();
});

// ⚠️ Đổi đường dẫn tránh trùng GET /api/products
Route::get('/products/filter', [ProductController::class, 'filter']);
// Route::get('/products/search', [ProductController::class, 'search']);
Route::apiResource('products', ProductController::class); // giữ nguyên CRUD
Route::get('/search', [ProductController::class, 'search']);
Route::get('/products/filter', [ProductFilterController::class, 'filter']);


