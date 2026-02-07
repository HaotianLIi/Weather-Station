<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ECOWITT API
Route::post('/data/report', function(Request $request) {
    // Record raw data
    $rawData = $request->all();

    $data = [
        'station_id' => $rawData['PASSKEY'],
        'data_source' => ['ecowitt'],
        'temperature_f' => $rawData['tempf'],
        'humidity' => $rawData['humidity'] ?? null,
        'wind_direction' => $rawData['winddir'] ?? null,
        'wind_speed_mph' => $rawData['windspeedmph'] ?? null,
        'pressure_inhg' => $rawData['pressure_inhg'] ?? null,
        'rain_rate' => $rawData['rainratein'] ?? null,
        'solar_radiation' => $rawData['solarradiation'] ?? null,
        'uv_index' => $rawData['uv'] ?? null,
        'raw_data' => json_encode($rawData),
        'measured_at' => $rawData['dateutc'] ?? null,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    DB::table('weather_data')->insert($data);

});

//  WUNDERGROUND API
Route::get('/wunderground/updateweatherstation', function (Request $request) {
    //  take record on raw data
    $rawData = $request->all();

    $data = [
        'station_id' => $rawData['ID'] ?? 'unknown',
        'data_source' => 'wunderground',
        'temperature_f' => $rawData['tempf'] ?? null,
        'humidity' => $rawData['humidity'] ?? null,
        'wind_direction' => $rawData['winddir'] ?? null,
        'wind_speed_mph' => $rawData['windspeedmph'] ?? null,
        'pressure_inhg' => $rawData['baromin'] ?? null,
        'rain_rate' => $rawData['rainin'] ?? null,
        'solar_radiation' => $rawData['solarradiation'] ?? null,
        'uv_index' => $rawData['UV'] ?? null,
        'raw_data' => json_encode($rawData),
        'measured_at' => $rawData['dateutc'] === 'now' ? now() : ($rawData['dateutc'] ?? now()),
        'created_at' => now(),
        'updated_at' => now(),
    ];

    DB::table('weather_data')->insert($data);

});
