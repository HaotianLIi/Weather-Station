<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();

            // 1. identification info
            $table->string('station_id');          // ID OR Passkey
            $table->string('data_source');         // 'ecowitt' OR 'wunderground'

            // 2. Main info
            $table->float('temperature_f')->nullable();
            $table->integer('humidity_pct')->nullable();
            $table->float('wind_direction_deg')->nullable();
            $table->float('wind_speed_mph')->nullable();
            $table->float('pressure_inhg')->nullable();
            $table->float('rain_rate_inph')->nullable();
            $table->float('solar_radiation_wpm2')->nullable();
            $table->integer('uv_index')->nullable();

            // 3. Raw Data for all other devices and info
            $table->json('raw_data');
            // 4. Time
            $table->timestamp('measured_at');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->index(['station_id', 'measured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
