<?php

namespace App\Services\Mobile;

/**
 * Class NotificationService.
 */
class NotificationService
{

    public function getAllNotifications()
    {
        return request()->user()->notifications()->get();
    }


}
