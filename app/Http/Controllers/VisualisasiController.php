<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisualisasiController extends Controller
{
    public function index()
    {
        // 1. KPI Summary Cards
        $totalCountries = Country::count();
        $avgGlobalRisk = round(Country::avg('risk_score') ?: 0, 1);
        $highRiskCount = Country::where('risk_score', '>', 65)->count();
        $totalPorts = Port::count();

        // 2. Risk Counts (Doughnut Chart)
        $lowRisk = Country::where('risk_score', '<=', 35)->count();
        $mediumRisk = Country::where('risk_score', '>', 35)->where('risk_score', '<=', 65)->count();
        $highRisk = Country::where('risk_score', '>', 65)->count();

        $riskCounts = [
            'Low' => $lowRisk,
            'Medium' => $mediumRisk,
            'High' => $highRisk
        ];

        // 3. Top 10 Countries by Risk Score (Horizontal Bar Chart)
        $topRiskObj = Country::orderByDesc('risk_score')
            ->limit(10)
            ->get(['name', 'risk_score']);
        
        $topRisk = [
            'labels' => $topRiskObj->pluck('name')->toArray(),
            'data' => $topRiskObj->pluck('risk_score')->toArray()
        ];

        // 4. Top 10 Countries by Port Infrastructure Count (Vertical Bar Chart)
        $topPortsObj = Port::select('ports.country as country_code', 'countries.name as country_name')
            ->selectRaw('count(ports.id) as total')
            ->join('countries', 'countries.iso2', '=', 'ports.country')
            ->groupBy('ports.country', 'countries.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
        
        $topPorts = [
            'labels' => $topPortsObj->pluck('country_name')->toArray(),
            'data' => $topPortsObj->pluck('total')->toArray()
        ];

        // 5. Correlation Data (Bubble Chart)
        $correlationDataObj = Country::whereNotNull('inflation_rate')
            ->whereNotNull('risk_score')
            ->where('population', '>', 0)
            ->get()
            ->map(function ($c) {
                $pop = $c->population;
                $r = 5;
                if ($pop > 0) {
                    $r = 3 + (log10($pop) - 5) * 3;
                    $r = max(3, min(25, $r));
                }
                return [
                    'x' => round($c->inflation_rate, 2),
                    'y' => (int) $c->risk_score,
                    'r' => round($r, 1),
                    'country' => $c->name
                ];
            });

        $correlationData = json_encode($correlationDataObj->values()->toArray());

        // 6. Global Averages for Radar Comparison
        $avgInflation = Country::avg('inflation_rate') ?: 3.5;
        $avgPopulation = Country::avg('population') ?: 30000000;
        $avgPorts = $totalCountries > 0 ? ($totalPorts / $totalCountries) : 1;
        $avgTemp = 24.5; // Constant fallback average temperature

        $normalize = function ($val, $max) {
            return min(100, max(0, ($val / $max) * 100));
        };
        $normalizeLog = function ($val, $maxLog) {
            if ($val <= 0) return 0;
            return min(100, max(0, (log10($val) / $maxLog) * 100));
        };

        $globalAverages = [
            'risk' => round($avgGlobalRisk, 1),
            'inflation' => round($normalize($avgInflation, 15), 1),
            'temp' => round($normalize($avgTemp, 40), 1),
            'population' => round($normalizeLog($avgPopulation, 9), 1),
            'ports' => round($normalize($avgPorts, 30), 1),
        ];

        // 7. Complete list of countries for dropdown selector
        $countries = Country::orderBy('name')->get();

        // 8. Countries JSON for real-time profiling updates in Javascript
        $countriesJson = $countries->map(function ($c) {
            $portsCount = Port::where('country', $c->iso2)->count();
            return [
                'id' => $c->id,
                'name' => $c->name,
                'iso2' => $c->iso2,
                'capital' => $c->capital ?: '-',
                'currency' => $c->currency ?: '-',
                'population' => $c->population ?: 0,
                'ports_count' => $portsCount,
                'risk_score' => $c->risk_score ?: 0,
                'latitude' => $c->latitude,
                'longitude' => $c->longitude,
                'flag' => $c->flag, // Emoji flag
                'inflation_rate' => $c->inflation_rate ?: 0,
            ];
        })->keyBy('iso2')->toJson();

        return view('visualisasi.index', compact(
            'totalCountries',
            'avgGlobalRisk',
            'highRiskCount',
            'totalPorts',
            'riskCounts',
            'topRisk',
            'topPorts',
            'correlationData',
            'globalAverages',
            'countries',
            'countriesJson'
        ));
    }
}
