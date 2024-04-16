<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date'  => fake()->dateTimeBetween('-1 month', '+1 month'),
            'citizen_name'  => fake()->name(),
            'citizen_firstname' => fake()->firstName,
            'citizen_lastname'  => fake()->lastName(),
            'email'             => fake()->safeEmail(),
            'curp'              => fake()->bothify('????######??????##'),
            'phone'             => fake()->phoneNumber(),
            'folio'             => fake()->bothify('?####'),
            'ip'                => fake()->ipv4,
            'appointment_status'    => fake()->randomElement(['Activa', 'Inactiva']),
            'transaction_id'        => fake()->numberBetween(1,4),
            'office_id'        => fake()->numberBetween(1,50),
            'user_id'        => fake()->numberBetween(1,50),
        ];
    }
}
