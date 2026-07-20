<?php

use App\Models\User;
use App\Models\Country;

beforeEach(function () {
    Country::create([
        'name' => 'Indonesia',
        'iso2' => 'ID',
        'iso3' => 'IDN',
        'capital' => 'Jakarta',
        'currency' => 'IDR',
        'un_member' => true,
        'independent' => true,
        'latitude' => -6.2,
        'longitude' => 106.8,
        'risk_score' => 45,
        'population' => 273000000,
        'inflation_rate' => 3.5,
    ]);
});

test('guest cannot access visualisasi page', function () {
    $response = $this->get('/visualisasi');
    $response->assertRedirect('/login');
});

test('user can access visualisasi page', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/visualisasi');

    $response->assertOk();
    $response->assertViewIs('visualisasi.index');
    $response->assertViewHasAll([
        'totalCountries',
        'avgGlobalRisk',
        'highRiskCount',
        'totalPorts',
        'riskCounts',
        'topRisk',
        'topPorts',
        'correlationData',
        'globalAverages',
        'countries',
        'countriesJson'
    ]);
});
