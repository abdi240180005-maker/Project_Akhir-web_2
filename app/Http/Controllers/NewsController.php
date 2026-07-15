<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SentimentController;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'logistics');

        $categories = [
            'logistics' => 'Logistics',
            'trade'     => 'Trade',
            'shipping'  => 'Shipping',
            'economy'   => 'Economy',
        ];

        $response = Http::get(
            'https://gnews.io/api/v4/search',
            [
                'q'      => $category,
                'lang'   => 'en',
                'max'    => 10,
                'apikey' => env('GNEWS_API_KEY'),
            ]
        );

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

        return view(
            'news.index',
            compact(
                'articles',
                'category',
                'categories'
            )
        );
    }
}