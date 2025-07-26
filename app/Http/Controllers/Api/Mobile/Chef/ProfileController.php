<?php

namespace App\Http\Controllers\Api\Mobile\Chef;

use App\Http\Controllers\Controller;
use App\Services\Mobile\Chef\ProfileService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

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

    
}
