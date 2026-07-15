<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\Http;

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

        // 1. Ambil data Populasi dari RestCountries v5 (Paging)
        $this->command->info('Mengambil data Populasi dari RestCountries v5...');
        $populationData = [];
        $apiKey = env('RESTCOUNTRIES_API_KEY') ?: 'rc_live_31a5733e1b264ce59464be5edf44b263';

        for ($offset = 0; $offset < 300; $offset += 100) {
            try {
                $response = Http::timeout(15)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $apiKey
                    ])
                    ->get('https://api.restcountries.com/countries/v5', [
                        'limit' => 100,
                        'offset' => $offset
                    ]);

                if ($response->successful()) {
                    $json = $response->json();
                    if (isset($json['data']['objects'])) {
                        $objects = $json['data']['objects'];
                        if (count($objects) === 0) {
                            break;
                        }
                        foreach ($objects as $obj) {
                            $iso3 = strtoupper(trim($obj['codes']['alpha_3'] ?? ''));
                            $pop = (int)($obj['population'] ?? 0);
                            if ($iso3 && $pop > 0) {
                                $populationData[$iso3] = $pop;
                            }
                        }
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            } catch (\Exception $e) {
                $this->command->warn('Gagal mengambil data populasi pada offset ' . $offset . ': ' . $e->getMessage());
                break;
            }
        }
        $this->command->info('Berhasil memuat ' . count($populationData) . ' data populasi.');

        // 2. Ambil data GDP dari World Bank
        $this->command->info('Mengambil data GDP dari World Bank...');
        $gdpData = [];
        try {
            $response = Http::timeout(15)->get('https://api.worldbank.org/v2/country/all/indicator/NY.GDP.MKTP.CD', [
                'format' => 'json',
                'per_page' => 300,
                'date' => '2022'
            ]);
            if ($response->successful()) {
                $json = $response->json();
                if (isset($json[1]) && is_array($json[1])) {
                    foreach ($json[1] as $item) {
                        if (!empty($item['countryiso3code']) && isset($item['value'])) {
                            $gdpData[strtoupper($item['countryiso3code'])] = $item['value'];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->command->warn('Gagal mengambil data GDP dari World Bank, menggunakan fallback.');
        }

        // 3. Ambil data Inflasi dari World Bank
        $this->command->info('Mengambil data Inflasi dari World Bank...');
        $inflationData = [];
        try {
            $response = Http::timeout(15)->get('https://api.worldbank.org/v2/country/all/indicator/FP.CPI.TOTL.ZG', [
                'format' => 'json',
                'per_page' => 300,
                'date' => '2022'
            ]);
            if ($response->successful()) {
                $json = $response->json();
                if (isset($json[1]) && is_array($json[1])) {
                    foreach ($json[1] as $item) {
                        if (!empty($item['countryiso3code']) && isset($item['value'])) {
                            $inflationData[strtoupper($item['countryiso3code'])] = $item['value'];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->command->warn('Gagal mengambil data Inflasi dari World Bank, menggunakan fallback.');
        }

        $this->command->info('Memproses dan menyimpan data negara...');
        foreach ($countries as $country) {
            $iso2 = trim($country['cca2'] ?? '');
            $iso3 = strtoupper(trim($country['cca3'] ?? ''));
            $unMember = $country['unMember'] ?? false;
            $independent = $country['independent'] ?? false;

            // Set Populasi
            $population = $populationData[$iso3] ?? 0;
            if ($population === 0) {
                $population = (int)($country['population'] ?? 0);
                if ($population === 0) {
                    $population = rand(1000000, 50000000); // acak rasional
                }
            }
            
            // Tentukan GDP
            $gdp = $gdpData[$iso3] ?? null;
            if (empty($gdp)) {
                $gdp = $population * rand(1000, 50000);
            }

            // Tentukan Inflasi
            $inflation = $inflationData[$iso3] ?? null;
            if (empty($inflation)) {
                $inflation = rand(15, 80) / 10;
            }

            // Hitung Skor Risiko
            $currency = isset($country['currencies'])
                ? implode(',', array_keys($country['currencies']))
                : null;
            
            $weatherRisk = rand(1, 3) * 10; // 10, 20, 30
            $inflationRisk = ($inflation < 3) ? 10 : (($inflation < 6) ? 20 : 30);
            
            $primaryCurrencies = explode(',', $currency ?? '');
            $mainCurrency = $primaryCurrencies[0] ?? '';
            
            if (in_array($mainCurrency, ['USD', 'EUR'])) {
                $currencyRisk = 5;
            } elseif (in_array($mainCurrency, ['JPY', 'SGD'])) {
                $currencyRisk = 10;
            } else {
                $currencyRisk = 20;
            }
            
            $newsRisk = [5, 10, 15, 20, 25][array_rand([5, 10, 15, 20, 25])];
            
            $riskScore = $weatherRisk + $inflationRisk + $currencyRisk + $newsRisk;

            Country::create([
                'name' => $country['name']['common'] ?? $country['name'] ?? null,
                'iso2' => $iso2,
                'iso3' => $iso3,
                'capital' => $country['capital'][0] ?? null,
                'region' => $country['region'] ?? null,
                'subregion' => $country['subregion'] ?? null,
                'currency' => $currency,
                'population' => $population,
                'latitude' => $country['latlng'][0] ?? null,
                'longitude' => $country['latlng'][1] ?? null,
                'flag' => $country['flag'] ?? ($country['flag']['emoji'] ?? null),
                'un_member' => $unMember,
                'independent' => $independent,
                'gdp' => $gdp,
                'inflation_rate' => $inflation,
                'risk_score' => $riskScore,
            ]);
        }

        $this->command->info(
            'Import negara berhasil: ' . Country::count() . ' data.'
        );
    }
}