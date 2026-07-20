<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $allCountries = Country::orderBy('name')->get();

        $selectedCountryCode = request()->input('selected_country', 'ID');
        $selectedCountryObj = Country::where('iso2', $selectedCountryCode)->first() ?: Country::first();
        $selectedCountryCode = $selectedCountryObj->iso2;

        // 1. Rest Countries API
        $restCountryData = null;
        try {
            $res = Http::timeout(3)->get("https://restcountries.com/v3.1/alpha/{$selectedCountryCode}");
            if ($res->successful()) {
                $json = $res->json();
                $cData = $json[0] ?? null;
                if ($cData) {
                    $currencies = $cData['currencies'] ?? [];
                    $currencyStr = '';
                    if (!empty($currencies)) {
                        $firstKey = array_key_first($currencies);
                        $currencyStr = $firstKey . ' (' . ($currencies[$firstKey]['name'] ?? '') . ')';
                    }

                    $restCountryData = [
                        'name' => $cData['name']['common'] ?? $selectedCountryObj->name,
                        'capital' => implode(', ', $cData['capital'] ?? [$selectedCountryObj->capital]),
                        'population' => $cData['population'] ?? $selectedCountryObj->population,
                        'currency' => $currencyStr ?: $selectedCountryObj->currency,
                        'flag' => $cData['flags']['png'] ?? "https://flagcdn.com/w320/" . strtolower($selectedCountryCode) . ".png",
                    ];
                }
            }
        } catch (\Exception $e) {}

        if (!$restCountryData) {
            $restCountryData = [
                'name' => $selectedCountryObj->name,
                'capital' => $selectedCountryObj->capital ?? '-',
                'population' => $selectedCountryObj->population ?? '-',
                'currency' => $selectedCountryObj->currency ?? '-',
                'flag' => "https://flagcdn.com/w320/" . strtolower($selectedCountryCode) . ".png",
            ];
        }

        // 2. World Bank API
        $gdpVal = null;
        $inflationVal = null;
        try {
            $gdpRes = Http::timeout(3)->get("https://api.worldbank.org/v2/country/{$selectedCountryCode}/indicator/NY.GDP.MKTP.CD", [
                'format' => 'json',
                'per_page' => 1
            ]);
            if ($gdpRes->successful()) {
                $gdpJson = $gdpRes->json();
                $gdpVal = $gdpJson[1][0]['value'] ?? null;
            }
        } catch (\Exception $e) {}

        try {
            $infRes = Http::timeout(3)->get("https://api.worldbank.org/v2/country/{$selectedCountryCode}/indicator/FP.CPI.TOTL.ZG", [
                'format' => 'json',
                'per_page' => 1
            ]);
            if ($infRes->successful()) {
                $infJson = $infRes->json();
                $inflationVal = $infJson[1][0]['value'] ?? null;
            }
        } catch (\Exception $e) {}

        if ($gdpVal === null) {
            $gdpVal = $selectedCountryObj->gdp;
        }
        if ($inflationVal === null) {
            $inflationVal = $selectedCountryObj->inflation_rate;
        }

        // 3. Open-Meteo API
        $weatherData = null;
        if ($selectedCountryObj->latitude && $selectedCountryObj->longitude) {
            try {
                $wRes = Http::timeout(3)->get('https://api.open-meteo.com/v1/forecast', [
                    'latitude' => $selectedCountryObj->latitude,
                    'longitude' => $selectedCountryObj->longitude,
                    'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code,precipitation'
                ]);
                if ($wRes->successful()) {
                    $wJson = $wRes->json();
                    $code = $wJson['current']['weather_code'] ?? 0;
                    
                    $condition = 'Cerah';
                    $icon = '☀️';
                    if (in_array($code, [1, 2, 3])) { $condition = 'Berawan'; $icon = '☁️'; }
                    elseif (in_array($code, [45, 48])) { $condition = 'Kabut'; $icon = '🌫️'; }
                    elseif (in_array($code, [51, 53, 55, 61, 63, 65, 80, 81, 82])) { $condition = 'Hujan'; $icon = '🌧️'; }
                    elseif (in_array($code, [71, 73, 75, 77, 85, 86])) { $condition = 'Salju'; $icon = '❄️'; }
                    elseif (in_array($code, [95, 96, 99])) { $condition = 'Badai'; $icon = '⛈️'; }

                    $weatherData = [
                        'temp' => $wJson['current']['temperature_2m'] ?? null,
                        'humidity' => $wJson['current']['relative_humidity_2m'] ?? null,
                        'wind' => $wJson['current']['wind_speed_10m'] ?? null,
                        'precipitation' => $wJson['current']['precipitation'] ?? null,
                        'condition' => $condition,
                        'icon' => $icon
                    ];
                }
            } catch (\Exception $e) {}
        }

        if (!$weatherData) {
            $weatherData = [
                'temp' => 28.5,
                'humidity' => 60,
                'wind' => 12.0,
                'precipitation' => 0,
                'condition' => 'Cerah',
                'icon' => '☀️'
            ];
        }

        $apiCountryData = array_merge($restCountryData, [
            'gdp' => $gdpVal,
            'inflation' => $inflationVal,
            'weather' => $weatherData
        ]);

        $isFavorite = \App\Models\MonitoredCountry::where('country_code', $selectedCountryCode)->exists();

        // Existing variables
        $totalCountries = Country::where(function ($query) {
                $query->where('un_member', true)
                      ->orWhere('independent', true);
            })->count();

        $weather = [];
        try {
            $weatherResponse = Http::timeout(5)->get(
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

        $currency = [];
        try {
            $currencyResponse = Http::timeout(5)->get(
                'https://open.er-api.com/v6/latest/USD'
            );
            if ($currencyResponse->successful()) {
                $currency = $currencyResponse->json();
            }
        } catch (\Exception $e) {}

        $primaryCurrencies = explode(',', $selectedCountryObj->currency ?? 'USD');
        $selectedCurrencyCode = trim($primaryCurrencies[0] ?? 'USD');
        if (empty($selectedCurrencyCode)) {
            $selectedCurrencyCode = 'USD';
        }
        $selectedCurrencyRate = $currency['rates'][$selectedCurrencyCode] ?? null;

        $articles = [];
        try {
            $newsResponse = Http::timeout(5)->get(
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

        $summaryCountries = [];
        $monitored = \App\Models\MonitoredCountry::all();

        if ($monitored->isNotEmpty()) {
            $codes = $monitored->pluck('country_code')->toArray();
            $countryList = Country::whereIn('iso2', $codes)->orderBy('name')->get();
        } else {
            $defaultCodes = ['ID', 'US', 'DE', 'JP', 'SG'];
            $countryList = Country::whereIn('iso2', $defaultCodes)->orderBy('name')->get();
        }

        foreach ($countryList as $c) {
            $temp = '--';
            if ($c->latitude && $c->longitude) {
                try {
                    $weatherResp = Http::timeout(1.5)->get('https://api.open-meteo.com/v1/forecast', [
                        'latitude' => $c->latitude,
                        'longitude' => $c->longitude,
                        'current' => 'temperature_2m'
                    ]);
                    if ($weatherResp->successful()) {
                        $temp = ($weatherResp->json()['current']['temperature_2m'] ?? '--') . '°C';
                    }
                } catch (\Exception $e) {
                    $temp = '--';
                }
            }

            $summaryCountries[] = [
                'name' => $c->name,
                'code' => $c->iso2,
                'flag' => $c->flag,
                'population' => $c->population,
                'currency' => $c->currency,
                'gdp' => $c->gdp,
                'inflation' => $c->inflation_rate,
                'weather' => $temp
            ];
        }

        return view(
            'dashboard.index',
            compact(
                'allCountries',
                'selectedCountryObj',
                'apiCountryData',
                'isFavorite',
                'totalCountries',
                'weather',
                'currency',
                'articles',
                'summaryCountries',
                'selectedCurrencyCode',
                'selectedCurrencyRate'
            )
        );
    }
}