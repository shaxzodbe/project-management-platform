<?php

use Illuminate\Support\Facades\Route;
use Modules\Task\Http\Controllers\Api\TaskController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::prefix('tasks')->group(function () {
        Route::patch('/{task}/assign', [TaskController::class, 'assign']);
        Route::patch('/{task}/status', [TaskController::class, 'updateStatus']);
    });
    Route::apiResource('tasks', TaskController::class)->names('task');
});
