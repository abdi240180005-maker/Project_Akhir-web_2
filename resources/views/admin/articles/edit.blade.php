@extends('layouts.master')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                📋 Edit Analisis
            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.articles.update', $article) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Judul Analisis
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
                        Negara
                    </label>

                    <input
                        type="text"
                        name="country"
                        class="form-control"
                        value="{{ old('country', $article->country) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Tingkat Risiko
                    </label>

                    <select
                        name="risk_level"
                        class="form-select"
                        required>

                        <option value="Rendah" {{ $article->risk_level == 'Rendah' ? 'selected' : '' }}>
                            Rendah
                        </option>

                        <option value="Sedang" {{ $article->risk_level == 'Sedang' ? 'selected' : '' }}>
                            Sedang
                        </option>

                        <option value="Tinggi" {{ $article->risk_level == 'Tinggi' ? 'selected' : '' }}>
                            Tinggi
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Kesimpulan
                    </label>

                    <textarea
                        name="conclusion"
                        rows="6"
                        class="form-control"
                        required>{{ old('conclusion', $article->conclusion) }}</textarea>

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