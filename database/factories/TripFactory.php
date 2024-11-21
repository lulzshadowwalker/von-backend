<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\Route;
use App\Models\Trip;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'departured_at' => $this->faker->dateTime(),
            'arrived_at' => $this->faker->dateTime(),
            'driver_id' => Driver::factory(),
            'bus_id' => Bus::factory(),
            'route_id' => Route::factory(),
        ];
    }
}
