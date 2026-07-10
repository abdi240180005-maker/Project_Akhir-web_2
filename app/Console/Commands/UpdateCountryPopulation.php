<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class UpdateCountryPopulation extends Command
{
    protected $signature = 'countries:update-population';

    protected $description = 'Update population semua negara dari Rest Countries API';

    public function handle()
    {
        $this->info('Mengambil data dari RestCountries...');

        $response = Http::get('https://restcountries.com/v3.1/all');

        if (!$response->successful()) {
            $this->error('Gagal mengambil data.');
            return Command::FAILURE;
        }

       dd($response->json());

        foreach ($countries as $item) {

            $iso2 = $item['cca2'] ?? null;
            $population = $item['population'] ?? null;

            if (!$iso2 || !$population) {
                continue;
            }

            $country = Country::where('iso2', trim($iso2))->first();

            if ($country) {

                $country->population = $population;
                $country->save();

                $updated++;

            }
        }

        $this->info("Selesai. {$updated} negara berhasil diperbarui.");

        return Command::SUCCESS;
    }
}