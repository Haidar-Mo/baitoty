<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Api\Mobile\Chef\ProfileController;
use Illuminate\Support\Facades\Route;


Route::prefix('profile')
    ->middleware([
        'auth:sanctum',
        'ability:' . TokenAbility::ACCESS_API->value,
    ])
    ->group(function () {

        Route::get('show', [ProfileController::class, 'show']);
        
    });