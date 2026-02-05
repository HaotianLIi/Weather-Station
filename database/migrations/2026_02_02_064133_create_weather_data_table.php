// database/migrations/2026_02_01_223326_create_weather_data_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     *  Run the migrations
     */
    public function up(): void
    {
        Schema::create('event', function(Blueprint $table){
            $table->id();
            $table->foreignId('station_id')
                  ->constrained('stations')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            // Columns from Ecowitt
            $table->decimal('tempinf');
            $table->decimal('humidityin');
            $table->decimal('baromrelin');
            $table->decimal('baromabsin');
            $table->decimal('tempf');
            $table->decimal('humidity');
            $table->decimal('winddir');
            $table->decimal('windspeedmph');
            $table->decimal('windgustmph');
            $table->decimal('maxdailygust');
            $table->decimal('solarradiantion');
            $table->integer('uv');
            $table->decimal('rainratein');
            $table->decimal('eventrainin');
            $table->decimal('hourlyrainin');
            $table->decimal('dailyrainin');
            $table->decimal('weeklyrainin');
            $table->decimal('monthlyrainin');
            $table->decimal('yearlyrainin');
            $table->decimal('totalrainin');
            $table->decimal('temp1f');
            $table->decimal('humidity1');
            $table->decimal('temp2f');
            $table->decimal('humidity2');
            $table->decimal('temp4f');
            $table->decimal('humidity4');
            $table->decimal('soilmoisture2');
            $table->decimal('soilmoisture3');
            $table->decimal('soilmoisture4');
            $table->decimal('soilmoisture5');
            $table->decimal('wh65batt');
            $table->decimal('wh68batt');
            $table->decimal('wh40batt');
            $table->decimal('wh26batt');
            $table->decimal('batt1');
            $table->decimal('batt2');
            $table->decimal('batt4');
            $table->decimal('batt6');
            $table->decimal('Sio1batt1');
            $table->decimal('Sio1batt2');
            $table->decimal('Sio1batt3');
            $table->decimal('Sio1batt4');
            $table->decimal('Sio1batt5');
            $table->decimal('Sio1batt6');
            $table->decimal('Sio1batt7');
            $table->decimal('Sio1batt8');
            $table->decimal('pm25batt1');
            $table->decimal('pm25batt2');
            $table->decimal('pm25batt3');
            $table->decimal('pm25batt4');
            // Columns from Wunderground

        });
    }

    public function down()
    {
        Schema::dropIfExists('weather_data');
    }
};
