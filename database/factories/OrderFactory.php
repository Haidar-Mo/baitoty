<?php

namespace Database\Factories;

use App\Models\Kitchen;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'meal_id' => Meal::factory(),
            'kitchen_id' => function (array $attributes) {
                return Meal::findOrFail($attributes['meal_id'])->kitchen()->first()->id;
            },
            'user_id' => function (array $attributes) {
                return Meal::findOrFail($attributes['meal_id'])->kitchen()->first()->user()->first()->id;
            },
            'count' => $this->faker->randomNumber(1),
            'phone_number' => $this->faker->phoneNumber,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'notes' => $this->faker->sentence(),
            'total_price' => 500,
            'qr_code' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'prepared', 'done', 'canceled'])
        ];
    }
}
