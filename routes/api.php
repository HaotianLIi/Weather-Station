<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Ecowitt API
Route::post('/data/report', function(Request $request) {
    \Log::info('Ecowitt API called', [
        'url' => $request->fullUrl(),
        'params' => $request->all(),
        'ip' => $request->ip()
    ]);
    // Record raw data
    $rawData = $request->all();
    try {
        if(!isset($rawData['PASSKEY'])) {
            return "PASSKEY is required";
        }
        $data = [
            'station_id' => $rawData['PASSKEY'],
            'data_source' => 'ecowitt',
            'temperature_f' => $rawData['tempf'],
            'humidity_pct' => $rawData['humidity'] ?? null,
            'wind_direction_deg' => $rawData['winddir'] ?? null,
            'wind_speed_mph' => $rawData['windspeedmph'] ?? null,
            'pressure_inhg' => $rawData['pressure_inhg'] ?? null,
            'rain_rate_inph' => $rawData['rainratein'] ?? null,
            'solar_radiation_wpm2' => $rawData['solarradiation'] ?? null,
            'uv_index' => $rawData['uv'] ?? null,
            'raw_data' => json_encode($rawData),
            'measured_at' => $rawData['dateutc'] ?? now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('weather_data')->insert($data);
        return 'Success\n';
    } catch (\Exception $e) {
        \Log::error("Ecowitt API called failed: " . $e->getMessage());
        return "Ecowitt API mailfunction" . $e-> getMessage();
    }

});


//  WUNDERGROUND API
Route::get('/weatherstation/updateweatherstation.php', function (Request $request) {
    // Logs
    \Log::info('Wunderground API called', [
        'url' => $request->fullUrl(),
        'params' => $request->all(),
        'ip' => $request->ip()
    ]);
    try{
        $rawData = $request->all();
        if(!isset($rawData['ID'])) {
            return "\nstation_id is required";
        }
        $utcTime = $rawData['datautc'] ?? Carbon::now('UTC');
        $data = [
            'station_id' => $rawData['ID'],
            'data_source' => 'wunderstation',
            'temperature_f' => $rawData['tempf'] ?? null,
            'humidity_pct' => $rawData['humidity'] ?? null,
            'wind_direction_deg' => $rawData['winddir'] ?? null,
            'wind_speed_mph' => $rawData['windspeedmph'] ?? null,
            'pressure_inhg' => $rawData['baromin'] ?? null,
            'rain_rate_inph' => $rawData['rainin'] ?? null,
            'solar_radiation_wpm2' => $rawData['solarradiation'] ?? null,
            'uv_index' => $rawData['UV'] ?? null,
            'raw_data' => json_encode($rawData),
            'measured_at' => $utcTime,
            'created_at' => $utcTime,
            'updated_at' => $utcTime,
        ];

        DB::table('weather_data')->insert($data);
        return "\nsuccess";

    } catch (\Exception $e) {
        \Log::error("Ecowitt API mailfunction" . $e-> getMessage());
        return response("\nWunderStation API Mailfunction" . $e-> getMessage());
    }
});


Route::get('/health', function (Request $request) {
    \Log::info('Test route health', $request->all());

    // Just return success without DB operations
    return "success/n";
});
