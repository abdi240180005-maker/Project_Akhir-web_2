<?php

namespace App\Http\Controllers;

use App\Models\MonitoredCountry;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = MonitoredCountry::orderBy('country_name')
            ->paginate(10);

        return view(
            'watchlist.index',
            compact('watchlists')
        );
    }

    public function destroy(MonitoredCountry $watchlist)
    {
        $watchlist->delete();

        return redirect()
            ->route('watchlist.index')
            ->with(
                'success',
                'Negara berhasil dihapus dari Daftar Pantau.'
            );
    }
}