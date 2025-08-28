<?php

namespace App\Services\Mobile\Chef;

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

    
}
