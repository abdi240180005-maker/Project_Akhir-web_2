<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

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
}