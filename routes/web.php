<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EconomyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Semua User (Harus Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Negara
    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

    Route::get('/countries/{country}', [CountryController::class, 'show'])
        ->name('countries.show');

    Route::post('/countries/{country}/monitor', [CountryController::class, 'monitor'])
        ->name('countries.monitor');

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

    // Perbandingan Negara
    Route::get('/comparison', [ComparisonController::class, 'index'])
        ->name('comparison.index');

    // Daftar Pantau
    Route::get('/watchlist', [WatchlistController::class, 'index'])
        ->name('watchlist.index');

    Route::delete('/watchlist/{watchlist}', [WatchlistController::class, 'destroy'])
        ->name('watchlist.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

});

require __DIR__.'/auth.php';
Route::resource(
    'admin/users',
    UserManagementController::class
)->names('admin.users');
Route::resource(
    'admin/articles',
    ArticleController::class
)->names('admin.articles');