<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RiskController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $country = $request->filled('country')
            ? Country::find($request->country)
            : Country::first();

        $weatherRisk = 0;
        $inflationRisk = 0;
        $currencyRisk = 10;
        $newsRisk = 0;

        /*
        |--------------------------------------------------------------------------
        | CUACA (Open Meteo)
        |--------------------------------------------------------------------------
        */

        if ($country) {

            try {

                $response = Http::connectTimeout(5)
                    ->timeout(10)
                    ->get(
                        'https://api.open-meteo.com/v1/forecast',
                        [
                            'latitude' => $country->latitude,
                            'longitude' => $country->longitude,
                            'current' => 'wind_speed_10m'
                        ]
                    );

                if ($response->successful()) {

                    $wind =
                        $response->json()['current']['wind_speed_10m'] ?? 0;

                    if ($wind < 20) {
                        $weatherRisk = 10;
                    } elseif ($wind < 40) {
                        $weatherRisk = 20;
                    } else {
                        $weatherRisk = 30;
                    }

                }

            } catch (\Exception $e) {

                $weatherRisk = 10;

            }

        }

        /*
        |--------------------------------------------------------------------------
        | INFLASI (World Bank)
        |--------------------------------------------------------------------------
        */

        try {

            $response = Http::connectTimeout(5)
                ->timeout(10)
                ->get(
                    "https://api.worldbank.org/v2/country/{$country->iso2}/indicator/FP.CPI.TOTL.ZG",
                    [
                        'format' => 'json',
                        'per_page' => 1
                    ]
                );

            if ($response->successful()) {

                $json = $response->json();

                $inflation =
                    $json[1][0]['value'] ?? 0;

                if ($inflation < 3) {

                    $inflationRisk = 10;

                } elseif ($inflation < 6) {

                    $inflationRisk = 20;

                } else {

                    $inflationRisk = 30;

                }

            }

        } catch (\Exception $e) {

            $inflationRisk = 10;

        }

        /*
        |--------------------------------------------------------------------------
        | MATA UANG
        |--------------------------------------------------------------------------
        */

        if (in_array($country->currency, ['USD', 'EUR'])) {

            $currencyRisk = 5;

        } elseif (in_array($country->currency, ['JPY', 'SGD'])) {

            $currencyRisk = 10;

        } else {

            $currencyRisk = 20;

        }

        /*
        |--------------------------------------------------------------------------
        | BERITA
        |--------------------------------------------------------------------------
        */

        try {

            $response = Http::connectTimeout(5)
                ->timeout(10)
                ->get(
                    'https://gnews.io/api/v4/search',
                    [
                        'q' => $country->name,
                        'lang' => 'en',
                        'max' => 5,
                        'apikey' => env('GNEWS_API_KEY')
                    ]
                );

            if ($response->successful()) {

                $jumlah =
                    count($response->json()['articles'] ?? []);

                if ($jumlah <= 1) {

                    $newsRisk = 5;

                } elseif ($jumlah <= 3) {

                    $newsRisk = 15;

                } else {

                    $newsRisk = 25;

                }

            }

        } catch (\Exception $e) {

            $newsRisk = 10;

        }

        $totalRisk =
            $weatherRisk +
            $inflationRisk +
            $currencyRisk +
            $newsRisk;

        if ($totalRisk <= 30) {

            $status = 'Risiko Rendah';
            $color = 'success';

        } elseif ($totalRisk <= 60) {

            $status = 'Risiko Sedang';
            $color = 'warning';

        } else {

            $status = 'Risiko Tinggi';
            $color = 'danger';

        }

        return view(
            'risk.index',
            compact(
                'countries',
                'country',
                'weatherRisk',
                'inflationRisk',
                'currencyRisk',
                'newsRisk',
                'totalRisk',
                'status',
                'color'
            )
        );
    }
}