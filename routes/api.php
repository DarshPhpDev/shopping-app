<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Define rate limiter
Route::middleware('throttle:30,1')->group(function () {

    // Public Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/products', [ProductController::class, 'index']);


    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    
});