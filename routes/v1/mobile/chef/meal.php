<?php

use App\Enums\TokenAbility;

use App\Http\Controllers\Api\Mobile\Chef\MealController;
use Illuminate\Support\Facades\Route;


Route::prefix('meals/')
    ->middleware([
        'auth:sanctum',
        'ability:' . TokenAbility::ACCESS_API->value,
    ])
    ->group(function () {

        Route::get('index', [MealController::class, 'index']);
        Route::get('show/{id}', [MealController::class, 'show']);
        Route::post('create', [MealController::class, 'store']);
        Route::post('update/{id}', [MealController::class, 'update']);

        Route::post('change/discount/{mealId}',[MealController::class, 'changeDiscount']);

        Route::post('availability/change/{id}', [MealController::class, 'changeAvailability']);
        Route::post('add/image/{mealId}', [MealController::class, 'storeImage']);
        Route::delete('{mealId}/remove/image/{imageId}', [MealController::class, 'destroyImage']);
        Route::delete('delete/{id}', [MealController::class, 'destroy']);
    });