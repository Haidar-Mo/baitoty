<?php

use App\Http\Controllers\Api\Dashboard\OrderController;
use Illuminate\Support\Facades\Route;


Route::prefix("orders")
    ->middleware([])
    ->group(function () {
        Route::get("index", [OrderController::class, 'index']);
        Route::get("show/{order_id}", [OrderController::class, "show"]);
    });