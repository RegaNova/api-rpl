<?php

// routes/api.php
use App\Http\Controllers\AuthController;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\GenerationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['enable.cors', 'throttle:api'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Google Login
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::middleware(['role:' . UserRoleEnum::ADMIN->value])->group(function () {
                Route::apiResource('generation', GenerationController::class)
                ->except('index','show');
        });
    });
    Route::get('generation',[GenerationController::class,'index']);
    Route::get('generation/{id}',[GenerationController::class,'show']);
});