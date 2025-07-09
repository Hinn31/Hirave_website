<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
    Route::apiResource('users', UserController::class);
});

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});