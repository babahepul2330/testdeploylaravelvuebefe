<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "v1"], function () {
    Route::group(["prefix" => "auth"], function () {
        Route::post("login", [AuthController::class, 'login']);
        Route::post("register", [AuthController::class, 'register']);
        Route::post("logout", [AuthController::class, 'logout']);
        Route::post("generate-otp-code", [AuthController::class, 'generateToken']);
        Route::post("verifikasi-akun", [AuthController::class, 'verify']);
    });

    Route::get("me", [AuthController::class, 'me']);
    Route::get("dashboard", [DashboardController::class, 'index'])->name('dashboard');
    Route::post("profile", [AuthController::class, 'updateProfile']);
    Route::apiResource("category", CategoryController::class);
    Route::apiResource("product", ProductController::class);
    Route::get("order/my", [OrderController::class, 'myOrder'])->name('order.my');
    Route::apiResource("order", OrderController::class)->except(["destroy"]);
});
