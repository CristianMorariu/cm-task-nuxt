<?php

use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
// ====== GATES & ROLE LOGIC ======
use Illuminate\Support\Facades\Gate;

Gate::before(function (User $user, string $ability) {
    $roleValue = $user->role instanceof UserRole
        ? $user->role->value
        : $user->role;

    // Admin = full access
    if ($roleValue === UserRole::Admin->value) {
        return true;
    }

    return null; // lasă restul gate-urilor să decidă
});

// USERS: doar admin
Gate::define('users.manage', function (User $user): bool {
    $roleValue = $user->role instanceof UserRole
        ? $user->role->value
        : $user->role;

    return $roleValue === UserRole::Admin->value;
});

// PROJECTS: toți pot vedea
Gate::define('projects.view', fn (User $user) => true);

// PROJECTS: doar manager + admin modifică
Gate::define('projects.manage', function (User $user): bool {
    $roleValue = $user->role instanceof UserRole
        ? $user->role->value
        : $user->role;

    return in_array($roleValue, [
        UserRole::Admin->value,
        UserRole::Manager->value,
    ], true);
});

// TASKS: doar manager + admin CRUD
Gate::define('tasks.manage', function (User $user): bool {
    $roleValue = $user->role instanceof UserRole
        ? $user->role->value
        : $user->role;

    return in_array($roleValue, [
        UserRole::Admin->value,
        UserRole::Manager->value,
    ], true);
});

// TASKS: update status: manager/admin la toate, user doar la ale lui
Gate::define('tasks.update-status', function (User $user, Task $task): bool {
    $roleValue = $user->role instanceof UserRole
        ? $user->role->value
        : $user->role;

    if (in_array($roleValue, [
        UserRole::Admin->value,
        UserRole::Manager->value,
    ], true)) {
        return true;
    }

    // user simplu doar la task-urile lui
    return $task->user_id === $user->id; // adaptează numele coloanei dacă e altul
});

// TASKS: take – exemplu simplu
Gate::define('tasks.take', function (User $user, Task $task): bool {
    return $task->user_id === null;
});
// ====== ROUTES ======
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
    // USERS – doar Admin
    Route::middleware('can:users.manage')->group(function () {
        Route::apiResource('users', UserController::class);
    });

    // PROJECTS – toți pot vedea, Manager+Admin modifică (control în controller)
    Route::apiResource('projects', ProjectController::class);

    // ME – oricine e logat
    Route::get('/me', [ProfileController::class, 'show']);
    Route::patch('/me', [ProfileController::class, 'update']);
    Route::patch('/me/password', [ProfileController::class, 'updatePassword']);

    // TASKS REST
    Route::apiResource('projects.tasks', TaskController::class)->shallow();

    // TASKS extra endpoints
    Route::get('/my-tasks', [TaskController::class, 'myTasks']);

    Route::post('/tasks/{task}/take', [TaskController::class, 'take'])
        ->middleware('can:tasks.take,task');

    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->middleware('can:tasks.update-status,task');
});
