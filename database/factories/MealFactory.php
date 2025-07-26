<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kitchen_id' => \App\Models\Kitchen::factory(),
            'name' => $this->faker->unique()->words(3, true),
            'ingredients' => $this->faker->sentences(4, true),
            'type' => $this->faker->randomElement(['1', '2']), //- 1: for moona,    2: for normal
            'price' => $this->faker->randomFloat(2, 5, 100),
            'new_price' => $this->faker->randomElement([null, $this->faker->randomFloat(2, 5, 100)]),
            'meal_form' => $this->faker->randomElement(['طبق', 'علبة', 'قطرميز', 'زبدية', 'زجاجة']),
            'is_available' => $this->faker->boolean()
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        return $this->afterCreating(function (\App\Models\Meal $meal) {
            // Optional: Add any post-creation logic here
        });

    }
}
