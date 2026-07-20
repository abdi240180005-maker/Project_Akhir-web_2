<?php

use App\Models\User;
use App\Models\Port;

test('admin can view all ports in admin port page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $port = Port::create([
        'port_name' => 'Tanjung Priok',
        'country' => 'ID',
        'city' => 'Jakarta',
        'latitude' => -6.1,
        'longitude' => 106.9,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/admin/ports');

    $response->assertOk();
    $response->assertSee('Tanjung Priok');
});

test('admin can add a port and it appears in user port dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);

    $response = $this
        ->actingAs($admin)
        ->post('/admin/ports', [
            'port_name' => 'Tanjung Perak',
            'country' => 'ID',
            'city' => 'Surabaya',
            'latitude' => -7.2,
            'longitude' => 112.7,
        ]);

    $response->assertRedirect(route('admin.ports.index'));
    $this->assertDatabaseHas('ports', ['port_name' => 'Tanjung Perak']);

    // Check user port dashboard
    $responseUser = $this
        ->actingAs($user)
        ->get('/ports');

    $responseUser->assertOk();
    $responseUser->assertSee('Tanjung Perak');
});

test('admin can update a port and it updates in database and user view', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);
    $port = Port::create([
        'port_name' => 'Old Port Name',
        'country' => 'ID',
        'city' => 'Old City',
        'latitude' => 1.0,
        'longitude' => 2.0,
    ]);

    $response = $this
        ->actingAs($admin)
        ->put(route('admin.ports.update', $port), [
            'port_name' => 'New Port Name',
            'country' => 'ID',
            'city' => 'New City',
            'latitude' => 3.0,
            'longitude' => 4.0,
        ]);

    $response->assertRedirect(route('admin.ports.index'));
    $this->assertDatabaseHas('ports', ['port_name' => 'New Port Name']);
    $this->assertDatabaseMissing('ports', ['port_name' => 'Old Port Name']);

    // Check user view
    $responseUser = $this
        ->actingAs($user)
        ->get('/ports');

    $responseUser->assertOk();
    $responseUser->assertSee('New Port Name');
});

test('admin can delete a port and it disappears from user view', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);
    $port = Port::create([
        'port_name' => 'Deleted Port',
        'country' => 'ID',
        'city' => 'Some City',
        'latitude' => 1.0,
        'longitude' => 2.0,
    ]);

    $response = $this
        ->actingAs($admin)
        ->delete(route('admin.ports.destroy', $port));

    $response->assertRedirect(route('admin.ports.index'));
    $this->assertDatabaseMissing('ports', ['port_name' => 'Deleted Port']);

    // Check user view
    $responseUser = $this
        ->actingAs($user)
        ->get('/ports');

    $responseUser->assertOk();
    $responseUser->assertDontSee('Deleted Port');
});
