<?php

namespace App\Http\Controllers\Api\Mobile\Chef;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\MealCreateRequest;
use App\Http\Requests\Mobile\MealUpdateRequest;
use App\Models\Meal;
use App\Services\Mobile\Chef\MealService;
use App\Traits\HasFiles;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class MealController extends Controller
{
    use ResponseTrait, HasFiles;

    public function __construct(protected MealService $service)
    {
    }


    public function index()
    {
        try {
            $meals = auth()->user()->kitchen()?->first()->meal()->get()->each(function ($meal) {
                $meal->load(['attribute', 'media']);
            });
            return $this->showResponse($meals);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }


    public function show(string $id)
    {
        try {
            $meal = Meal::findOrFail($id)->load(['attribute', 'media']);
            return $this->showResponse($meal);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function store(MealCreateRequest $request)
    {
        try {
            $meal = $this->service->create($request);
            return $this->showResponse($meal, 'تم إضافة وجبة جديدة بنجاح');
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }


    public function update(MealUpdateRequest $request, string $mealId)
    {
        try {
            $meal = $this->service->update($request, $mealId);
            return $this->showResponse($meal);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }


    public function storeImage(Request $request, string $mealId)
    {
        try {
            $meal = $this->service->addImage($request, $mealId);
            return $this->showResponse($meal);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function destroyImage(string $mealId, string $imageId)
    {
        try {
            $meal = $this->service->removeImage($imageId, $mealId);
            return $this->showResponse($meal);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function changeAvailability(string $id)
    {
        try {
            $meal = $this->service->changeAvailability($id);
            return $this->showResponse($meal, 'تم تغيير إتاحية الوجبة');
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function changeDiscount(Request $request, string $mealId)
    {
        try {
            $meal = $this->service->changeDiscountValue($request, $mealId);
            return $this->showResponse($meal);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }
    public function destroy(string $id)
    {
        try {
            $this->service->delete($id);
            return $this->showMessage('تم حذف الوجبة بنجاح', 200, true);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

}
