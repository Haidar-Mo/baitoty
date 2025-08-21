<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Services\Mobile\NotificationService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    use ResponseTrait;

    public function __construct(protected NotificationService $service)
    {
    }

    public function index()
    {
        try {
            $notifications = $this->service->getAllNotifications();
            return $this->showResponse($notifications);
        } catch (\Exception $e) {
            return $this->showError($e);
        }
    }
}
