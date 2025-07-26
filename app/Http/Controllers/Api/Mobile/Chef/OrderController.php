<?php

namespace App\Http\Controllers\Api\Mobile\Chef;

use App\Http\Controllers\Controller;
use App\Services\Mobile\Chef\OrderService;
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
            $orders = $this->service->getAllOrders($request)->get()
                ->makeHidden(['qr_code']);
            return $this->showResponse($orders, 'تم عرض كل الطلبات', 200);
        } catch (\Exception $e) {
            return $this->showError($e, 'حدث خطأ ما أثناء عرض الطلبات');
        }
    }


    /**
     * Display the the specified order
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        try {
            $order = $this->service->getOrderById($id)
                ->makeHidden(['qr_code']);
            return $this->showResponse($order, 'تم عرض تفاصيل الطلب بنجاح');

        } catch (ModelNotFoundException $e) {
            return $this->showError($e, 'لم يتم العثور على الطلب');
        } catch (\Exception $e) {
            return $this->showError($e, 'حدث خطأ ما أثناء عرض تفاصيل الطلب');
        }
    }


    public function update(Request $request, string $id)
    {
        try {
            $order = $this->service->changeStatus($request, $id);
            return $this->showResponse($order);
        } catch (\Exception $e) {
            return $this->showError($e, 'حدث خطأ ما أثناء تعديل حالة الطلب');
        }
    }


    public function makeDelivered(Request $request, string $id)
    {
        try {
            $order = $this->service->makeDelivered($request, $id);
            return $this->showResponse($order);
        } catch (\Exception $e) {
            return $this->showError($e, 'حدث خطأ ما أثناء تعديل حالة الطلب');
        }
    }
}
