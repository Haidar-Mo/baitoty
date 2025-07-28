<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\OrderService;
use App\Traits\ResponseTrait;
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
            $orders = $this->service->getAllOrders($request);
            return $this->showResponse($orders);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function show(string $order_id)
    {
        try {
            $order = $this->service->getOrder($order_id);
            return $this->showResponse($order);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }
}
