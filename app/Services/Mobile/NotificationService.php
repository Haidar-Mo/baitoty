<?php

namespace App\Services\Mobile;

/**
 * Class NotificationService.
 */
class NotificationService
{

    public function getAllNotifications()
    {
        return request()->user()->notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                "type" => $notification->type,
                'data' => $notification->data,
                "read_at" => $notification->read_at,
                'created_at' => $notification->created_at->diffForHumans(),
            ];
        });
    }


}
