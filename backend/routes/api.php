<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskEntriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('tasks',[TaskController::class,'index']);
Route::get('tasks/{task}',[TaskController::class, 'show']);
Route::post('tasks',[TaskController::class,'store']);

Route::get('task-entry',[TaskEntriesController::class,'index']);
Route::post('task-entry',[TaskEntriesController::class,'updateOrCreate']);