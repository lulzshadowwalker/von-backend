<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Route;

class RouteFactory extends Factory
{
    protected $model = Route::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'from_location_latitude' => $this->faker->randomFloat(7, 29.0, 33.5), // Latitude range for Jordan
            'from_location_longitude' => $this->faker->randomFloat(7, 35.5, 42.0), // Longitude range for Jordan
            'to_location_latitude' => $this->faker->randomFloat(7, 29.0, 33.5), // Latitude range for Jordan
            'to_location_longitude' => $this->faker->randomFloat(7, 35.5, 42.0), // Longitude range for Jordan
        ];
    }
}
