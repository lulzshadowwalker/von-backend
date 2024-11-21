<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Passenger;
use App\Models\User;

class PassengerFactory extends Factory
{
    protected $model = Passenger::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
        ];
    }
}
