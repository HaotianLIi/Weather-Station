<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeatherApiTest extends TestCase
{
    use RefreshDatabase;

    // 添加这个确保迁移运行
    protected function setUp(): void
    {
        parent::setUp();

        // 确保迁移运行
        if (!\Illuminate\Support\Facades\Schema::hasTable('weather_data')) {
            $this->artisan('migrate');
        }
    }

    public function test_apis_respond()
    {
        $response = $this->post('/api/data/report');
        $response->assertOk();

        $response = $this->get('/api/wunderground/updateweatherstation');
        $response->assertOk();
    }

    public function test_simple_data_insert()
    {
        // 先检查表是否存在
        $this->assertTrue(
            \Illuminate\Support\Facades\Schema::hasTable('weather_data'),
            'weather_data 表应该存在'
        );

        $response = $this->post('/api/data/report', [
            'PASSKEY' => 'TEST',
            'tempf' => 70.0,
            'dateutc' => '2024-01-15 14:30:00'
        ]);

        $response->assertStatus(200);
    }
}
