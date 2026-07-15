@extends('layouts.master')

@section('content')

<div class="container py-4">

    <div class="mb-4 pb-2 border-bottom">
        <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <span>📰</span>
            Pemantauan Berita Global
        </h2>

        <p class="text-muted mb-0">
            Berita terkini mengenai Logistics, Trade, Shipping, dan Economy dunia.
        </p>
    </div>

    {{-- Filter --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <form method="GET" action="{{ route('news.index') }}">

                <div class="row">

                    <div class="col-md-9">

                        <select
                            name="category"
                            class="form-select">

                            @foreach($categories as $key => $value)

                            <option
                                value="{{ $key }}"
                                {{ $category == $key ? 'selected' : '' }}>

                                {{ $value }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3">

                        <button
                            class="btn btn-primary w-100">

                            Cari Berita

                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

    @if(count($articles))

    <div class="row g-4">

        @foreach($articles as $article)

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 card-hover">

                @if(!empty($article['image']))

                <div style="height:240px;overflow:hidden;">

                    <img
                        src="{{ $article['image'] }}"
                        class="w-100 h-100"
                        style="object-fit:cover;">

                </div>

                @endif

                <div class="card-body d-flex flex-column">

                    <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">

                        <span class="badge bg-dark">

                            {{ $article['source']['name'] }}

                        </span>

                        <span class="badge bg-primary">

                            {{ ucfirst($category) }}

                        </span>

                        @if(isset($article['sentiment']))
                            @php
                                $badgeClass = 'bg-secondary';
                                $sentimentLabel = 'Netral';
                                if ($article['sentiment'] === 'Positive') {
                                    $badgeClass = 'bg-success';
                                    $sentimentLabel = 'Positif';
                                } elseif ($article['sentiment'] === 'Negative') {
                                    $badgeClass = 'bg-danger';
                                    $sentimentLabel = 'Negatif';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }} bg-opacity-10 text-{{ str_replace('bg-', '', $badgeClass) }} border border-{{ str_replace('bg-', '', $badgeClass) }}-subtle rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                                Sentimen: {{ $sentimentLabel }}
                            </span>
                        @endif

                    </div>

                    <h5 class="fw-bold">

                        {{ $article['title'] }}

                    </h5>

                    <p class="text-muted">

                        {{ \Illuminate\Support\Str::limit($article['description'] ?? 'Tidak ada deskripsi.',150) }}

                    </p>

                    @if(!empty($article['content']))

                    <p class="small text-secondary">

                        {{ \Illuminate\Support\Str::limit($article['content'],120) }}

                    </p>

                    @endif

                    <div class="mt-auto">

                        <small class="text-muted">

                            📅

                            {{ \Carbon\Carbon::parse($article['publishedAt'])->format('d M Y') }}

                        </small>

                    </div>

                </div>

                <div class="card-footer bg-white border-0">

                    <a
                        href="{{ $article['url'] }}"
                        target="_blank"
                        class="btn btn-outline-primary w-100">

                        Baca Selengkapnya

                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    @else

    <div class="alert alert-warning">

        Tidak ada berita yang ditemukan.

    </div>

    @endif

</div>

<style>

.card-hover{

    transition:.25s;

}

.card-hover:hover{

    transform:translateY(-5px);

    box-shadow:0 .75rem 1.5rem rgba(0,0,0,.15)!important;

}

</style>

@endsection