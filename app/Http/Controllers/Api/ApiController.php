<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SentimentController;

class ApiController extends Controller
{
    private function getRegion($countryCode) {
        $country = strtoupper($countryCode);
        $asia = ['ID', 'MY', 'SG', 'TH', 'VN', 'PH', 'CN', 'JP', 'KR', 'IN', 'PK', 'BD', 'IR', 'IQ', 'SA', 'AE', 'QA', 'LK', 'MM', 'KH', 'LA'];
        $europe = ['GB', 'DE', 'FR', 'IT', 'ES', 'NL', 'BE', 'CH', 'SE', 'NO', 'FI', 'DK', 'PL', 'UA', 'RU', 'TR', 'GR', 'IE', 'PT', 'AT'];
        $africa = ['ZA', 'EG', 'NG', 'KE', 'MA', 'DZ', 'AO', 'GH', 'ET', 'TZ', 'UG', 'SD', 'EH', 'LY', 'TN', 'CI', 'SN', 'CM', 'MZ'];
        $americas = ['US', 'CA', 'MX', 'BR', 'AR', 'CO', 'PE', 'CL', 'VE', 'EC', 'GT', 'CU', 'PR', 'PA', 'CR', 'JM'];
        if (in_array($country, $asia)) return 'Asia';
        if (in_array($country, $europe)) return 'Europe';
        if (in_array($country, $africa)) return 'Africa';
        if (in_array($country, $americas)) return 'Americas';
        return 'Oceania';
    }

    public function countries()
    {
        $countries = Country::orderBy('name')->get();
        return response()->json([
            'status' => 'success',
            'count' => $countries->count(),
            'data' => $countries
        ]);
    }

