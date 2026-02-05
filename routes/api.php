<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EcowittController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Ecowitt weather station data endpoint
Route::post('/data/report', [EcowittController::class, 'report']);

