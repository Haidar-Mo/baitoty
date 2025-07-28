<?php

namespace App\Services\Dashboard;

use App\Filters\Dashboard\KitchenFilter;
use App\Models\Kitchen;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class KitchenService.
 */
class KitchenService
{
    public function __construct(protected KitchenFilter $filter)
    {
    }

    public function getAllKitchens(Request $request)
    {
        $kitchens = Kitchen::query();
        return $this->filter->apply($kitchens)->get();
    }

    public function getKitchen(string $id)
    {
        return Kitchen::findOrFail($id);
    }


    public function createKitchen(FormRequest $request)
    {
        $request->validated();
        $kitchen = Kitchen::create($request->all());
        return $kitchen;
    }


    public function updateKitchen(string $id, FormRequest $request)
    {
        $request->validated();
        $kitchen = Kitchen::findOrFail($id);
        DB::transaction(function () use ($kitchen, $request) {
            $kitchen->update($request->all());
        });
        return $kitchen;
    }


    public function deleteKitchen(string $id)
    {
        $kitchen = Kitchen::findOrFail($id);
        DB::transaction(function () use ($kitchen) {
            $kitchen->delete();
        });
    }


}
