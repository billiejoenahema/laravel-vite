<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\Password\PasswordForgotController;
use App\Http\Controllers\Api\Password\PasswordResetController;
use App\Http\Controllers\Api\ProfileController;
use App\Models\Notice;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
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
Route::post('/reset-password', PasswordResetController::class)->middleware([HandlePrecognitiveRequests::class]);

Route::group(['middleware' => ['auth:sanctum','cache.headers:no_store;max_age=0',]], static function () {

    // ログインユーザー情報
    Route::get('/profile', ProfileController::class);

    // 定数
    Route::get('/const', static fn () => config('const'));

    // 顧客
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::get('/customers/{customer}', [CustomerController::class, 'show']);
    Route::patch('/customers/{customer}', [CustomerController::class, 'update']);
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->can('delete', 'customer');
    Route::patch('/customers/{trashed_customer}/restore', [CustomerController::class, 'restore'])->can('restore', 'trashed_customer');
    Route::post('/customers/{customer}/avatar', [CustomerController::class, 'updateAvatar']);
    Route::delete('/customers/{customer}/avatar', [CustomerController::class, 'deleteAvatar'])->can('delete', 'customer');

    // お知らせ
    Route::get('/notices', [NoticeController::class, 'index']);
    Route::post('/notices', [NoticeController::class, 'store'])->can('create', Notice::class);
    Route::get('/notices/{notice}', [NoticeController::class, 'show']);
    Route::patch('/notices/{notice}', [NoticeController::class, 'update'])->can('update', 'notice');
    Route::delete('/notices/{notice}', [NoticeController::class, 'destroy'])->can('delete', 'notice');
});
