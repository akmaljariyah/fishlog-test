<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('me', [AuthController::class, 'login'])->name('auth.login');
Route::delete('me', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth')->group(static function (): void {
    Route::get('ping', static fn () => null);

    // Akun routes
    Route::apiResource('user', UserController::class);
    Route::post('user/search/email', [UserController::class, 'getUserByEmail']);
});
