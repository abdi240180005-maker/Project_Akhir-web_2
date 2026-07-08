<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $response = Http::get(
            'https://gnews.io/api/v4/search',
            [
                'q'       => 'supply chain OR logistics OR economy',
                'lang'    => 'en',
                'max'     => 10,
                'apikey'  => env('GNEWS_API_KEY')
            ]
        );

        $articles = [];

        if ($response->successful()) {

            $articles = $response->json()['articles'] ?? [];

        }

        return view(
            'news.index',
            compact('articles')
        );
    }
}