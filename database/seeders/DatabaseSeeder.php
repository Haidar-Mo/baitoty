<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Kitchen;
use App\Models\Meal;
use App\Models\MealAttribute;
use App\Models\Media;
use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Sanctum\PersonalAccessToken;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);

        User::factory()->isHaidar()
            ->has(Kitchen::factory()
                ->has(Meal::factory(10)
                    ->has(Media::factory(2))
                    ->has(MealAttribute::factory(5), 'attribute')
                    ->has(Order::factory(5))))
            ->create();

        User::factory()->isEdma()
            ->has(Kitchen::factory()
                ->has(Meal::factory(10)
                    ->has(Media::factory(2))
                    ->has(MealAttribute::factory(5), 'attribute')
                    ->has(Order::factory(5))))
            ->create();

        User::factory(2)
            ->has(Kitchen::factory()
                ->has(Meal::factory(10)
                    ->has(Media::factory(2))
                    ->has(MealAttribute::factory(5), 'attribute')
                    ->has(Order::factory(5))))
            ->create();

        User::factory()->haidarClient()->create();
        User::factory()->edmaClient()->create();
    }
}
