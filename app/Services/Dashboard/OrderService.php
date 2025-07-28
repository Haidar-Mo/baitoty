<?php

namespace App\Services\Dashboard;

use App\Filters\Dashboard\OrderFilter;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * Class OrderService.
 */
class OrderService
{
    public function __construct(protected OrderFilter $filter)
    {
    }

    public function getAllOrders(Request $request)
    {
        $orders = Order::query();
        return $this->filter->apply($orders);
    }

    public function getOrder(string $order_id)
    {
        $order = Order::with([
            'kitchen',
            'user',
            'meals'
        ])->find($order_id);
        return $order;

    }

}
