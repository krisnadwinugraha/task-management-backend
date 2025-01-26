<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TaskCommentController;
use App\Http\Controllers\API\ActivityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Task routes
    Route::apiResource('tasks', TaskController::class);

    // Task comments routes
    Route::get('tasks/{task}/comments', [TaskCommentController::class, 'index']);
    Route::post('tasks/{task}/comments', [TaskCommentController::class, 'store']);
    Route::delete('tasks/{task}/comments/{comment}', [TaskCommentController::class, 'destroy']);

    // Task activities routes
    Route::get('activities', [ActivityController::class, 'taskActivities']);
    Route::apiResource('users', UserController::class);
});
