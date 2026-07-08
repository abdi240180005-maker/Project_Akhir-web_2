<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\EconomyController;
use App\Http\Controllers\NewsController;

Route::get('/news', [NewsController::class, 'index'])
    ->name('news.index');
Route::get('/economy', [EconomyController::class, 'index'])
    ->name('economy.index');
Route::get('/currency', [CurrencyController::class, 'index'])
    ->name('currency.index');

Route::get('/weather', [WeatherController::class, 'index'])
    ->name('weather.index');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
// Countries
Route::get('/countries', [CountryController::class, 'index'])
    ->name('countries.index');

Route::get('/countries/{country}', [CountryController::class, 'show'])
    ->name('countries.show');
    Route::post('/countries/{country}/monitor',
    [CountryController::class,'monitor'])
    ->name('countries.monitor');
Route::post(
    '/countries/{country}/monitor',
    [CountryController::class, 'monitor']
)->name('countries.monitor');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Countries
    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

});

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__.'/auth.php';