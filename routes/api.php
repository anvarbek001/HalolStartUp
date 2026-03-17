<?php

use App\Http\Controllers\Api\BrandsController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('customer')->group(function () {
    Route::post('/register', [CustomerController::class, 'register']);
    Route::post('/login', [CustomerController::class, 'login']);
});

Route::prefix('customer')->middleware('auth:sanctum')->group(function () {
    Route::post('/profile', [CustomerController::class, 'profile']);
    Route::post('/logout', [CustomerController::class, 'logout']);
});

Route::prefix('brands')->group(function () {
    Route::get('/index', [BrandsController::class, 'index']);
});
