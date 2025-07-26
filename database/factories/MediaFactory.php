<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => 'https://picsum.photos/id/' . $this->faker->randomNumber(2) . '/200',
            'mediaable_id' => Meal::factory(),
            'mediaable_type' => Meal::class,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        return $this->afterMaking(function (\App\Models\Media $media) {
            if (is_null($media->mediaable_id) || is_null($media->mediaable_type)) {
                // Default to attaching to a random meal if not specified
                $meal = Meal::factory()->create();
                $media->mediaable_id = $meal->id;
                $media->mediaable_type = $meal->getMorphClass();
            }
        });
    }
}
