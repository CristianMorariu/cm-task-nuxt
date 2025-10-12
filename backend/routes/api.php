<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json(['data' => $request->user()]);
});
// Route::middleware('auth:sanctum')->group(function () {
// });
Route::apiResource('projects', ProjectController::class);
// Route::apiResource('projects.tasks', TaskController::class)->scoped();
// // filtru global tasks (ex. tabloul „My Tasks”)
// Route::get('tasks', [TaskIndexController::class, '__invoke']); // ?status=&due=&q=&project_id=