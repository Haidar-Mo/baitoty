<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kitchen>
 */
class KitchenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(3),
            'phone_number' => $this->faker->phoneNumber(),
            'second_phone_number' => $this->faker->optional(0.7)->phoneNumber(), // 70% chance of having a second number
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'can_deliver' => $this->faker->boolean(80), // 80% chance of being able to deliver
            'open_at' => $this->faker->time('H:i', '08:00'), // Default opens around 8 AM
            'close_at' => $this->faker->time('H:i', '22:00'), // Default closes around 10 PM
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        return $this->afterCreating(function (\App\Models\Kitchen $kitchen) {
            // Ensure close time is after open time
            if (strtotime($kitchen->close_at) <= strtotime($kitchen->open_at)) {
                $kitchen->update([
                    'close_at' => date('H:i', strtotime($kitchen->open_at) + 36000) // Add 10 hours if close <= open
                ]);
            }
        });
    }
}
