<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    private function getRegion($countryCode) {
        $country = strtoupper($countryCode);
        $asia = ['ID', 'MY', 'SG', 'TH', 'VN', 'PH', 'CN', 'JP', 'KR', 'IN', 'PK', 'BD', 'IR', 'IQ', 'SA', 'AE', 'QA', 'LK', 'MM', 'KH', 'LA'];
        $europe = ['GB', 'DE', 'FR', 'IT', 'ES', 'NL', 'BE', 'CH', 'SE', 'NO', 'FI', 'DK', 'PL', 'UA', 'RU', 'TR', 'GR', 'IE', 'PT', 'AT'];
        $africa = ['ZA', 'EG', 'NG', 'KE', 'MA', 'DZ', 'AO', 'GH', 'ET', 'TZ', 'UG', 'SD', 'EH', 'LY', 'TN', 'CI', 'SN', 'CM', 'MZ'];
        $americas = ['US', 'CA', 'MX', 'BR', 'AR', 'CO', 'PE', 'CL', 'VE', 'EC', 'GT', 'CU', 'PR', 'PA', 'CR', 'JM'];
        if (in_array($country, $asia)) return 'Asia';
        if (in_array($country, $europe)) return 'Europe';
        if (in_array($country, $africa)) return 'Africa';
        if (in_array($country, $americas)) return 'Americas';
        return 'Oceania';
    }

    public function userIndex(Request $request)
    {
        $query = Port::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('port_name', 'like', '%' . $request->search . '%')
                  ->orWhere('country', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Fetch all matching ports to calculate overall statistics and map items
        $allPorts = $query->orderBy('country')->orderBy('port_name')->get();

        $totalPorts = 0;
        $lowCount = 0;
        $mediumCount = 0;
        $highCount = 0;

        foreach ($allPorts as $port) {
            $delay = abs(crc32($port->port_name) % 36);
            $port->delay_hours = $delay;
            $port->wpi_code = "WPI-" . (10000 + ($port->id % 90000));
            $port->region = $this->getRegion($port->country);
            
            if ($delay < 10) {
                $port->congestion = 'Rendah';
                $lowCount++;
            } elseif ($delay < 24) {
                $port->congestion = 'Sedang';
                $mediumCount++;
            } else {
                $port->congestion = 'Tinggi';
                $highCount++;
            }
            $totalPorts++;
        }

        // Get paginated ports for the list panel
        $ports = $query->orderBy('country')->orderBy('port_name')->paginate(50);
        foreach ($ports as $port) {
            $delay = abs(crc32($port->port_name) % 36);
            $port->delay_hours = $delay;
            $port->wpi_code = "WPI-" . (10000 + ($port->id % 90000));
            $port->region = $this->getRegion($port->country);
            
            if ($delay < 10) {
                $port->congestion = 'Rendah';
            } elseif ($delay < 24) {
                $port->congestion = 'Sedang';
            } else {
                $port->congestion = 'Tinggi';
            }
        }

        // Fetch all unique countries for the filter dropdown
        $countries = Port::select('country')
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        return view(
            'ports.index',
            compact(
                'ports',
                'allPorts',
                'countries',
                'totalPorts',
                'lowCount',
                'mediumCount',
                'highCount'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $ports = Port::latest()->get();

        return view(
            'admin.ports.index',
            compact('ports')
        );
    }

    public function create()
    {
        return view('admin.ports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'port_name' => 'required',
            'country' => 'required',
            'city' => 'nullable',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Port::create([
            'port_name' => $request->port_name,
            'country' => $request->country,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('admin.ports.index')
            ->with('success', 'Pelabuhan berhasil ditambahkan.');
    }

    public function edit(Port $port)
    {
        return view(
            'admin.ports.edit',
            compact('port')
        );
    }

    public function update(Request $request, Port $port)
    {
        $request->validate([
            'port_name' => 'required',
            'country' => 'required',
            'city' => 'nullable',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $port->update([
            'port_name' => $request->port_name,
            'country' => $request->country,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('admin.ports.index')
            ->with('success', 'Pelabuhan berhasil diperbarui.');
    }

    public function destroy(Port $port)
    {
        $port->delete();

        return redirect()
            ->route('admin.ports.index')
            ->with('success', 'Pelabuhan berhasil dihapus.');
    }
    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt',
    ]);

    $file = fopen($request->file('file')->getRealPath(), 'r');

    $header = fgetcsv($file);

    while (($row = fgetcsv($file, 0, ",")) !== false) {

        $data = array_combine($header, $row);

        if (empty($data['Main Port Name'])) {
            continue;
        }

        Port::firstOrCreate(
            [
                'port_name' => $data['Main Port Name'],
            ],
            [
                'country' => $data['Country Code'] ?? '',
                'city' => null,
                'latitude' => $data['Latitude'] ?? 0,
                'longitude' => $data['Longitude'] ?? 0,
            ]
        );
    }

    fclose($file);

    return redirect()
        ->route('admin.ports.index')
        ->with('success', 'World Port Index berhasil diimport.');
}
}