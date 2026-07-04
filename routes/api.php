<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//  Limit Requests to 5 per minute for the order routes order controller noted
Route::middleware(['throttle:5,1'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
});

// only authenticated admin can access the get orders and update order status routes noted
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});