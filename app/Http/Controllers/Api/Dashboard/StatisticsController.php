<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\StatisticsService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    use ResponseTrait;


    public function __construct(protected StatisticsService $service)
    {
    }


    public function index()
    {
        try {
            $statistics = $this->service->getStatistics();
            return $this->showResponse($statistics);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }
}
