<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2026_01_31_052749_create_weather_data_table.php

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weather_data', function (Blueprint $table) {
            //auto-increment
            $table->id();

            $table->string('station_id');
            $table->string('station_type');
            // Temperature
            $table->decimal('indoor_temp_f',4,2);
            $table->decimal('outdoor_temp_f',4,2);
            $table->decimal('dewpoint_temp_f',4,2);
            $table->decimal('windchill_temp_f',4,2);
            // Humidity
            $table->decimal('indoor_humidity_pct', 4,2);
            $table->decimal('outdoor_humidity_pct', 4,2);

            $table->decimal('relative_pressure');
            // Wind
            $table->integer('wind_direction');
            $table->decimal('wind_speed_mph', 4,2);
            $table->decimal('wind_gust_mph',4,2);
            // Rain
            $table->decimal('rain_in', 4,2);
            $table->decimal('daily_rain_in', 4,2);
            $table->decimal('monthly_rain_in',4,2);
            $table->decimal('yearly_rain_in',4,2);
            // Enviromental
            $table->decimal('solar_radiation',7,3);
            $table->integer('uv');
            $table->integer('ch1_soil_moisture_pct');
            $table->decimal('pm2pt5_ch1',5,2);

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
