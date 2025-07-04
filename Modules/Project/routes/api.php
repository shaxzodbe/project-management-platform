<?php

use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\Api\ProjectController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('projects', ProjectController::class)->names('project');
});
