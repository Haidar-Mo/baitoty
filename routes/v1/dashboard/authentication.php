<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Api\Dashboard\AuthenticationController;
use App\Http\Controllers\Api\Dashboard\KitchenController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function () {

        Route::post('login', [AuthenticationController::class, 'create']);
        Route::delete('logout', [AuthenticationController::class, 'destroy'])->middleware([
            'auth:sanctum',
            'ability:' . TokenAbility::ACCESS_API->value,
        ]);
    });