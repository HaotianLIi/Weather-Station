<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeatherDataController extends Controller
{
    /**
     * Get the latest reading from each station, or a specific station.
     * GET /api/weather/latest?station_id=xxx
     */
    public function latest(Request $request): JsonResponse
    {
        $query = DB::table('weather_data');

        if ($request->has('station_id')) {
            $query->where('station_id', $request->input('station_id'));
        }

        // Get the most recent reading per station
        $latestIds = DB::table('weather_data')
            ->select(DB::raw('MAX(id) as id'))
            ->when($request->has('station_id'), function ($q) use ($request) {
                $q->where('station_id', $request->input('station_id'));
            })
            ->groupBy('station_id');

        $data = DB::table('weather_data')
            ->joinSub($latestIds, 'latest', function ($join) {
                $join->on('weather_data.id', '=', 'latest.id');
            })
            ->get();

        return response()->json([
            'status' => 'ok',
            'count' => $data->count(),
            'data' => $data,
        ]);
    }

    /**
     * Get historical weather data with optional filters.
     * GET /api/weather/history?station_id=xxx&start=2026-01-01&end=2026-03-01&limit=100
     */
    public function history(Request $request): JsonResponse
    {
        $limit = min((int) ($request->input('limit', 100)), 1000);

        $query = DB::table('weather_data')
            ->orderBy('measured_at', 'desc')
            ->limit($limit);

        if ($request->has('station_id')) {
            $query->where('station_id', $request->input('station_id'));
        }

        if ($request->has('start')) {
            $query->where('measured_at', '>=', $request->input('start'));
        }

        if ($request->has('end')) {
            $query->where('measured_at', '<=', $request->input('end'));
        }

        $data = $query->get();

        return response()->json([
            'status' => 'ok',
            'count' => $data->count(),
            'limit' => $limit,
            'data' => $data,
        ]);
    }

    /**
     * List all known stations.
     * GET /api/weather/stations
     */
    public function stations(): JsonResponse
    {
        $stations = DB::table('weather_data')
            ->select(
                'station_id',
                'data_source',
                DB::raw('COUNT(*) as total_readings'),
                DB::raw('MIN(measured_at) as first_reading'),
                DB::raw('MAX(measured_at) as last_reading')
            )
            ->groupBy('station_id', 'data_source')
            ->get();

        return response()->json([
            'status' => 'ok',
            'count' => $stations->count(),
            'stations' => $stations,
        ]);
    }
}
