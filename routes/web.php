<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Weather Station API is working',
        'time' => now()->toDateTimeString(),
    ]);
});



