<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    \Log::info('Testing the default page', $request->all());

    return view('index');
});


Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Weather Station API is working',
        'time' => now()->toDateTimeString(),
        'timezone' => now()->timezoneName,
    ]);
});

// Pull all weather data
Route::get('/weather', function () {
    return response()->json(DB::table('weather_data')->orderBy('measured_at', 'desc')->get());
});


// Testing CI/CD pipeline
Route::get('/test', function () {
    \Log::info('Testing the CI/CD pipeline');
    return response()->json([
        'status' => 'success',
        'message' => 'CI/CD pipeline working',
        'time' => now()->toDateTimeString(),
    ]);
});

// Testing CI/CD pipeline
Route::get('/test2', function () {
    \Log::info('Testing2 the CI/CD pipeline');
    return response()->json([
        'status' => 'success',
        'message' => 'CI/CD pipeline2 working',
        'time' => now()->toDateTimeString(),
    ]);
});
