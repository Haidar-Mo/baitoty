<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Api\Mobile\ComplimentController;
use Illuminate\Support\Facades\Route;

Route::prefix('compliments')
    ->middleware([
        'auth:sanctum',
        'ability:' . TokenAbility::ACCESS_API->value,
    ])
    ->group(function () {

      
        Route::post('/create', [ComplimentController::class, 'store']);
    });
