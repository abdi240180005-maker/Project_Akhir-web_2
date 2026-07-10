<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\EconomyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\ComparisonController;

Route::get('/comparison', [ComparisonController::class, 'index'])
    ->name('comparison.index');

Route::get('/watchlist', [WatchlistController::class, 'index'])
    ->name('watchlist.index');

Route::delete('/watchlist/{watchlist}', [WatchlistController::class, 'destroy'])
    ->name('watchlist.destroy');

// Halaman Awal
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Negara
Route::middleware(['auth'])->group(function () {

    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

    Route::get('/countries/{country}', [CountryController::class, 'show'])
        ->name('countries.show');

    Route::post('/countries/{country}/monitor', [CountryController::class, 'monitor'])
        ->name('countries.monitor');

});

// Cuaca
Route::get('/weather', [WeatherController::class, 'index'])
    ->name('weather.index');

// Mata Uang
Route::get('/currency', [CurrencyController::class, 'index'])
    ->name('currency.index');

// Ekonomi
Route::get('/economy', [EconomyController::class, 'index'])
    ->name('economy.index');

// Berita
Route::get('/news', [NewsController::class, 'index'])
    ->name('news.index');

// Analisis Risiko
Route::get('/risk', [RiskController::class, 'index'])
    ->name('risk.index');

// Profile
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__.'/auth.php';