<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        // Jika Admin, arahkan ke Dashboard Admin
        if (Auth::user()->role === 'admin') {

            return redirect()->route('admin.dashboard');

        }

        // =========================
        // TOTAL COUNTRY
        // =========================

        $totalCountries = Country::count();

        // =========================
        // WEATHER
        // =========================

        $weather = [];

        try {

            $weatherResponse = Http::timeout(10)->get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => -6.2088,
                    'longitude' => 106.8456,
                    'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m'
                ]
            );

            if ($weatherResponse->successful()) {

                $weather = $weatherResponse->json();

            }

        } catch (\Exception $e) {}

        // =========================
        // CURRENCY
        // =========================

        $currency = [];

        try {

            $currencyResponse = Http::timeout(10)->get(
                'https://open.er-api.com/v6/latest/USD'
            );

            if ($currencyResponse->successful()) {

                $currency = $currencyResponse->json();

            }

        } catch (\Exception $e) {}

        // =========================
        // NEWS
        // =========================

        $articles = [];

        try {

            $newsResponse = Http::timeout(10)->get(
                'https://gnews.io/api/v4/search',
                [
                    'q' => 'supply chain',
                    'lang' => 'en',
                    'max' => 3,
                    'apikey' => env('GNEWS_API_KEY')
                ]
            );

            if ($newsResponse->successful()) {

                $articles = $newsResponse->json()['articles'] ?? [];

            }

        } catch (\Exception $e) {}

        return view(
            'dashboard.index',
            compact(
                'totalCountries',
                'weather',
                'currency',
                'articles'
            )
        );
    }
}