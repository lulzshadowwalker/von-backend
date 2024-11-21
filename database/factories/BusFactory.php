<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bus;

class BusFactory extends Factory
{
    protected $model = Bus::class;

    public function definition(): array
    {
        return [
            'license_plate' => $this->faker->unique()->regexify('^\d{1,2}[A-Z]?-?\d{3,5}[A-Z]?$'),
            'capacity' => $this->faker->numberBetween(35, 50),
        ];
    }
}
