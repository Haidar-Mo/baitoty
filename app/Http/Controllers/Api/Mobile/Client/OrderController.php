<?php

namespace App\Http\Controllers\Api\Mobile\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\OrderCreateRequest;
use App\Services\Mobile\Client\OrderService;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponseTrait;

    public function __construct(protected OrderService $service)
    {
    }

    public function index(Request $request)
    {
        try {
            $orders = $this->service->getMyOrders($request)
                ->get()
                ->append(['kitchen_name']);
            return $this->showResponse($orders, 'تم عرض كل الطلبات', 200);
        } catch (\Exception $e) {
            return $this->showError($e, 'حدث خطأ ما أثناء عرض الطلبات');
        }
    }


    public function show(string $id)
    {
        try {
            $order = $this->service->getOrderById($id);
            return $this->showResponse($order, 'تم عرض تفاصيل الطلب بنجاح');

        } catch (\Exception $e) {
            return $this->showError($e, 'لم يتم العثور على الطلب');
        } catch (\Exception $e) {
            return $this->showError($e, 'حدث خطأ ما أثناء عرض تفاصيل الطلب');
        }
    }

    public function store(OrderCreateRequest $request)
    {
        try {
            $order = $this->service->createOrder($request);
            return $this->showResponse($order);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }
}
