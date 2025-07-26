<?php

use App\Http\Controllers\Api\Mobile\Client\MealController;
use Illuminate\Support\Facades\Route;

Route::prefix('meals')
    ->middleware([])
    ->group(function () {

        Route::get('home-page', [MealController::class, 'displayHomePage']);

        Route::get('index', [MealController::class, 'index']);
        Route::get('show/{id}', [MealController::class, 'show']);

    });