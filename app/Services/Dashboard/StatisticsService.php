<?php

namespace App\Services\Dashboard;

use App\Models\Kitchen;
use App\Models\Meal;
use App\Models\Order;
use App\Models\User;

/**
 * Class StatisticsService.
 */
class StatisticsService
{

    public function getStatistics()
    {
        $userCount = User::count();
        $clientCount = User::role('client', 'api')->count();
        $kitchenCount = Kitchen::count();

        $ordersCount = Order::count();
        $acceptedOrderCount = Order::whereNotIn('status', ['pending', 'rejected'])->count();
        $rejectedOrderCount = Order::where('status', 'rejected')->count();
        $mostOrderedMeal = Meal::withCount('order')->orderByDesc('order_count')->take(5)->get();
        return [
            'users' => $userCount,
            'clients' => $clientCount,
            'kitchens' => $kitchenCount,
            'orders' => $ordersCount,
            'accepted_orders' => $acceptedOrderCount,
            'rejected_orders' => $rejectedOrderCount,
            'top_meals' => $mostOrderedMeal,
        ];
    }
}
