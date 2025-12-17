<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // ...
    ];
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::before(function (User $user, string $ability) {
            $roleValue = $user->role instanceof UserRole
                ? $user->role->value
                : $user->role;

            Log::debug('Gate::before', [
                'user_id' => $user->id,
                'role'    => $roleValue,
                'ability' => $ability,
            ]);

            // Admin = all access
            if ($roleValue === UserRole::Admin->value) {
                return true;
            }

            return null; // lasă gate-urile specifice să decidă
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

        // TASKS: update status
        Gate::define('tasks.update-status', function (User $user, Task $task): bool {
            $roleValue = $user->role instanceof UserRole
                ? $user->role->value
                : $user->role;

            // manager + admin pot schimba statusul oricărui task
            if (in_array($roleValue, [UserRole::Admin->value, UserRole::Manager->value], true)) {
                return true;
            }

            // user simplu doar la task-urile lui
            return $task->user_id === $user->id; // adaptează numele coloanei dacă e altul
        });

        // TASKS: take
        Gate::define('tasks.take', function (User $user, Task $task): bool {
            // exemplu simplu: oricine poate "lua" un task nealocat
            return $task->user_id === null;
        });
    }
}
