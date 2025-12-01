<?php

use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Cache;

Route::get('/meta/roles', function () {
    // cache optional, 1 oră
    return Cache::remember('meta.roles', 3600, function () {
        $data = array_map(
            fn(UserRole $r) => ['key' => $r->value, 'label' => $r->label()],
            UserRole::cases()
        );
        return response()->json(['data' => $data]);
    });
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('users', UserController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [ProfileController::class, 'show']);
    Route::patch('/me', [ProfileController::class, 'update']);
    Route::patch('/me/password', [ProfileController::class, 'updatePassword']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects.tasks', TaskController::class)->shallow();

    Route::get('/my-tasks', [TaskController::class, 'myTasks']);
    Route::post('/tasks/{task}/take', [TaskController::class, 'take']);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus']);
});
