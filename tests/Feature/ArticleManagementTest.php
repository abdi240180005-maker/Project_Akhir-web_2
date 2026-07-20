<?php

use App\Models\User;
use App\Models\Article;
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

test('admin can view all articles in admin page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $article = Article::create([
        'title' => 'Analisis Krisis Rantai Pasok',
        'country' => 'Indonesia',
        'risk_level' => 'Sedang',
        'conclusion' => 'Kesimpulan dari analisis supply chain.',
        'category' => 'Analysis',
        'author' => 'Admin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get('/admin/articles');

    $response->assertOk();
    $response->assertSee('Analisis Krisis Rantai Pasok');
});

test('admin can add an article and it appears in user risk page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);
    $country = Country::first();

    $response = $this
        ->actingAs($admin)
        ->post('/admin/articles', [
            'title' => 'Ancaman Risiko Pelabuhan Priok',
            'country' => 'Indonesia',
            'risk_level' => 'Tinggi',
            'conclusion' => 'Kesimpulan ancaman jalur laut priok.',
        ]);

    $response->assertRedirect(route('admin.articles.index'));
    $this->assertDatabaseHas('articles', ['title' => 'Ancaman Risiko Pelabuhan Priok']);

    // Check user risk dashboard
    $responseUser = $this
        ->actingAs($user)
        ->get(route('risk.index', ['country' => $country->id]));

    $responseUser->assertOk();
    $responseUser->assertSee('Ancaman Risiko Pelabuhan Priok');
});

test('admin can update an article and it updates in user risk view', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);
    $country = Country::first();

    $article = Article::create([
        'title' => 'Old Title Article',
        'country' => 'Indonesia',
        'risk_level' => 'Rendah',
        'conclusion' => 'Kesimpulan lama.',
        'category' => 'Analysis',
        'author' => 'Admin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->put(route('admin.articles.update', $article), [
            'title' => 'New Title Article',
            'country' => 'Indonesia',
            'risk_level' => 'Sedang',
            'conclusion' => 'Kesimpulan baru.',
        ]);

    $response->assertRedirect(route('admin.articles.index'));
    $this->assertDatabaseHas('articles', ['title' => 'New Title Article']);
    $this->assertDatabaseMissing('articles', ['title' => 'Old Title Article']);

    // Check user view
    $responseUser = $this
        ->actingAs($user)
        ->get(route('risk.index', ['country' => $country->id]));

    $responseUser->assertOk();
    $responseUser->assertSee('New Title Article');
});

test('admin can delete an article and it disappears from user risk view', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);
    $country = Country::first();

    $article = Article::create([
        'title' => 'Deleted Article Title',
        'country' => 'Indonesia',
        'risk_level' => 'Sedang',
        'conclusion' => 'Kesimpulan hapus.',
        'category' => 'Analysis',
        'author' => 'Admin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->delete(route('admin.articles.destroy', $article));

    $response->assertRedirect(route('admin.articles.index'));
    $this->assertDatabaseMissing('articles', ['title' => 'Deleted Article Title']);

    // Check user view
    $responseUser = $this
        ->actingAs($user)
        ->get(route('risk.index', ['country' => $country->id]));

    $responseUser->assertOk();
    $responseUser->assertDontSee('Deleted Article Title');
});
