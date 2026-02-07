<?php

namespace App\Models\Http\Controllers\Api;  // ← Should be in Api namespace!

use App\Models\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\WeatherData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EcowittController extends Controller
{
    public function report(Request $request)
    {
        Log::info('Ecowitt API called', $request->all());

        $validated = $request->validate([
            'PASSKEY' => 'required|string|min:10',
            'stationtype' => 'required|string',  // ← Changed from station_type to stationtype!
            'dateutc' => 'required|string',
        ]);

        // Find or create station
        $station = Station::firstOrCreate(
            ['passkey' => $validated['PASSKEY']],
            [
                'station_type' => $validated['stationtype'],  // ← Use validated data
                'model' => $request->input('model', 'GW1000'),
                'frequency' => $request->input('Freq', '433M'),
                'first_seen' => now(),
            ]
        );

        $station->update(['last_seen' => now()]);

        // Parse device time
        $deviceTime = $this->parseDeviceTime($request->input('dateutc'));

        // Prepare ALL data for saving
        $readingData = [
            'station_id' => $station->id,
            'device_time' => $deviceTime,

            // Map ALL fields from request to database columns
            'tempf' => $request->input('tempf'),
            'humidity' => $request->input('humidity'),
            'winddir' => $request->input('winddir'),
            'windspeedmph' => $request->input('windspeedmph'),
            'windgustmph' => $request->input('windgustmph'),
            'maxdailygust' => $request->input('maxdailygust'),
            'tempinf' => $request->input('tempinf'),
            'humidityin' => $request->input('humidityin'),
            'baromrelin' => $request->input('baromrelin'),
            'baromabsin' => $request->input('baromabsin'),
            'solarradiation' => $request->input('solarradiation'),
            'uv' => $request->input('uv'),
            'rainratein' => $request->input('rainratein'),
            'eventrainin' => $request->input('eventrainin'),
            'hourlyrainin' => $request->input('hourlyrainin'),
            'dailyrainin' => $request->input('dailyrainin'),
            'weeklyrainin' => $request->input('weeklyrainin'),
            'monthlyrainin' => $request->input('monthlyrainin'),
            'yearlyrainin' => $request->input('yearlyrainin'),
            'totalrainin' => $request->input('totalrainin'),
            'temp1f' => $request->input('temp1f'),
            'humidity1' => $request->input('humidity1'),
            'temp2f' => $request->input('temp2f'),
            'humidity2' => $request->input('humidity2'),
            'temp4f' => $request->input('temp4f'),
            'humidity4' => $request->input('humidity4'),
            'soilmoisture2' => $request->input('soilmoisture2'),
            'soilmoisture3' => $request->input('soilmoisture3'),
            'soilmoisture4' => $request->input('soilmoisture4'),
            'soilmoisture5' => $request->input('soilmoisture5'),
            'wh65batt' => $request->input('wh65batt'),
            'wh68batt' => $request->input('wh68batt'),
            'wh40batt' => $request->input('wh40batt'),
            'wh26batt' => $request->input('wh26batt'),
            'batt1' => $request->input('batt1'),
            'batt2' => $request->input('batt2'),
            'batt4' => $request->input('batt4'),
            'batt6' => $request->input('batt6'),
            'Siolbatt1' => $request->input('Siolbatt1'),
            'Siolbatt2' => $request->input('Siolbatt2'),
            'Siolbatt3' => $request->input('Siolbatt3'),
            'Siolbatt4' => $request->input('Siolbatt4'),
            'Siolbatt5' => $request->input('Siolbatt5'),
            'Siolbatt6' => $request->input('Siolbatt6'),
            'Siolbatt7' => $request->input('Siolbatt7'),
            'Siolbatt8' => $request->input('Siolbatt8'),
            'pm25batt1' => $request->input('pm25batt1'),
            'pm25batt2' => $request->input('pm25batt2'),
            'pm25batt3' => $request->input('pm25batt3'),
            'pm25batt4' => $request->input('pm25batt4'),

            // Calculated fields
            'tempf_calculated' => $request->input('tempf') ? ($request->input('tempf') - 32) * 5/9 : null,

            // Store raw data
            'raw_data' => $request->all(),
        ];

        // Create reading
        WeatherData::create($readingData);

        return response("success\n");
    }

    private function parseDeviceTime($dateutc)
    {
        try {
            // Ecowitt format: "2019-05-28+07:33:48"
            $dateString = str_replace('+', ' ', $dateutc);
            return \Carbon\Carbon::parse($dateString);
        } catch (\Exception $e) {
            Log::warning("Failed to parse dateutc: $dateutc", ['error' => $e->getMessage()]);
            return now();
        }
    }
}
