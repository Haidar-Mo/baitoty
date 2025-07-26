<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Api\Mobile\Client\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')
    ->middleware([
        'auth:sanctum',
        'ability:' . TokenAbility::ACCESS_API->value,
    ])
    ->group(function () {

        Route::get('index', [OrderController::class, 'index']);
        Route::get('show/{id}', [OrderController::class, 'show']);
        Route::post('create', [OrderController::class, 'store']);
    });