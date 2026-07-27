<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComparisonController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $country1 = $request->filled('country1')
            ? Country::find($request->country1)
            : Country::first();

        $country2 = $request->filled('country2')
            ? Country::find($request->country2)
            : Country::skip(1)->first();

        $data1 = $this->getCountryData($country1);
        $data2 = $this->getCountryData($country2);

        $aiSummary = $this->generateAiComparisonSummary($country1, $country2, $data1, $data2);

        return view(
            'comparison.index',
            compact(
                'countries',
                'country1',
                'country2',
                'data1',
                'data2',
                'aiSummary'
            )
        );
    }

    private function getCountryData($country)
    {
        if (!$country) {
            return null;
        }

        $gdp = null;
        $inflation = null;

        /*
        |--------------------------------------------------------------------------
        | GDP
        |--------------------------------------------------------------------------
        */

        try {

            $response = Http::connectTimeout(5)
                ->timeout(10)
                ->get(
                    "https://api.worldbank.org/v2/country/{$country->iso2}/indicator/NY.GDP.MKTP.CD",
                    [
                        'format' => 'json',
                        'per_page' => 1
                    ]
                );

            if ($response->successful()) {

                $json = $response->json();

                if (isset($json[1][0]['value'])) {

                    $gdp = $json[1][0]['value'];

                }

            }

        } catch (\Exception $e) {

            $gdp = null;

        }

        /*
        |--------------------------------------------------------------------------
        | Inflasi
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

                if (isset($json[1][0]['value'])) {

                    $inflation = $json[1][0]['value'];

                }

            }

        } catch (\Exception $e) {
            $inflation = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Cuaca (Open-Meteo)
        |--------------------------------------------------------------------------
        */
        $weather = null;
        if ($country->latitude && $country->longitude) {
            try {
                $response = Http::connectTimeout(3)
                    ->timeout(5)
                    ->get('https://api.open-meteo.com/v1/forecast', [
                        'latitude' => $country->latitude,
                        'longitude' => $country->longitude,
                        'current' => 'temperature_2m,wind_speed_10m,relative_humidity_2m,weather_code'
                    ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $temp = $json['current']['temperature_2m'] ?? null;
                    $wind = $json['current']['wind_speed_10m'] ?? null;
                    $code = $json['current']['weather_code'] ?? 0;
                    
                    // Map WMO weather code to readable description
                    $condition = 'Cerah';
                    if (in_array($code, [1, 2, 3])) $condition = 'Berawan';
                    elseif (in_array($code, [45, 48])) $condition = 'Kabut';
                    elseif (in_array($code, [51, 53, 55, 61, 63, 65, 80, 81, 82])) $condition = 'Hujan';
                    elseif (in_array($code, [71, 73, 75, 77, 85, 86])) $condition = 'Salju';
                    elseif (in_array($code, [95, 96, 99])) $condition = 'Badai Petir';

                    $weather = [
                        'temp' => $temp,
                        'wind' => $wind,
                        'condition' => $condition,
                    ];
                }
            } catch (\Exception $e) {
                $weather = null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Risk (Database & Level mapping)
        |--------------------------------------------------------------------------
        */
        $riskScore = $country->risk_score ?? 35;
        if ($riskScore <= 30) {
            $riskLevel = 'Rendah';
        } elseif ($riskScore <= 60) {
            $riskLevel = 'Sedang';
        } else {
            $riskLevel = 'Tinggi';
        }

        return [

            'gdp' => $gdp,

            'inflation' => $inflation,

            'currency' => $country->currency,

            'capital' => $country->capital,

            'region' => $country->region,

            'weather' => $weather,

            'risk_score' => $riskScore,

            'risk_level' => $riskLevel,

        ];
    }

    private function generateAiComparisonSummary($country1, $country2, $data1, $data2)
    {
        if (!$country1 || !$country2 || !$data1 || !$data2) {
            return null;
        }

        $gdp1 = $data1['gdp'] ?? 0;
        $gdp2 = $data2['gdp'] ?? 0;
        $score1 = $data1['risk_score'] ?? 50;
        $score2 = $data2['risk_score'] ?? 50;
        $inf1 = $data1['inflation'] ?? 0;
        $inf2 = $data2['inflation'] ?? 0;

        $recommended = null;
        $reason = [];

        if ($score1 < $score2) {
            $recommended = $country1->name;
            $reason[] = "memiliki skor risiko rantai pasok yang lebih rendah ({$score1} vs {$score2})";
        } elseif ($score2 < $score1) {
            $recommended = $country2->name;
            $reason[] = "memiliki skor risiko rantai pasok yang lebih rendah ({$score2} vs {$score1})";
        }

        if ($gdp1 > $gdp2) {
            $reason[] = "ukuran ekonomi (GDP) {$country1->name} lebih dominan";
        } elseif ($gdp2 > $gdp1) {
            $reason[] = "ukuran ekonomi (GDP) {$country2->name} lebih dominan";
        }

        if ($inf1 !== null && $inf2 !== null) {
            if ($inf1 < $inf2) {
                $reason[] = "stabilitas inflasi {$country1->name} (" . number_format($inf1, 1) . "%) lebih terkendali dibanding {$country2->name} (" . number_format($inf2, 1) . "%)";
            } elseif ($inf2 < $inf1) {
                $reason[] = "stabilitas inflasi {$country2->name} (" . number_format($inf2, 1) . "%) lebih terkendali dibanding {$country1->name} (" . number_format($inf1, 1) . "%)";
            }
        }

        $summaryText = "Berdasarkan analisis komparatif intelijen rantai pasok, ";
        if ($recommended) {
            $summaryText .= "<strong>{$recommended}</strong> direkomendasikan sebagai mitra perdagangan / jalur logistik yang lebih optimal karena " . implode(', serta ', $reason) . ".";
        } else {
            $summaryText .= "kedua negara memiliki profil risiko yang relatif seimbang dengan pertimbangan kondisi makro ekonomi masing-masing.";
        }

        return $summaryText;
    }
}