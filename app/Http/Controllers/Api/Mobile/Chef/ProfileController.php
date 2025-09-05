<?php

namespace App\Http\Controllers\Api\Mobile\Chef;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\KitchenUpdateRequest;
use App\Services\Mobile\Chef\ProfileService;
use App\Traits\ResponseTrait;

class ProfileController extends Controller
{
    use ResponseTrait;

    public function __construct(protected ProfileService $service)
    {
    }

    public function show()
    {
        try {
            $profile = $this->service->show();
            return $this->showResponse($profile);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }


/*     public function update(Request $request)
    {
        try {
            $profile = $this->service->update($request);
            return $this->showResponse($profile);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    } */


    public function updateKitchen(KitchenUpdateRequest $request)
    {
        try {
            $kitchen = $this->service->editKitchen($request);
            return $this->showResponse($kitchen);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }
    
}