    public function risk(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id'
        ]);

        $country = Country::find($request->country_id);

        // 1. Weather Risk (30%) - open-meteo API
        $temp = 25;
        $precip = 0;
        $wind = 10;
        try {
            $weatherResponse = Http::timeout(5)->get("https://api.open-meteo.com/v1/forecast", [
                'latitude' => $country->latitude ?? -6.2,
                'longitude' => $country->longitude ?? 106.8,
                'current' => 'temperature_2m,wind_speed_10m,precipitation'
            ]);
            if ($weatherResponse->successful()) {
                $weather = $weatherResponse->json();
                $temp = $weather['current']['temperature_2m'] ?? 25;
                $precip = $weather['current']['precipitation'] ?? 0;
                $wind = $weather['current']['wind_speed_10m'] ?? 10;
            }
        } catch (\Exception $e) {}

        $weatherRisk = 10;
        if ($temp > 35 || $temp < 10) $weatherRisk += 10;
        if ($precip > 5 || $wind > 20) $weatherRisk += 10;
        $weatherRisk = min(30, $weatherRisk);

        // 2. Inflation Risk (20%)
        $inf = $country->inflation_rate ?? 3.5;
        $inflationRisk = 5;
        if ($inf > 10) $inflationRisk = 20;
        elseif ($inf > 5) $inflationRisk = 15;
        elseif ($inf > 2) $inflationRisk = 10;

        // 3. Exchange Rate Risk (10%)
        $currencyRisk = 5;
        $primaryCurrencies = explode(',', $country->currency ?? 'USD');
        $mainCurrency = $primaryCurrencies[0] ?? 'USD';
        try {
            $rateResponse = Http::timeout(5)->get('https://open.er-api.com/v6/latest/USD');
            if ($rateResponse->successful()) {
                $rates = $rateResponse->json()['rates'] ?? [];
                $rate = $rates[$mainCurrency] ?? 1.0;
                if ($rate > 1000) $currencyRisk = 10;
                elseif ($rate > 100) $currencyRisk = 8;
                elseif ($rate > 10) $currencyRisk = 6;
                else $currencyRisk = 4;
            }
        } catch (\Exception $e) {}

        // 4. News Sentiment Risk (40%) - lexicon PHP analysis
        $sentimentVal = 'Neutral';
        $sentimentRisk = 20; // default neutral
        try {
            $newsResponse = Http::timeout(5)->get('https://gnews.io/api/v4/search', [
                'q' => $country->name,
                'lang' => 'en',
                'max' => 3,
                'apikey' => env('GNEWS_API_KEY')
            ]);
            if ($newsResponse->successful()) {
                $articles = $newsResponse->json()['articles'] ?? [];
                if (count($articles) > 0) {
                    $sentimentController = new SentimentController();
                    $posCount = 0;
                    $negCount = 0;
                    foreach ($articles as $art) {
                        $text = $art['title'] . ' ' . ($art['description'] ?? '');
                        $analysis = $sentimentController->analyze($text);
                        if ($analysis['sentiment'] === 'Positive') $posCount++;
                        elseif ($analysis['sentiment'] === 'Negative') $negCount++;
                    }
                    if ($posCount > $negCount) {
                        $sentimentVal = 'Positive';
                        $sentimentRisk = 10;
                    } elseif ($negCount > $posCount) {
                        $sentimentVal = 'Negative';
                        $sentimentRisk = 40;
                    }
                }
            }
        } catch (\Exception $e) {}

        $totalRisk = $weatherRisk + $inflationRisk + $currencyRisk + $sentimentRisk;

        return response()->json([
            'status' => 'success',
            'data' => [
                'country' => $country->name,
                'indicators' => [
                    'temperature' => $temp . ' °C',
                    'precipitation' => $precip . ' mm',
                    'wind_speed' => $wind . ' km/h',
                    'inflation_rate' => $inf . ' %',
                    'currency' => $mainCurrency,
                    'news_sentiment' => $sentimentVal
                ],
                'scoring' => [
                    'weather_risk' => $weatherRisk . ' / 30',
                    'inflation_risk' => $inflationRisk . ' / 20',
                    'currency_risk' => $currencyRisk . ' / 10',
                    'news_risk' => $sentimentRisk . ' / 40',
                    'total_risk_score' => $totalRisk . ' / 100'
                ],
                'risk_level' => $totalRisk < 35 ? 'Low Risk' : ($totalRisk < 60 ? 'Medium Risk' : 'High Risk')
            ]
        ]);
    }

    public function ports(Request $request)
    {
        $query = Port::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('port_name', 'like', '%' . $request->search . '%')
                  ->orWhere('country', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        $ports = $query->orderBy('port_name')->limit(50)->get();

        foreach ($ports as $port) {
            $delay = abs(crc32($port->port_name) % 36);
            $port->delay_hours = $delay;
            $port->wpi_code = "WPI-" . (10000 + ($port->id % 90000));
            $port->region = $this->getRegion($port->country);
            $port->congestion = $delay < 10 ? 'Rendah' : ($delay < 24 ? 'Sedang' : 'Tinggi');
        }

        return response()->json([
            'status' => 'success',
            'count' => $ports->count(),
            'data' => $ports
        ]);
    }

    public function news(Request $request)
    {
        $category = $request->get('category', 'logistics');
        
        $response = Http::get('https://gnews.io/api/v4/search', [
            'q' => $category,
            'lang' => 'en',
            'max' => 10,
            'apikey' => env('GNEWS_API_KEY'),
        ]);

        $articles = [];
        if ($response->successful()) {
            $articles = $response->json()['articles'] ?? [];
            $sentimentController = new SentimentController();
            foreach ($articles as &$article) {
                $text = ($article['title'] ?? '') . ' ' . ($article['description'] ?? '');
                $analysis = $sentimentController->analyze($text);
                $article['sentiment'] = $analysis['sentiment'] ?? 'Neutral';
            }
            unset($article);
        }

        return response()->json([
            'status' => 'success',
            'category' => $category,
            'count' => count($articles),
            'data' => $articles
        ]);
    }

    public function currency(Request $request)
    {
        $base = $request->get('base', 'USD');
        $rates = [];
        try {
            $response = Http::get("https://open.er-api.com/v6/latest/{$base}");
            if ($response->successful()) {
                $rates = $response->json()['rates'] ?? [];
            }
        } catch (\Exception $e) {}

        return response()->json([
            'status' => 'success',
            'base' => $base,
            'rates' => $rates
        ]);
    }
}
