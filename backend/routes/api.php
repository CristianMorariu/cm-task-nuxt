<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ProjectController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);
// Route::middleware('auth:sanctum')->group(function () {
// });
Route::apiResource('projects', ProjectController::class);
// Route::apiResource('projects.tasks', TaskController::class)->scoped();
// // filtru global tasks (ex. tabloul „My Tasks”)
// Route::get('tasks', [TaskIndexController::class, '__invoke']); // ?status=&due=&q=&project_id=