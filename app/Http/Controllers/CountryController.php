<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\MonitoredCountry;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $countries = Country::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('countries.index', [
            'countries' => $countries,
            'totalCountries' => Country::count(),
            'asiaCountries' => Country::where('region', 'Asia')->count(),
            'europeCountries' => Country::where('region', 'Europe')->count(),
        ]);
    }
    public function show(Country $country)
{
    return view('countries.show', compact('country'));
}
public function monitor(Country $country)
{
    // Cek apakah sudah dimonitor
    $exists = MonitoredCountry::where(
        'country_code',
        $country->iso2
    )->exists();

    if ($exists) {
        return back()->with(
            'warning',
            'Negara sudah ada di Watchlist.'
        );
    }

    MonitoredCountry::create([
        'country_name' => $country->name,
        'country_code' => $country->iso2,
        'capital'      => $country->capital,
        'region'       => $country->region,
        'population'   => $country->population,
        'currency'     => $country->currency,
        'flag'         => $country->flag,
    ]);

    return back()->with(
        'success',
        'Negara berhasil ditambahkan ke Watchlist.'
    );
}
}