<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function index()
    {
        $response = Http::get(
            'https://open.er-api.com/v6/latest/USD'
        );

        $rates = [];

        if ($response->successful()) {

            $data = $response->json();

            $rates = [

                'USD' => $data['rates']['USD'],
                'IDR' => $data['rates']['IDR'],
                'EUR' => $data['rates']['EUR'],
                'JPY' => $data['rates']['JPY'],
                'SGD' => $data['rates']['SGD'],

            ];

        }

        return view(
            'currency.index',
            compact('rates')
        );
    }
}