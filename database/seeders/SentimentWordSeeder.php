<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositiveWord;
use App\Models\NegativeWord;

class SentimentWordSeeder extends Seeder
{
    public function run(): void
    {
        $positiveWords = [
            'growth', 'increase', 'increases', 'increasing', 'profit', 'profits', 'stable', 'stability', 
            'improve', 'improves', 'improved', 'improving', 'booming', 'recovery', 
            'success', 'successful', 'safe', 'rise', 'rises', 'rising', 'expansion', 'surplus', 
            'gain', 'gains', 'advance', 'advances', 'progress', 'benefit', 'benefits', 
            'opportunity', 'opportunities', 'strong', 'robust', 'favorable',
            'optimistic', 'boost', 'boosts', 'upgrade', 'secure', 'peace', 'prosperity', 'innovation'
        ];

        $negativeWords = [
            'war', 'wars', 'crisis', 'crises', 'inflation', 'inflationary', 'delay', 'delays', 'delayed', 
            'disaster', 'decline', 'declines', 'declining', 'drop', 'drops', 
            'loss', 'losses', 'strike', 'strikes', 'shortage', 'shortages', 'conflict', 'conflicts', 
            'risk', 'risks', 'risky', 'sanction', 'sanctions', 'recession', 
            'disruption', 'disruptions', 'decrease', 'decreases', 'decreasing', 'collapse', 
            'threat', 'threats', 'tensions', 'uncertainty', 'vulnerable', 'embargo', 
            'damage', 'failure', 'panic', 'halt', 'plunge', 'plunges'
        ];

        foreach ($positiveWords as $word) {
            PositiveWord::firstOrCreate(['word' => strtolower($word)]);
        }

        foreach ($negativeWords as $word) {
            NegativeWord::firstOrCreate(['word' => strtolower($word)]);
        }
    }
}
