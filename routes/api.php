<?php

// routes/api.php
use App\Http\Controllers\AuthController;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\GenerationController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['enable.cors', 'throttle:api'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);


    // Google Login
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::middleware(['role:' . UserRoleEnum::ADMIN->value])->group(function () {
            // Generation
            Route::apiResource('generation', GenerationController::class)
                ->except('index', 'show');
            // Position
            Route::apiResource('position', PositionController::class)
            ->except('index','show');
        });
    });
    // Generation
    Route::get('generation', [GenerationController::class, 'index']);
    Route::get('generation/{id}', [GenerationController::class, 'show']);
    // Position
    Route::get('position', [PositionController::class, 'index']);
    Route::get('position/{id}', [PositionController::class, 'show']);
});
