<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();

        return view(
            'admin.articles.index',
            compact('articles')
        );
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'country' => 'required',
            'risk_level' => 'required',
            'conclusion' => 'required',
        ]);

        Article::create([
            'title' => $request->title,
            'country' => $request->country,
            'risk_level' => $request->risk_level,
            'conclusion' => $request->conclusion,
            'category' => 'Analysis',
            'author' => 'Admin',
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Analisis berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        return view(
            'admin.articles.edit',
            compact('article')
        );
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'country' => 'required',
            'risk_level' => 'required',
            'conclusion' => 'required',
        ]);

        $article->update([
            'title' => $request->title,
            'country' => $request->country,
            'risk_level' => $request->risk_level,
            'conclusion' => $request->conclusion,
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Analisis berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Analisis berhasil dihapus.');
    }
}