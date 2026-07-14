<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $totalCountries = Country::count();

        $totalArticles = 0;

        $totalPorts = 0;

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'totalCountries',
                'totalArticles',
                'totalPorts'
            )
        );
    }
}