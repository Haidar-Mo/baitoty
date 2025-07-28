<?php

use App\Http\Controllers\Api\Dashboard\KitchenController;
use Illuminate\Support\Facades\Route;


Route::prefix("kitchens")
    ->middleware([])
    ->group(function () {

        Route::prefix('kitchens')->middleware('auth:sanctum')->group(function () {
            Route::get('/index', [KitchenController::class, 'index']);
            Route::get('show/{kitchen_id}', [KitchenController::class, 'show']);
            Route::post('/create', [KitchenController::class, 'store']);
            Route::put('update/{kitchen_id}', [KitchenController::class, 'update']);
            Route::delete('delete/{kitchen_id}', [KitchenController::class, 'destroy']);
        });
    });