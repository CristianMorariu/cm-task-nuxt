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

    public function boot(): void
    {
        $this->registerPolicies();

        /**
         * Admin: full access la orice ability.
         */
        Gate::before(function (User $user, string $ability) {
         Log::info('Gate::before', [
        'user_id' => $user->id,
        'role' => $user->role,
        'ability' => $ability,
    ]);
        // if ($user->role instanceof UserRole && $user->role === UserRole::Admin) {
        //     return true;
        // }
        // // fallback 
        // if (is_string($user->role) && $user->role === UserRole::Admin->value) {
        //     return true;
        // }

        // return null;
    });

        /**
         * USERS: doar Admin are voie să vadă/editeze users.
         */
        Gate::define('users.manage', function (User $user): bool {
            return $user->role === UserRole::Admin;
        });

        /**
         * PROJECTS: toți pot *vedea* proiectele.
         */
        Gate::define('projects.view', function (User $user): bool {
            return true; 
        });

        /**
         * PROJECTS: doar Admin + Manager pot crea / edita / șterge proiecte.
         */
        Gate::define('projects.manage', function (User $user): bool {
            return in_array($user->role, [UserRole::Manager], true);
      
        });

        /**
         * TASKS: doar Admin + Manager pot crea / edita / șterge task-uri.
         */
        Gate::define('tasks.manage', function (User $user): bool {
            return in_array($user->role, [UserRole::Manager], true);
            
        });

        /**
         * TASKS: update status – User simplu doar la task-urile lui;
         */
        Gate::define('tasks.update-status', function (User $user, Task $task): bool {
            if ($user->isManager()) {
                return true;
            }

            return $task->user_id === $user->id;
        });

        /**
         * TASKS: take – cine are voie să "ia" un task.
         */
        Gate::define('tasks.take', function (User $user, Task $task): bool {
            return $task->user_id === null;
        });
    }
}
