<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(JwtMiddleware::class)->group(function () {
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::post('/products/generate-estimate', [ProductController::class, 'generateProductEstimate']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

