<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use App\Models\Article;
use App\Models\Port;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $totalCountries = Country::count();

        $totalArticles = Article::count();

        $totalPorts = Port::count();

        $latestUsers = User::latest()->take(3)->get();
        $latestPorts = Port::latest()->take(3)->get();
        $latestArticles = Article::latest()->take(3)->get();

        $activities = collect();

        foreach ($latestUsers as $user) {
            $activities->push([
                'type' => 'user',
                'title' => 'User baru terdaftar',
                'description' => "{$user->name} ({$user->email})",
                'time' => $user->created_at,
                'icon' => 'bi-person-plus-fill',
                'color' => 'primary'
            ]);
        }

        foreach ($latestPorts as $port) {
            $activities->push([
                'type' => 'port',
                'title' => 'Dataset Pelabuhan ditambahkan',
                'description' => "{$port->port_name} ({$port->country})",
                'time' => $port->created_at,
                'icon' => 'bi-anchor',
                'color' => 'warning'
            ]);
        }

        foreach ($latestArticles as $article) {
            $activities->push([
                'type' => 'article',
                'title' => 'Artikel Analisis diterbitkan',
                'description' => "{$article->title} ({$article->country})",
                'time' => $article->created_at,
                'icon' => 'bi-newspaper',
                'color' => 'success'
            ]);
        }

        $activities = $activities->sortByDesc('time')->take(5);

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'totalCountries',
                'totalArticles',
                'totalPorts',
                'activities'
            )
        );
    }
}