<?php

namespace App\Services\Mobile\Client;

use App\Filters\Mobile\MealFilter;
use App\Models\Meal;
use Illuminate\Http\Request;

/**
 * Class HomePageService.
 */
class MealService
{

    public function __construct(protected MealFilter $filter)
    {
    }

    public function index(Request $request)
    {
        $meals = Meal::query();
        return $this->filter->apply($meals);
    }

    public function show(string $id)
    {
        $meal = Meal::with(['attribute', 'media'])->findOrFail($id);
        return $meal;
    }

    public function displayHomePage()
    {
        $popular = Meal::withCount('order')->with('media')->orderByDesc('order_count')
            ->limit(5)->get()->append('can_be_delivered');

        $moona_type = Meal::with(['media'])->whereNull('new_price')
            ->where('type', '=', '1')->inRandomOrder()
            ->limit(10)->get()->append('can_be_delivered');

        $normal_type = Meal::with(['media'])->whereNull('new_price')
            ->where('type', '=', '2')->inRandomOrder()
            ->limit(10)->get()->append('can_be_delivered');

        $sales = Meal::with(['media'])->inRandomOrder()->whereNotNull('new_price')
            ->limit(10)->get()->append('can_be_delivered');

        return [
            'popular' => $popular,
            'moona' => $moona_type,
            'normal' => $normal_type,
            'sales' => $sales
        ];
    }


}
