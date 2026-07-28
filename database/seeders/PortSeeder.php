<?php

namespace Database\Seeders;

use App\Models\Port;
use Illuminate\Database\Seeder;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = base_path('updatedpub150.csv');

        if (!file_exists($csvPath)) {
            $this->command->error("File updatedpub150.csv tidak ditemukan di " . $csvPath);
            return;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file);

        if (!$header) {
            return;
        }

        if (Port::count() > 0) {
            $this->command->info("Data pelabuhan sudah ada di database (" . Port::count() . " data). Melompati seeding.");
            return;
        }

        $portsData = [];
        $count = 0;

        while (($row = fgetcsv($file, 0, ",")) !== false) {
            if (count($row) !== count($header)) {
                continue;
            }

            $data = array_combine($header, $row);

            $portName = trim($data['Main Port Name'] ?? '');
            if (empty($portName)) {
                continue;
            }

            $portsData[] = [
                'port_name'  => $portName,
                'country'    => trim($data['Country Code'] ?? ''),
                'city'       => null,
                'latitude'   => is_numeric($data['Latitude'] ?? null) ? (float)$data['Latitude'] : 0,
                'longitude'  => is_numeric($data['Longitude'] ?? null) ? (float)$data['Longitude'] : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $count++;

            if (count($portsData) >= 500) {
                Port::insertOrIgnore($portsData);
                $portsData = [];
            }
        }

        if (!empty($portsData)) {
            Port::insertOrIgnore($portsData);
        }

        fclose($file);

        $this->command->info("Berhasil mengimpor {$count} data pelabuhan.");
    }
}
