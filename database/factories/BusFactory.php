<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bus;

class BusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bus::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'license_plate' => $this->faker->word(),
            'capacity' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
