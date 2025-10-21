<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewAny(User $auth): bool {
        return $auth->role === UserRole::Admin || $auth->role === UserRole::Manager;
    }

    public function view(User $auth, User $model): bool {
        // admin & manager pot vedea; user poate să se vadă pe sine
        return $auth->role === UserRole::Admin
            || $auth->role === UserRole::Manager
            || $auth->id === $model->id;
    }

    public function create(User $auth): bool {
        return $auth->role === UserRole::Admin; // doar admin
    }

    public function update(User $auth, User $model): bool {
        if ($auth->role === UserRole::Admin) return true;        // admin: poate oricine
        if ($auth->role === UserRole::Manager) return false;     // manager: nu modifică users
        return $auth->id === $model->id;                         // user: doar profilul propriu
    }

    public function delete(User $auth, User $model): bool {
        return $auth->role === UserRole::Admin;
    }
}
