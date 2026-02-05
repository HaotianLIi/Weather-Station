<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    use HasFactory;

    protected $table = 'weather_data';  // ← IMPORTANT: Use 'weather_data' table

    protected $fillable = [
        'station_id',
        'device_time',
        // Outdoor
        'tempf', 'humidity', 'winddir', 'windspeedmph', 'windgustmph', 'maxdailygust',
        // Indoor
        'tempinf', 'humidityin',
        // Pressure
        'baromrelin', 'baromabsin',
        // Solar/UV
        'solarradiation', 'uv',
        // Rain
        'rainratein', 'eventrainin', 'hourlyrainin', 'dailyrainin',
        'weeklyrainin', 'monthlyrainin', 'yearlyrainin', 'totalrainin',
        // Additional sensors
        'temp1f', 'humidity1', 'temp2f', 'humidity2', 'temp4f', 'humidity4',
        // Soil moisture
        'soilmoisture2', 'soilmoisture3', 'soilmoisture4', 'soilmoisture5',
        // Batteries
        'wh65batt', 'wh68batt', 'wh40batt', 'wh26batt',
        'batt1', 'batt2', 'batt4', 'batt6',
        'Siolbatt1', 'Siolbatt2', 'Siolbatt3', 'Siolbatt4',
        'Siolbatt5', 'Siolbatt6', 'Siolbatt7', 'Siolbatt8',
        'pm25batt1', 'pm25batt2', 'pm25batt3', 'pm25batt4',
        // Calculated
        'tempf_calculated', 'dew_point_f', 'heat_index_f',
        // Raw
        'raw_data',
    ];

    protected $casts = [
        'device_time' => 'datetime',
        'raw_data' => 'array',
    ];
    // Weather data belongs to A station
    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }
}
