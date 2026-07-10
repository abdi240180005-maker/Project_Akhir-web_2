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

        return view(
            'comparison.index',
            compact(
                'countries',
                'country1',
                'country2',
                'data1',
                'data2'
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

        return [

            'gdp' => $gdp,

            'inflation' => $inflation,

            'currency' => $country->currency,

            'capital' => $country->capital,

            'region' => $country->region,

        ];
    }
}