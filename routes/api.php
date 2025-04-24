<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// 註冊路由
Route::post('register', [AuthController::class, 'register'])->middleware('throttle:auth');
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:auth');

// 使用 Sanctum 的身份驗證中介層，保護下列路由
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // 用戶資訊
    Route::get('me', [AuthController::class, 'me']);
    // 登出路由
    Route::post('logout', [AuthController::class, 'logout']);
    // 產品資源路由
    Route::apiResource('products', ProductController::class);
    // 產品分類資源路由
    Route::apiResource('categories', CategoryController::class);
});
