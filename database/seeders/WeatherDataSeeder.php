<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeatherDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            //Get Data from API
            $apiData = Http::get('https://weatherstation/updateweatherstation.php?ID=IU5E7FU442&PASSWORD=lsrling19')->json();

    }
}
