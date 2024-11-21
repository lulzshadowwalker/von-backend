<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Route;

class RouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Route::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'from_location_latitude' => $this->faker->randomFloat(7, 0, 999.9999999),
            'from_location_longitude' => $this->faker->randomFloat(7, 0, 999.9999999),
            'to_location_latitude' => $this->faker->randomFloat(7, 0, 999.9999999),
            'to_location_longitude' => $this->faker->randomFloat(7, 0, 999.9999999),
        ];
    }
}
