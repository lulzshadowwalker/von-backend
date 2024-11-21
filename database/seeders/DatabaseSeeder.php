<?php

namespace Database\Seeders;

use App\Models\Passenger;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Lulzie',
            'email' => 'lulzie@example.com',
        ]);

        Trip::factory()
            ->count(10)
            ->has(Passenger::factory()->count(rand(28, 35)))
            ->create();
    }
}
