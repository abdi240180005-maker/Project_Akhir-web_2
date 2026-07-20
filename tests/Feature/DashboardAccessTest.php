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
    ]);
});

test('admin can access user monitoring page', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/dashboard');

    $response->assertOk();
});

test('user is redirected from admin dashboard to user dashboard with error', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/admin');

    $response->assertRedirect(route('dashboard'));
    $response->assertSessionHas('error', 'Anda tidak memiliki hak akses.');
});

test('admin can access admin dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/admin');

    $response->assertOk();
});

test('user can access user dashboard', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/dashboard');

    $response->assertOk();
});
