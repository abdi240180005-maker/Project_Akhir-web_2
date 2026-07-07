<?php

namespace App\Http\Controllers;

use App\Models\Country;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCountries = Country::count();

        return view('dashboard.index',[
            'totalCountries'=>$totalCountries
        ]);
    }
}