<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(Role::where('name', 'chef')->first()->name);
        });
    }


    public function isHaidar(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Mohammad Haidar',
            'email' => 'mohammad44.haidar@gmail.com',
            'password' => static::$password ??= Hash::make('password'),
            'device_token' => 'eu26jBhbREWOqjl8Js22dS:APA91bFj-oif-QpSgN0RFE5fuDQwIPdc1uLGiMidPkvMp3wUca85loQvB0TVNi5SvBkVrZNcTwj_9XQzFC1w79a7AxugdFQp4RaDcmydH3OC3Ce5unodVww',
            'email_verified_at' => now(),
        ]);
    }
    public function isEdma(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Edma Abboud',
            'email' => 'abboudedma@gmail.com',
            'password' => static::$password ??= Hash::make('password'),
            'device_token' => null,
            'email_verified_at' => now(),
        ]);
    }

    public function haidarClient(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Haidar Client',
            'email' => 'haidarclient@gmail.com',
            'password' => static::$password ??= Hash::make('password'),
            'device_token' => null,
            'email_verified_at' => now(),
        ]);
    }
    public function edmaClient(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Edma Client',
            'email' => 'edmaclient@gmail.com',
            'password' => static::$password ??= Hash::make('password'),
            'device_token' => null,
            'email_verified_at' => now(),
        ]);
    }
}
