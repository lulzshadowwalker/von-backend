<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Passenger;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AuthorizationSeeder::class);

        $lulzie = User::factory()->create([
            'name' => 'Lulzie',
            'email' => 'lulzie@example.com',
        ]);
        $lulzie->assignRole(Role::ADMIN);

        Trip::factory()
            ->count(10)
            ->has(Passenger::factory()->count(rand(28, 35)))
            ->create();
    }
}
