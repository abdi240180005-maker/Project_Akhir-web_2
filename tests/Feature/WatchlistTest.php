<?php

use App\Models\User;
use App\Models\Country;
use App\Models\MonitoredCountry;
use Illuminate\Support\Facades\Http;

test('user can view watchlist page even when http api fails', function () {
    $user = User::factory()->create(['role' => 'user']);
    
    $country = Country::create([
        'name' => 'Indonesia',
        'iso2' => 'ID',
        'iso3' => 'IDN',
        'capital' => 'Jakarta',
        'currency' => 'IDR',
        'un_member' => true,
        'independent' => true,
        'latitude' => -6.2,
        'longitude' => 106.8,
    ]);

    MonitoredCountry::create([
        'country_code' => 'ID',
        'country_name' => 'Indonesia',
    ]);

    // Force Http to throw ConnectionException / return error
    Http::fake([
        'https://api.open-meteo.com/*' => Http::response([], 500),
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/watchlist');

    $response->assertOk();
    $response->assertSee('Indonesia');
    // It should fallback to default weather (Cerah, 28.5)
    $response->assertSee('Cerah');
});

test('user can view watchlist page when api is successful', function () {
    $user = User::factory()->create(['role' => 'user']);
    
    $country = Country::create([
        'name' => 'Japan',
        'iso2' => 'JP',
        'iso3' => 'JPN',
        'capital' => 'Tokyo',
        'currency' => 'JPY',
        'un_member' => true,
        'independent' => true,
        'latitude' => 35.6,
        'longitude' => 139.6,
    ]);

    MonitoredCountry::create([
        'country_code' => 'JP',
        'country_name' => 'Japan',
    ]);

    // Fake weather API response
    Http::fake([
        'https://api.open-meteo.com/*' => Http::response([
            'current' => [
                'temperature_2m' => 18.5,
                'weather_code' => 3, // Berawan
            ]
        ], 200),
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/watchlist');

    $response->assertOk();
    $response->assertSee('Japan');
    $response->assertSee('Berawan');
});
