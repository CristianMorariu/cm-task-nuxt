<?php

namespace Database\Seeders;

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
      User::updateOrCreate(
     ['email' => 'admin@gmail.com'],
            [
                'username'   => 'admin',
                'full_name'  => 'Site Administrator',
                'role'       => \App\Enums\UserRole::Admin,
                'password'   => Hash::make('Password'),
            ]
    );

    // 2. câțiva useri random
    User::factory()->count(5)->create();

    // 3. proiecte (alegând random useri existenți)
    $owner = User::inRandomOrder()->first();
    $supervisor = User::where('id', '!=', $owner->id)->inRandomOrder()->first();

    Project::factory()
        ->count(9)
        ->active()
        ->create([
            'user_id'       => $owner->id,
            'supervisor_id' => $supervisor?->id,
            'deadline'      => now()->addMonths(2)->toDateString(),
        ]);

    // 4. tasks random distribuite pe proiecte și useri
    Task::factory()->count(30)->create();
    }
}
