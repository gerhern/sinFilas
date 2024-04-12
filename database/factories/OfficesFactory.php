<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offices>
 */
class OfficesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  => fake()->word(),
            'slug'  => fake()->slug(),
            'coors' => fake()->latitude(),
            'address'   => fake()->address(),
            'dependency_id' => fake()->numberBetween(1, 50)
        ];
    }
}
