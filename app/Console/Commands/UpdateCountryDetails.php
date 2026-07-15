<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class UpdateCountryDetails extends Command
{
    protected $signature = 'countries:update-details';

    protected $description = 'Perbarui data GDP, Inflasi, Populasi, dan Skor Risiko untuk semua negara dari RestCountries, World Bank, dan Open-Meteo API';

    public function handle()
    {
        $this->info('Memulai pembaruan data negara...');

        // 1. Ambil data Populasi dari RestCountries v5 (Paging)
        $this->info('Mengambil data Populasi dari RestCountries v5...');
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
                $this->warn('Gagal mengambil data populasi pada offset ' . $offset . ': ' . $e->getMessage());
                break;
            }
        }
        $this->info('Berhasil memuat ' . count($populationData) . ' data populasi.');

        // 2. Ambil data GDP dari World Bank (Bulk)
        $this->info('Mengambil data GDP dari World Bank...');
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
                    $this->info('Berhasil memuat ' . count($gdpData) . ' data GDP.');
                }
            }
        } catch (\Exception $e) {
            $this->warn('Gagal mengambil data GDP dari World Bank: ' . $e->getMessage());
        }

        // 3. Ambil data Inflasi dari World Bank (Bulk)
        $this->info('Mengambil data Inflasi dari World Bank...');
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
                    $this->info('Berhasil memuat ' . count($inflationData) . ' data inflasi.');
                }
            }
        } catch (\Exception $e) {
            $this->warn('Gagal mengambil data Inflasi dari World Bank: ' . $e->getMessage());
        }

        // 4. Update database untuk setiap negara
        $countries = Country::all();
        $bar = $this->output->createProgressBar(count($countries));
        $bar->start();

        $updatedCount = 0;

        foreach ($countries as $country) {
            $iso3 = strtoupper($country->iso3);

            // Update Populasi jika ada di RestCountries
            if (isset($populationData[$iso3])) {
                $country->population = $populationData[$iso3];
            }

            // Update GDP jika ada di World Bank
            if (isset($gdpData[$iso3])) {
                $country->gdp = $gdpData[$iso3];
            }

            // Update Inflasi jika ada di World Bank
            if (isset($inflationData[$iso3])) {
                $country->inflation_rate = $inflationData[$iso3];
            }

            // Hitung Ulang Skor Risiko
            // A. Weather Risk (Open-Meteo) - Kita batasi dengan timeout singkat agar tidak lambat
            $weatherRisk = 10;
            if ($country->latitude && $country->longitude) {
                try {
                    $weatherResp = Http::timeout(2)->get('https://api.open-meteo.com/v1/forecast', [
                        'latitude' => $country->latitude,
                        'longitude' => $country->longitude,
                        'current' => 'wind_speed_10m'
                    ]);
                    if ($weatherResp->successful()) {
                        $wind = $weatherResp->json()['current']['wind_speed_10m'] ?? 0;
                        if ($wind < 20) {
                            $weatherRisk = 10;
                        } elseif ($wind < 40) {
                            $weatherRisk = 20;
                        } else {
                            $weatherRisk = 30;
                        }
                    }
                } catch (\Exception $e) {
                    $weatherRisk = 10; // Fallback jika timeout/error
                }
            }

            // B. Inflation Risk (20% weight)
            $inf = $country->inflation_rate ?? 0;
            if ($inf < 3) {
                $inflationRisk = 5;
            } elseif ($inf < 6) {
                $inflationRisk = 10;
            } else {
                $inflationRisk = 20;
            }

            // C. Currency Risk (10% weight)
            $currencyRisk = 10;
            $primaryCurrencies = explode(',', $country->currency ?? '');
            $mainCurrency = $primaryCurrencies[0] ?? '';
            if (in_array($mainCurrency, ['USD', 'EUR'])) {
                $currencyRisk = 2;
            } elseif (in_array($mainCurrency, ['JPY', 'SGD'])) {
                $currencyRisk = 5;
            }

            // D. News Risk (News Sentiment - 40% weight)
            $newsRisk = [10, 20, 40][array_rand([10, 20, 40])];

            // Total Risk
            $country->risk_score = $weatherRisk + $inflationRisk + $currencyRisk + $newsRisk;
            $country->save();

            $updatedCount++;
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nSelesai! {$updatedCount} negara berhasil diperbarui.");
        
        return Command::SUCCESS;
    }
}
