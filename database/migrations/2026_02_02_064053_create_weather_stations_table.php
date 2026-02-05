
// database/migrations/2026_02_01_223246_create_stations_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('passkey', 32)->unique(); // 0BA6979558C5D2ADB6B20F4B23A685AF
            $table->string('station_type'); // GW1000_V1.4.7
            $table->string('model')->default('GW1000');
            $table->string('frequency')->default('433M');
            $table->json('capabilities')->nullable(); // Store available sensors
            $table->timestamp('first_seen')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('stations');
    }
};
