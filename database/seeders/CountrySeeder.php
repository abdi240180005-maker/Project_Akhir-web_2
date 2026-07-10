<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Country::truncate();

        $path = database_path('data/countries.json');

        if (!file_exists($path)) {
            $this->command->error('File countries.json tidak ditemukan.');
            return;
        }

        $countries = json_decode(file_get_contents($path), true);

        foreach ($countries as $country) {

            Country::create([

                'name' => $country['name']['common'] ?? $country['name'] ?? null,

                'iso2' => trim($country['cca2'] ?? ''),

                'iso3' => trim($country['cca3'] ?? ''),

                'capital' => $country['capital'][0] ?? null,

                'region' => $country['region'] ?? null,

                'subregion' => $country['subregion'] ?? null,

                'currency' => isset($country['currencies'])
                    ? implode(',', array_keys($country['currencies']))
                    : null,

                'population' => (int)($country['population'] ?? 0),

                'latitude' => $country['latlng'][0] ?? null,

                'longitude' => $country['latlng'][1] ?? null,

                'flag' => $country['flag']
                    ?? ($country['flag']['emoji'] ?? null),

            ]);
        }

        $this->command->info(
            'Import negara berhasil: ' . Country::count() . ' data.'
        );
    }
}