<?php

use App\Enums\UserRoleEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenerationController;

Route::middleware(['enable.cors', 'throttle:api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {

        Route::middleware(['role:' . UserRoleEnum::ADMIN->value])->group(function () {
            Route::apiResource('generations', GenerationController::class);
        });
    });
});
