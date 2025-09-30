<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      User::updateOrCreate(
        ['email' => 'test@example.com'],
        ['name' => 'Test User', 'password' => bcrypt('password')]
    );

    // 2. câțiva useri random
    User::factory()->count(3)->create();

    // 3. proiecte (alegând random useri existenți)
    Project::factory()->count(5)->create();

    // 4. tasks random distribuite pe proiecte și useri
    Task::factory()->count(30)->create();
    }
}
