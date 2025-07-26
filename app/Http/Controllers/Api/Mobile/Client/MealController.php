<?php

namespace App\Http\Controllers\Api\Mobile\Client;

use App\Http\Controllers\Controller;
use App\Services\Mobile\Client\MealService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class MealController extends Controller
{

    use ResponseTrait;

    public function __construct(protected MealService $service)
    {
    }

    public function index(Request $request)
    {
        try {

            $meals = $this->service->index($request)->paginate(10);
            $meals->load('media');
            return $this->showResponse($meals);
        } catch (\Exception $e) {
            return $this->showError($e, 'حدث خطأ أثناء عرض الوجبات');
        }

    }


    public function show(string $id)
    {
        try {
            $meal = $this->service->show($id);
            return $this->showResponse($meal);
        } catch (\Exception $e) {
            return $this->showError($e, 'حدث خطأ أثناء عرض الوجبة');
        }
    }

    public function displayHomePage()
    {

        try {
            $homePage = $this->service->displayHomePage();
            return $this->showResponse($homePage, 'تم جلب الواجهة الرئيسية بنجاح');
        } catch (\Exception $e) {
            return $this->showError($e, 'حدث خطأ أثناء عرض  الواجهة الرئيسية');
        }
    }
}
