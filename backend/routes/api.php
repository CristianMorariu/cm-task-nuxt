<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskEntriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tasks',[TaskController::class,'index']);
Route::get('tasks/{task}',[TaskController::class, 'show']);
Route::post('tasks',[TaskController::class,'store']);

Route::get('task-entry',[TaskEntriesController::class,'index']);
Route::get('task-entry/{task_id}',[TaskEntriesController::class, 'show']);
Route::post('task-entry',[TaskEntriesController::class,'updateOrCreate']);

require __DIR__.'/auth.php';