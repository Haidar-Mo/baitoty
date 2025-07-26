<?php

namespace App\Services\Mobile\Client;

use App\Filters\Mobile\OrderFilter;
use App\Models\Kitchen;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Mobile\OrderNotification;
use App\Traits\FirebaseNotificationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderService.
 */
class OrderService
{

    use FirebaseNotificationTrait;

    public function __construct(public OrderFilter $filter)
    {
    }

    /**
     * Get all orders for the authenticated user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getMyOrders(Request $request)
    {
        $orders = Order::query()->where('user_id', auth()->user()->id);
        return $this->filter->apply($orders);
    }

    /**
     * Get the order by ID for the authenticated user
     *
     * @param int $orderId
     * @return \Illuminate\Database\Eloquent\Collection|Order
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getOrderById(int $id): \Illuminate\Database\Eloquent\Collection|Order
    {
        $order = auth()->user()
            ->order()
            ->findOrFail($id);
        $order->load('meal');
        $order->append('kitchen_name');
        return $order;
    }


    public function createOrder(FormRequest $request)
    {

        $data = $request->validated();
        $order = DB::transaction(function () use ($data) {
            return auth()->user()->order()->create($data)->append('kitchen_name');

        });

        //: Sending notification
        $kitchen = Kitchen::findOrFail($order->kitchen_id);
        $chef = User::findOrFail($kitchen->user_id);
        $chef->notify(new OrderNotification(
            order: $order,
            title: "طلب جديد!",
            body: "تم استلام طلب جديد من " . $order->user->name . "، الرجاء مراجعته."
        ));

        $notification_data = (object) [
            'title' => "طلب جديد!",
            'body' => "تم استلام طلب جديد من " . $order->user->name . "، الرجاء مراجعته."
        ];
        $this->unicast($notification_data, $chef->device_token);
        return $order;
    }
}
