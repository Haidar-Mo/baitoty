<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\ComplimentCreateRequest;
use App\Services\Mobile\ComplimentService;
use App\Traits\ResponseTrait;

class ComplimentController extends Controller
{

    use ResponseTrait;

    public function __construct(protected ComplimentService $service)
    {
    }

    public function store(ComplimentCreateRequest $request)
    {
        try {
            $data = $this->service->sendCompliment($request);
            return $this->showResponse($data);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }
}
