<?php

namespace App\Http\Controllers;

use App\Models\MonitoredCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = MonitoredCountry::with('country')
            ->orderBy('country_name')
            ->paginate(10);

        // Fetch weather concurrent pool
        $responses = Http::pool(function (Pool $pool) use ($watchlists) {
            foreach ($watchlists as $item) {
                if ($item->country && $item->country->latitude && $item->country->longitude) {
                    $pool->as($item->country_code)->timeout(3)->get('https://api.open-meteo.com/v1/forecast', [
                        'latitude' => $item->country->latitude,
                        'longitude' => $item->country->longitude,
                        'current' => 'temperature_2m,weather_code'
                    ]);
                }
            }
        });

        foreach ($watchlists as $item) {
            $weather = null;
            if ($item->country && isset($responses[$item->country_code]) && $responses[$item->country_code] instanceof \Illuminate\Http\Client\Response && $responses[$item->country_code]->successful()) {
                $data = $responses[$item->country_code]->json();
                $temp = $data['current']['temperature_2m'] ?? null;
                $code = $data['current']['weather_code'] ?? 0;
                
                $condition = 'Cerah';
                $icon = '☀️';
                if (in_array($code, [1, 2, 3])) { $condition = 'Berawan'; $icon = '☁️'; }
                elseif (in_array($code, [45, 48])) { $condition = 'Kabut'; $icon = '🌫️'; }
                elseif (in_array($code, [51, 53, 55, 61, 63, 65, 80, 81, 82])) { $condition = 'Hujan'; $icon = '🌧️'; }
                elseif (in_array($code, [71, 73, 75, 77, 85, 86])) { $condition = 'Salju'; $icon = '❄️'; }
                elseif (in_array($code, [95, 96, 99])) { $condition = 'Badai'; $icon = '⛈️'; }
                
                $weather = [
                    'temp' => $temp,
                    'condition' => $condition,
                    'icon' => $icon
                ];
            } else {
                $weather = [
                    'temp' => 28.5,
                    'condition' => 'Cerah',
                    'icon' => '☀️'
                ];
            }
            $item->weather = $weather;

            // Calculate port congestion
            if ($item->country) {
                $ports = \App\Models\Port::where('country', $item->country_code)->get();
                $avgDelay = 0;
                if ($ports->isNotEmpty()) {
                    $totalDelay = 0;
                    foreach ($ports as $port) {
                        $totalDelay += abs(crc32($port->port_name) % 36);
                    }
                    $avgDelay = $totalDelay / $ports->count();
                } else {
                    $avgDelay = abs(crc32($item->country_name) % 36);
                }

                if ($avgDelay < 12) {
                    $item->port_congestion = 'Kepadatan Rendah';
                    $item->port_congestion_class = 'bg-success bg-opacity-10 text-success border border-success-subtle';
                } elseif ($avgDelay < 24) {
                    $item->port_congestion = 'Kepadatan Sedang';
                    $item->port_congestion_class = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle';
                } else {
                    $item->port_congestion = 'Kepadatan Tinggi';
                    $item->port_congestion_class = 'bg-danger bg-opacity-10 text-danger border border-danger-subtle';
                }
            } else {
                $item->port_congestion = 'Kepadatan Sedang';
                $item->port_congestion_class = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle';
            }
        }

        // Stats Cards Calculations
        $allMonitored = MonitoredCountry::with('country')->get();
        $totalDipantau = $allMonitored->count();
        $risikoTinggi = $allMonitored->filter(function ($item) {
            return $item->country && $item->country->risk_score > 60;
        })->count();
        $risikoSedangRendah = $allMonitored->filter(function ($item) {
            return !$item->country || $item->country->risk_score <= 60;
        })->count();

        return view(
            'watchlist.index',
            compact('watchlists', 'totalDipantau', 'risikoTinggi', 'risikoSedangRendah')
        );
    }

    public function destroy(MonitoredCountry $watchlist)
    {
        $watchlist->delete();

        return redirect()
            ->route('watchlist.index')
            ->with(
                'success',
                'Negara berhasil dihapus dari Daftar Negara Favorit.'
            );
    }
}