@extends('layouts.master')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">

                ✏️ Edit Artikel

            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.articles.update', $article) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">

                        Judul Artikel

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $article->title) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Kategori

                    </label>

                    <input
                        type="text"
                        name="category"
                        class="form-control"
                        value="{{ old('category', $article->category) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Penulis

                    </label>

                    <input
                        type="text"
                        name="author"
                        class="form-control"
                        value="{{ old('author', $article->author) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Isi Artikel

                    </label>

                    <textarea
                        name="content"
                        rows="8"
                        class="form-control"
                        required>{{ old('content', $article->content) }}</textarea>

                </div>

                <button class="btn btn-primary">

                    Simpan Perubahan

                </button>

                <a href="{{ route('admin.articles.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection