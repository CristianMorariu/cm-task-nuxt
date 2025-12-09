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

    /**
     * USERS – doar Admin (users.manage gate).
     */
    Route::middleware('can:users.manage')->group(function () {
        Route::apiResource('users', UserController::class);
    });

    /**
     * PROJECTS – toți pot vedea, doar Manager+Admin pot crea/edita/șterge.
     */
    Route::apiResource('projects', ProjectController::class);

    Route::get('/me', [ProfileController::class, 'show']);
    Route::patch('/me', [ProfileController::class, 'update']);
    Route::patch('/me/password', [ProfileController::class, 'updatePassword']);

    /**
     * TASKS REST – manager/admin au voie să modifice; user poate vedea.
     * Controlăm în TaskController cu $this->authorize().
     */
    Route::apiResource('projects.tasks', TaskController::class)->shallow();

    /**
     * TASKS extra endpoints.
     */
    Route::get('/my-tasks', [TaskController::class, 'myTasks']); // orice user logat

    Route::post('/tasks/{task}/take', [TaskController::class, 'take'])
        ->middleware('can:tasks.take,task');

    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->middleware('can:tasks.update-status,task');
});
