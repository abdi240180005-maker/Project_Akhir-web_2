<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $country = null;

        if ($request->filled('country')) {

            $country = Country::find($request->country);

        } else {

            $country = Country::first();

        }

        $weather = [];

        if ($country) {

            $response = Http::get(
    'https://api.open-meteo.com/v1/forecast',
    [
        'latitude' => $country->latitude,
        'longitude' => $country->longitude,
        'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code',
        'daily' => 'weather_code,temperature_2m_max,temperature_2m_min',
        'timezone' => 'auto'
    ]
);

            if ($response->successful()) {

                $weather = $response->json();

            }

        }

        return view(
            'weather.index',
            compact(
                'countries',
                'country',
                'weather'
            )
        );
    }
}