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
        $posCount = 0;
        $neuCount = 0;
        $negCount = 0;

        if ($response->successful()) {
            $articles = $response->json()['articles'] ?? [];
            
            $sentimentController = new SentimentController();
            foreach ($articles as &$article) {
                $text = ($article['title'] ?? '') . ' ' . ($article['description'] ?? '');
                $analysis = $sentimentController->analyze($text);
                $sentiment = $analysis['sentiment'] ?? 'Neutral';
                $article['sentiment'] = $sentiment;

                if ($sentiment === 'Positive') {
                    $posCount++;
                } elseif ($sentiment === 'Negative') {
                    $negCount++;
                } else {
                    $neuCount++;
                }
            }
            unset($article);
        }

        $totalArticles = count($articles);
        $sentimentSummary = [
            'positive' => $totalArticles > 0 ? round(($posCount / $totalArticles) * 100) : 0,
            'neutral'  => $totalArticles > 0 ? round(($neuCount / $totalArticles) * 100) : 0,
            'negative' => $totalArticles > 0 ? round(($negCount / $totalArticles) * 100) : 0,
        ];

        return view(
            'news.index',
            compact(
                'articles',
                'category',
                'categories',
                'sentimentSummary'
            )
        );
    }
}