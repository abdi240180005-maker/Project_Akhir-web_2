<?php

namespace App\Http\Controllers;

use App\Models\PositiveWord;
use App\Models\NegativeWord;

class SentimentController extends Controller
{
    /**
     * Lexicon-Based Sentiment Analysis Engine (Tanpa AI Berbayar)
     * Menggunakan kamus kata (dictionary) positif & negatif dari database.
     */
    public function analyze($text)
    {
        $rawText = strtolower($text);

        // Tokenisasi kata
        $rawWords = preg_split('/\s+/', $rawText);

        // Ambil daftar kata positif & negatif dari database
        $positiveWords = PositiveWord::pluck('word')->map(fn($w) => strtolower($w))->toArray();
        $negativeWords = NegativeWord::pluck('word')->map(fn($w) => strtolower($w))->toArray();

        $positiveMatches = [];
        $negativeMatches = [];
        $totalWords = 0;

        foreach ($rawWords as $rawWord) {
            $word = preg_replace('/[^a-z0-9]/', '', $rawWord);
            if (empty($word)) {
                continue;
            }

            $totalWords++;

            if (in_array($word, $positiveWords)) {
                $positiveMatches[] = $word;
            }

            if (in_array($word, $negativeWords)) {
                $negativeMatches[] = $word;
            }
        }

        $positiveCount = count($positiveMatches);
        $negativeCount = count($negativeMatches);
        $sentimentMatchedCount = $positiveCount + $negativeCount;
        
        // Hitung skor neutral dari sisa kata non-sentimen
        $neutralCount = max(0, $totalWords - $sentimentMatchedCount);

        // Hitung persentase sentimen (jika ada kata ber-sentimen, dihitung berdasarkan rasio sentimen, atau dari total kata)
        if ($sentimentMatchedCount > 0) {
            $positivePct = round(($positiveCount / $totalWords) * 100, 1);
            $negativePct = round(($negativeCount / $totalWords) * 100, 1);
            $neutralPct  = round(($neutralCount / $totalWords) * 100, 1);
        } else {
            $positivePct = 0;
            $negativePct = 0;
            $neutralPct  = 100;
        }

        // Tentukan Hasil Sentimen Akhir
        if ($positiveCount > $negativeCount) {
            $sentiment = 'Positive';
        } elseif ($negativeCount > $positiveCount) {
            $sentiment = 'Negative';
        } else {
            $sentiment = 'Neutral';
        }

        return [
            'sentiment'      => $sentiment,
            'positive_count' => $positiveCount,
            'negative_count' => $negativeCount,
            'neutral_count'  => $neutralCount,
            'total_words'    => $totalWords,
            'positive'       => $positivePct, // Output %
            'negative'       => $negativePct, // Output %
            'neutral'        => $neutralPct,  // Output %
            'positive_words' => array_values(array_unique($positiveMatches)),
            'negative_words' => array_values(array_unique($negativeMatches)),
        ];
    }
}