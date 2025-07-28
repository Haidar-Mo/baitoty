<?php

use App\Http\Controllers\Api\Dashboard\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix("users")
    ->middleware([])
    ->group(function () {
        Route::get("index", [UserController::class, 'index']);
        Route::get("show/{user_id}", [UserController::class, "show"]);
        Route::post("create", [UserController::class, "store"]);
        Route::post("update/{user_id}", [UserController::class, "update"]);
        Route::delete("delete/{user_id}", [UserController::class, "destroy"]);
        Route::post("status/{user_id}", [UserController::class, "statusChange"]);
    });