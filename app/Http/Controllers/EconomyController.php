<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EconomyController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $country = $request->filled('country')
            ? Country::find($request->country)
            : Country::first();

        $economy = [];
        $inflation = null;

        if ($country) {

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
                            'per_page' => 1,
                        ]
                    );

                if ($response->successful()) {

                    $json = $response->json();

                    if (isset($json[1][0])) {

                        $economy = $json[1][0];

                    }

                }

            } catch (\Exception $e) {

                $economy = [];

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
                            'per_page' => 1,
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

        }

        return view(
            'economy.index',
            compact(
                'countries',
                'country',
                'economy',
                'inflation'
            )
        );
    }
}