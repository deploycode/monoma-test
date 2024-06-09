<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'manager',
            'password' => bcrypt('PASSWORD'),
            'role' => 'manager'
        ]);

        User::factory()->create([
            'username' => 'agent1',
            'password' => bcrypt('PASSWORD'),
            'role' => 'agent'
        ]);

        User::factory()->create([
            'username' => 'agent2',
            'password' => bcrypt('PASSWORD'),
            'role' => 'agent'
        ]);

        User::factory()->create([
            'username' => 'agent3',
            'password' => bcrypt('PASSWORD'),
            'role' => 'agent'
        ]);

        Candidate::factory(10)->create();
    }
}
