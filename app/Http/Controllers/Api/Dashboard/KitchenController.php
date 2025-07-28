<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\KitchenCreateRequest;
use App\Http\Requests\Dashboard\KitchenUpdateRequest;
use App\Services\Dashboard\KitchenService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    use ResponseTrait;


    public function __construct(protected KitchenService $kitchenService)
    {
    }

    public function index(Request $request)
    {
        try {
            $kitchens = $this->kitchenService->getAllKitchens($request);
            return $this->showResponse($kitchens, 'Kitchens fetched successfully');
        } catch (\Exception $e) {
            return $this->showError($e, 'Failed to fetch kitchens');
        }
    }

    public function show(string $id)
    {
        try {
            $kitchen = $this->kitchenService->getKitchen($id);
            return $this->showResponse($kitchen, 'Kitchen retrieved successfully');
        } catch (\Exception $e) {
            return $this->showError($e, 'Failed to retrieve kitchen');
        }
    }

    public function store(KitchenCreateRequest $request)
    {
        try {
            $kitchen = $this->kitchenService->createKitchen($request);
            return $this->showResponse($kitchen, 'Kitchen created successfully');
        } catch (\Exception $e) {
            return $this->showError($e, 'Failed to create kitchen');
        }
    }

    public function update(string $id, KitchenUpdateRequest $request)
    {
        try {
            $kitchen = $this->kitchenService->updateKitchen($id, $request);
            return $this->showResponse($kitchen, 'Kitchen updated successfully');
        } catch (\Exception $e) {
            return $this->showError($e, 'Failed to update kitchen');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->kitchenService->deleteKitchen($id);
            return $this->showMessage('Kitchen deleted successfully');
        } catch (\Exception $e) {
            return $this->showError($e, 'Failed to delete kitchen');
        }
    }
}
