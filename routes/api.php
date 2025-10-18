<?php

// routes/api.php
use App\Enums\UserRoleEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DevisionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\GenerationController;

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
                ->except('index', 'show');
            // Devision
            Route::apiResource('devision', DevisionController::class)
                ->except('index', 'show');
            // Student
            Route::apiResource('student', StudentController::class)
                ->except('index', 'show');
        });
    });
    // Generation
    Route::get('generation', [GenerationController::class, 'index']);
    Route::get('generation/{id}', [GenerationController::class, 'show']);
    // Position
    Route::get('position', [PositionController::class, 'index']);
    Route::get('position/{id}', [PositionController::class, 'show']);
    // Devision
    Route::get('devision', [DevisionController::class, 'index']);
    Route::get('devision/{id}', [DevisionController::class, 'show']);
    // Student
    Route::get('student', [StudentController::class, 'index']);
    Route::get('student/{id}', [StudentController::class, 'show']);
});
