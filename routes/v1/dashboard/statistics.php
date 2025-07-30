<?php

use App\Http\Controllers\Api\Dashboard\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::prefix("statistics")
    ->middleware([])
    ->group(function () {
        Route::get("index", [StatisticsController::class, "index"]);
    });