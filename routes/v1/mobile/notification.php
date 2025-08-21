<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Api\Mobile\NotificationController;
use Illuminate\Support\Facades\Route;


Route::prefix('notifications/')
    ->middleware([
        'auth:sanctum',
        'ability:' . TokenAbility::ACCESS_API->value,
    ])->group(function () {

        Route::get('index', [NotificationController::class, 'index']);

    });
