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

        $json = file_get_contents($path);
        $countries = json_decode($json, true);

        foreach ($countries as $country) {

            Country::create([

                'name' => $country['name']['common'] ?? null,

                'iso2' => $country['cca2'] ?? null,

                'iso3' => $country['cca3'] ?? null,

                'capital' => $country['capital'][0] ?? null,

                'region' => $country['region'] ?? null,

                'subregion' => $country['subregion'] ?? null,

                'currency' => isset($country['currencies'])
                    ? implode(',', array_keys($country['currencies']))
                    : null,

                'population' => $country['population'] ?? 0,

                'latitude' => $country['latlng'][0] ?? null,

                'longitude' => $country['latlng'][1] ?? null,

                'flag' => $country['flag'] ?? null,

                'created_at' => now(),

                'updated_at' => now(),

            ]);
        }

        $this->command->info('Import negara berhasil: '.Country::count().' data.');
    }
}