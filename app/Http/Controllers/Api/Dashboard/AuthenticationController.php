<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\AuthenticationService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    use ResponseTrait;

    public function __construct(protected AuthenticationService $service)
    {
    }


    public function create(Request $request)
    {
        try {
            $authentication = $this->service->login($request);
            return $this->showResponse($authentication);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }

    public function destroy()
    {
        try {
            $authentication = $this->service->logout();
            return $this->showResponse($authentication, status: 200);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }
}
