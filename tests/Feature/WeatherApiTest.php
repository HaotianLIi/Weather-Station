<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherApiTest extends TestCase
{
    use RefreshDatabase;

    // ─── Health check ────────────────────────────────────────────────────────

    public function test_health_endpoint_returns_ok(): void
    {
        $response = $this->get('/health');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'ok']);
    }

    // ─── Ecowitt API ─────────────────────────────────────────────────────────

    public function test_ecowitt_stores_weather_data(): void
    {
        $response = $this->post('/api/data/report', [
            'PASSKEY'       => 'ABC123TEST',
            'stationtype'   => 'GW1000_V1.4.7',
            'tempf'         => '72.5',
            'humidity'      => '65',
            'winddir'       => '180',
            'windspeedmph'  => '5.2',
            'solarradiation' => '300.5',
            'uv'            => '2',
            'dateutc'       => '2026-01-01 12:00:00',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('weather_data', [
            'station_id'  => 'ABC123TEST',
            'data_source' => 'ecowitt',
        ]);
    }

    public function test_ecowitt_rejects_missing_passkey(): void
    {
        $response = $this->post('/api/data/report', [
            'tempf'    => '72.5',
            'humidity' => '65',
        ]);

        $response->assertStatus(200);
        $this->assertStringContainsString('PASSKEY is required', $response->getContent());
        $this->assertDatabaseCount('weather_data', 0);
    }

    // ─── Wunderground API ────────────────────────────────────────────────────

    public function test_wunderground_stores_weather_data(): void
    {
        $response = $this->get(
            '/api/weatherstation/updateweatherstation.php?ID=STATION_WU_001&tempf=74.1&humidity=58&winddir=270&windspeedmph=8.0&baromin=29.92&datautc=2026-01-01+12:00:00'
        );

        $response->assertStatus(200);
        $this->assertDatabaseHas('weather_data', [
            'station_id'  => 'STATION_WU_001',
            'data_source' => 'wunderstation',
        ]);
    }

    public function test_wunderground_rejects_missing_id(): void
    {
        $response = $this->get(
            '/api/weatherstation/updateweatherstation.php?tempf=74.1&humidity=58'
        );

        $response->assertStatus(200);
        $this->assertStringContainsString('station_id is required', $response->getContent());
        $this->assertDatabaseCount('weather_data', 0);
    }
}
