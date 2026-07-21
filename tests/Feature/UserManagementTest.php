<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('admin can view user management page', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this
        ->actingAs($admin)
        ->get(route('admin.users.index'));

    $response->assertOk();
});

test('non-admin user cannot access user management page', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this
        ->actingAs($user)
        ->get(route('admin.users.index'));

    $response->assertRedirect(route('dashboard'));
});

test('admin can update user info without changing password', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'role' => 'user',
        'password' => Hash::make('oldpassword123'),
    ]);

    $response = $this
        ->actingAs($admin)
        ->put(route('admin.users.update', $user), [
            'name' => 'John Updated',
            'email' => 'john.updated@example.com',
            'role' => 'admin',
            'password' => '', // blank password should not change it
        ]);

    $response->assertRedirect(route('admin.users.index'));
    
    $user->refresh();
    expect($user->name)->toBe('John Updated');
    expect($user->email)->toBe('john.updated@example.com');
    expect($user->role)->toBe('admin');
    expect(Hash::check('oldpassword123', $user->password))->toBeTrue();
});

test('admin can update user info with a new password', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'role' => 'user',
        'password' => Hash::make('oldpassword123'),
    ]);

    $response = $this
        ->actingAs($admin)
        ->put(route('admin.users.update', $user), [
            'name' => 'Jane Updated',
            'email' => 'jane@example.com',
            'role' => 'user',
            'password' => 'newsecurepassword', // password is changed
        ]);

    $response->assertRedirect(route('admin.users.index'));
    
    $user->refresh();
    expect($user->name)->toBe('Jane Updated');
    expect(Hash::check('newsecurepassword', $user->password))->toBeTrue();
});

test('password validation applies on update when password is provided but too short', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();

    $response = $this
        ->from(route('admin.users.edit', $user))
        ->actingAs($admin)
        ->put(route('admin.users.update', $user), [
            'name' => 'Jane Updated',
            'email' => 'jane@example.com',
            'role' => 'user',
            'password' => '123', // less than 6 chars
        ]);

    $response->assertRedirect(route('admin.users.edit', $user));
    $response->assertSessionHasErrors(['password']);
});
