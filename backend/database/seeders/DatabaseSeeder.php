<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Admin fix
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'username'  => 'admin',
                'full_name' => 'Site Administrator',
                'role'      => UserRole::Admin,
                'password'  => Hash::make('Password'),
            ]
        );

        $managers = User::factory()
            ->count(2)
            ->state(fn () => ['role' => UserRole::Manager])
            ->create();


        $users = User::factory()
            ->count(5)
            ->state(fn () => ['role' => UserRole::User])
            ->create();


        $allUsers = $managers->concat($users)->prepend($admin);


        $projects = Project::factory()
            ->count(9)
            ->active()
            ->state(function () use ($admin, $managers) {
                return [
                    'user_id'       => $admin->id,
                    'supervisor_id' => $managers->random()->id,
                    'deadline'      => now()->addDays(rand(7, 90)),
                ];
            })
            ->create();

        // Task-uri pentru fiecare proiect
        $projects->each(function (Project $project) use ($allUsers) {
            Task::factory()
                ->count(rand(3, 7))
                ->state(function () use ($project, $allUsers) {
                    return [
                        'project_id' => $project->id,
                        'user_id'    => $allUsers->random()->id,
                    ];
                })
                ->create();
        });
    }
}
