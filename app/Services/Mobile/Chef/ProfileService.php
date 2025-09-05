<?php

namespace App\Services\Mobile\Chef;

use App\Http\Requests\Mobile\KitchenUpdateRequest;

/**
 * Class ProfileService.
 */
class ProfileService
{
    public function show()
    {
        $user = auth()->user();
        $user->load(['kitchen.meal.attribute', 'kitchen.meal.media']);
        return $user;
    }

/*     public function update(ProfileUpdateRequest  $request)
    {
        $data = $request->all();
        $user = auth()->user();
        $user->update($data);
        return $user;
    } */

    public function editKitchen(KitchenUpdateRequest $request)
    {
        $data = $request->validated();

        $kitchen =
            auth()->user()->kitchen;
        if (!$kitchen) {
            throw new \Exception('Kitchen not found for the authenticated user.');
        }

        $kitchen->update($data);

        return $kitchen;
    }
}
