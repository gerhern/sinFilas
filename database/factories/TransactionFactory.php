<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name'          => fake()->randomElement(['Cambio de domicilio', 'Cambio de email', 'Alta de curp', 'Defuncion']),
            'requirements'  => fake()->randomElement(['Acta de nacimiento', 'Comprobante de domicilio', 'Email valido']),
            'minutes'       => fake()->numberBetween(5,60),
            'price'         => fake()->randomNumber(3),
            'code'          => fake()->ean13(),
            'warning_message'   => fake()->sentence(),

        ];
    }
}
