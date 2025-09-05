<?php

namespace App\Services\Mobile\Chef;

use App\Filters\Mobile\OrderFilter;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Mobile\OrderNotification;
use App\Traits\FirebaseNotificationTrait;
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


    public function getAllOrders(Request $request)
    {
        $orders = Order::query()
            ->where('kitchen_id', '=', auth()->user()->kitchen()->first()->id);
        return $this->filter->apply($orders);
    }

    public function getOrderById(int $id): \Illuminate\Database\Eloquent\Collection|Order
    {
        $order = auth()->user()
            ->kitchen()->first()
            ->order()
            ->findOrFail($id);
        $order->load('meal');
        $order->append('user_name');
        return $order;
    }

    public function changeStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|string|in:accepted,ready,delivered,canceled,'
        ]);
        $order = auth()->user()
            ->kitchen()->first()?->order()->findOrFail($id);
        $order = DB::transaction(function () use ($order, $request) {
            $order->update([
                'status' => $request->status
            ]);
            return $order;
        });

        //: Sending notification
        $client = User::findOrFail($order->user_id);
        $notifications = [
            'accepted' => [
                'title' => 'تم قبول طلبك!',
                'body' => 'أخبار رائعة! تم قبول طلبك من قبل الطباخ، وسيبدأ التحضير قريبًا.',
            ],
            'canceled' => [
                'title' => 'تم رفض طلبك',
                'body' => 'نأسف، لقد تم رفض طلبك من قبل الطباخ. يمكنك تجربة مطبخ آخر أو طبق مختلف.',
            ],
            'ready' => [
                'title' => 'طلبك جاهز',
                'body' => 'طلبك جاهز الآن. سنقوم توصيله لك بأقرب وقت!',
            ],
        ];

        $status = $request->status;

        $client->notify(new OrderNotification(
            order: $order,
            title: $notifications[$status]['title'],
            body: $notifications[$status]['body']
        ));
        $notification_data = (object) [
            'title' => $notifications[$status]['title'],
            'body' => $notifications[$status]['body']
        ];
        $this->unicast($notification_data, $client->device_token);
        return $order;
    }

    public function makeDelivered(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);
        $order = auth()->user()
            ->kitchen()->first()?->order()?->where('qr_code', '=', $request->qr_code)->first();
        if (!$order)
            throw new \Exception("الطلب المحدد غير موجود", 404);
        $order = DB::transaction(function () use ($order) {
            $order->update([
                'status' => 'delivered'
            ]);
            return $order;
        });

        //: Sending notification
        $client = User::findOrFail($order->user_id);
        $client->notify(new OrderNotification(
            order: $order,
            title: 'تم تسليم طلبك بنجاح',
            body: 'لقد تم توصيل طلبك بنجاح. نتمنى أن يكون الطعام قد نال إعجابك! '
        ));
        $notification_data = (object) [
            'title' => 'تم تسليم طلبك بنجاح',
            'body' => 'لقد تم توصيل طلبك بنجاح. نتمنى أن يكون الطعام قد نال إعجابك! '
        ];
        $this->unicast($notification_data, $client->device_token);
        return $order;
    }

}
