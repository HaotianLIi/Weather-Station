<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $table = 'stations';  // Use 'stations' table

    protected $fillable = [
        'passkey',
        'station_type',
        'model',
        'frequency',
        'capabilities',
        'first_seen',
        'last_seen',
    ];

    protected $casts = [
        'capabilities' => 'array',
        'first_seen' => 'datetime',
        'last_seen' => 'datetime',
    ];

    public function weatherData()
    {
        return $this->hasMany(WeatherData::class, 'station_id');
    }

    public function latestWeatherData()
    {
        return $this->hasOne(WeatherData::class, 'station_id')->latest();
    }
}
