<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EconomyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\VisualisasiController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\WeatherController;

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

    // Visualisasi Data Statistik
    Route::get('/visualisasi', [VisualisasiController::class, 'index'])
        ->name('visualisasi.index');

    // Daftar Pantau
    Route::get('/watchlist', [WatchlistController::class, 'index'])
        ->name('watchlist.index');

    Route::delete('/watchlist/{watchlist}', [WatchlistController::class, 'destroy'])
        ->name('watchlist.destroy');

    // Pelabuhan
    Route::get('/ports', [PortController::class, 'userIndex'])
        ->name('ports.index');

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

    Route::resource('admin/users', UserManagementController::class)
        ->names('admin.users');

    Route::resource('admin/articles', ArticleController::class)
        ->names('admin.articles');

    Route::resource('admin/ports', PortController::class)
        ->names('admin.ports');

    Route::post(
        'admin/ports/import',
        [PortController::class, 'import']
    )->name('admin.ports.import');
});

/*
|--------------------------------------------------------------------------
| ROUTE SEMENTARA MEMBUAT ADMIN
|--------------------------------------------------------------------------
| Setelah berhasil membuat admin dan bisa login,
| HAPUS route ini lalu git push lagi.
|--------------------------------------------------------------------------
*/

Route::get('/create-admin', function () {

    User::updateOrCreate(
        ['email' => 'admin@gmail.com'],
        [
            'name' => 'Administrator',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]
    );

    return '✅ Admin berhasil dibuat!<br><br>Email: admin@gmail.com<br>Password: admin123';
});

Route::get('/run-seed', function () {
    try {
        // Set higher execution time limit for seeding
        set_time_limit(300);

        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);

        // Auto-seed ports if the table is empty
        if (\App\Models\Port::count() === 0) {
            $csvPath = base_path('updatedpub150.csv');
            if (file_exists($csvPath)) {
                $file = fopen($csvPath, 'r');
                $header = fgetcsv($file);
                $insertData = [];
                $now = now();
                
                while (($row = fgetcsv($file, 0, ",")) !== false) {
                    if (count($row) !== count($header)) {
                        continue;
                    }
                    $data = array_combine($header, $row);
                    if (empty($data['Main Port Name'])) {
                        continue;
                    }
                    
                    $insertData[] = [
                        'port_name' => $data['Main Port Name'],
                        'country' => $data['Country Code'] ?? '',
                        'city' => null,
                        'latitude' => $data['Latitude'] ?? 0,
                        'longitude' => $data['Longitude'] ?? 0,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    
                    if (count($insertData) >= 500) {
                        \App\Models\Port::insert($insertData);
                        $insertData = [];
                    }
                }
                
                if (!empty($insertData)) {
                    \App\Models\Port::insert($insertData);
                }
                
                fclose($file);
            }
        }

        return '✅ Database berhasil dimigrasi, di-seed, dan data pelabuhan berhasil di-import!';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

require __DIR__.'/auth.php';