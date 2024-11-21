<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\Route;
use App\Models\Trip;

class TripFactory extends Factory
{
    protected $model = Trip::class;

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
