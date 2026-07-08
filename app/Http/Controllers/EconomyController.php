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

        if ($country) {

            $response = Http::get(
                "https://api.worldbank.org/v2/country/{$country->iso2}/indicator/NY.GDP.MKTP.CD",
                [
                    'format' => 'json',
                    'per_page' => 1
                ]
            );

            if ($response->successful()) {

                $json = $response->json();

                if (isset($json[1][0])) {

                    $economy = $json[1][0];

                }

            }

        }

        return view(
            'economy.index',
            compact(
                'countries',
                'country',
                'economy'
            )
        );
    }
}