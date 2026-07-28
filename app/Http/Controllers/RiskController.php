<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SentimentController;

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

                    $inflationRisk = 5;

                } elseif ($inflation < 6) {

                    $inflationRisk = 10;

                } else {

                    $inflationRisk = 20;

                }

            } else {

                $inflationRisk = 10;

            }

        } catch (\Exception $e) {

            $inflationRisk = 10;

        }

        /*
        |--------------------------------------------------------------------------
        | MATA UANG (Currency - 10%)
        |--------------------------------------------------------------------------
        */

        $primaryCurrencies = explode(',', $country->currency ?? '');
        $mainCurrency = $primaryCurrencies[0] ?? '';

        if (in_array($mainCurrency, ['USD', 'EUR'])) {

            $currencyRisk = 2;

        } elseif (in_array($mainCurrency, ['JPY', 'SGD'])) {

            $currencyRisk = 5;

        } else {

            $currencyRisk = 10;

        }

        /*
        |--------------------------------------------------------------------------
        | BERITA SENTIMEN ANALISIS (News Sentiment - 40%)
        |--------------------------------------------------------------------------
        */

        $newsRisk = 20; // default medium
        $sentimentResult = 'Neutral';
        $sentimentText = '';
        $sentimentDetails = [
            'positive' => 0,
            'neutral'  => 100,
            'negative' => 0,
        ];

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

                $articles = $response->json()['articles'] ?? [];
                
                $posCount = 0;
                $neuCount = 0;
                $negCount = 0;
                $sentimentController = new SentimentController();

                foreach ($articles as $article) {
                    $text = ($article['title'] ?? '') . ' ' . ($article['description'] ?? '');
                    $analysis = $sentimentController->analyze($text);
                    $sentiment = $analysis['sentiment'] ?? 'Neutral';
                    
                    if ($sentiment === 'Positive') $posCount++;
                    elseif ($sentiment === 'Negative') $negCount++;
                    else $neuCount++;

                    $sentimentText .= ' ' . $text;
                }

                $totalArt = count($articles);
                if ($totalArt > 0) {
                    $sentimentDetails = [
                        'positive' => round(($posCount / $totalArt) * 100),
                        'neutral'  => round(($neuCount / $totalArt) * 100),
                        'negative' => round(($negCount / $totalArt) * 100),
                    ];
                }

                if (!empty(trim($sentimentText))) {
                    $sentimentAnalysis = $sentimentController->analyze($sentimentText);
                    $sentimentResult = $sentimentAnalysis['sentiment'] ?? 'Neutral';

                    if ($sentimentResult === 'Positive') {
                        $newsRisk = 10;
                    } elseif ($sentimentResult === 'Neutral') {
                        $newsRisk = 20;
                    } else {
                        $newsRisk = 40;
                    }
                }

            }

        } catch (\Exception $e) {

            $newsRisk = 20;

        }

        $totalRisk =
            $weatherRisk +
            $inflationRisk +
            $currencyRisk +
            $newsRisk;

        if ($totalRisk <= 35) {

            $status = 'Risiko Rendah';
            $color = 'success';

        } elseif ($totalRisk <= 65) {

            $status = 'Risiko Sedang';
            $color = 'warning';

        } else {

            $status = 'Risiko Tinggi';
            $color = 'danger';

        }

        $databaseArticles = \App\Models\Article::when($country, function ($query) use ($country) {
            $query->where('country', 'like', '%' . $country->name . '%');
        })->latest()->get();

        $aiRiskService = new \App\Services\AiRiskService();
        $aiSummary = $aiRiskService->generateExecutiveSummary(
            $country,
            $totalRisk,
            $status,
            $weatherRisk,
            $inflationRisk,
            $currencyRisk,
            $newsRisk,
            $sentimentResult
        );

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
                'color',
                'sentimentResult',
                'sentimentDetails',
                'databaseArticles',
                'aiSummary'
            )
        );
    }
}