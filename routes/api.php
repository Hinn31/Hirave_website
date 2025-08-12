<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\ProductFilterController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\ProductDetailController;


// routes/api.php
Route::prefix('cart')->middleware('auth:sanctum')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
// routes/api.php
Route::middleware('auth:sanctum')
    ->post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/users', function () {
    return User::all();
});

// ⚠️ Đổi đường dẫn tránh trùng GET /api/products
Route::get('/products/filter', [ProductController::class, 'filter']);
// Route::get('/products/search', [ProductController::class, 'search']);
Route::apiResource('products', ProductController::class); // giữ nguyên CRUD
Route::get('/search', [ProductController::class, 'search']);
Route::get('/products/filter', [ProductFilterController::class, 'filter']);

// routes/api.php
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reviews', [ProductDetailController::class, 'store']);
});

