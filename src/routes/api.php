<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PasswordForgotController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

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

// パスワードリセット
Route::post('/forgot-password', PasswordForgotController::class);
Route::post('/reset-password', PasswordResetController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // ログインユーザー情報
    Route::get('/profile', ProfileController::class);

    // 定数
    Route::get('/const', fn () => config('const'));

    // 顧客
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/{customer}', [CustomerController::class, 'show']);
    Route::patch('/customers/{customer}', [CustomerController::class, 'update']);
    Route::post('/customers/{customer}/update-avatar', [CustomerController::class, 'updateAvatar']);
});
