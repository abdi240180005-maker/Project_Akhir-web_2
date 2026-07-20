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

        $countries = Country::where(function ($query) {
                $query->where('un_member', true)
                      ->orWhere('independent', true);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        $allCountriesList = Country::where(function ($query) {
                $query->where('un_member', true)
                      ->orWhere('independent', true);
            })
            ->orderBy('name')
            ->get(['name', 'iso2']);

        return view('countries.index', [
            'countries' => $countries,
            'allCountriesList' => $allCountriesList,
            'totalCountries' => Country::where(function ($query) {
                $query->where('un_member', true)
                      ->orWhere('independent', true);
            })->count(),
            'asiaCountries' => Country::where(function ($query) {
                $query->where('un_member', true)
                      ->orWhere('independent', true);
            })->where('region', 'Asia')->count(),
            'europeCountries' => Country::where(function ($query) {
                $query->where('un_member', true)
                      ->orWhere('independent', true);
            })->where('region', 'Europe')->count(),
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
            'Negara sudah ada di Daftar Negara Favorit.'
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
        'Negara berhasil ditambahkan ke Daftar Negara Favorit.'
    );
}
}