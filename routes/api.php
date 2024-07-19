<?php

use App\Http\Controllers\Api\BookingsController;
use App\Http\Controllers\Api\PlacesController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/places', PlacesController::class);
    Route::apiResource('bookings', BookingsController::class);
});
