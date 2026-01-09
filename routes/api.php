<?php

use App\Http\Controllers\Api\PhleboController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/phlebo/start-collection/{tracking_id}', [PhleboController::class, 'startCollection']);
    Route::post('/phlebotomist/update-location', [PhleboController::class, 'updateLocation']);
    Route::get('/phlebo/check-collection/{trackingId}', [PhleboController::class, 'checkCollection']);
    Route::get('/user/track/{trackingId}', [PhleboController::class, 'trackPhlebo']);
    
});
