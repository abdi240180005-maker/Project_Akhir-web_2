@extends('layouts.master')

@section('content')
<div class="container py-4">

    <div class="mb-4 pb-2 border-bottom">
        <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <span>📰</span> Pemantauan Berita Global
        </h2>
        <p class="text-muted mb-0">
            Berita Terkini Mengenai Rantai Pasokan, Logistik & Ekonomi Dunia
        </p>
    </div>

    @if(count($articles))
    
    <div class="row g-4">
        @foreach($articles as $article)
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative bg-white transition-all card-hover">
                
                @if(!empty($article['image']))
                <div class="position-relative" style="height: 240px; overflow: hidden;">
                    <img src="{{ $article['image'] }}"
                         class="w-100 h-100"
                         style="object-fit: cover;"
                         alt="{{ $article['title'] }}">
                    <span class="position-absolute top-0 start-0 m-3 badge bg-dark bg-opacity-75 backdrop-blur px-2 py-2 rounded-2 small fw-bold">
                        📺 {{ $article['source']['name'] }}
                    </span>
                </div>
                @endif

                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        @if(empty($article['image']))
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 small fw-bold mb-2">
                            {{ $article['source']['name'] }}
                        </span>
                        @endif

                        <h5 class="fw-bold text-dark mb-2 lh-base title-limit text-hover-primary">
                            {{ $article['title'] }}
                        </h5>

                        <p class="text-muted small mb-3">
                            {{ \Illuminate\Support\Str::limit($article['description'] ?? 'Tidak ada deskripsi tambahan untuk berita ini.', 140) }}
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-2 text-secondary pt-2 border-top border-light" style="font-size: 0.8rem;">
                        <i class="bi bi-clock"></i>
                        <span>
                            {{ date('d M Y, H:i', strtotime($article['publishedAt'])) }} WIB
                        </span>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <a href="{{ $article['url'] }}"
                       target="_blank"
                       class="btn btn-outline-primary rounded-3 w-100 fw-bold d-flex align-items-center justify-content-center gap-2 py-2">
                        <span>Baca Selengkapnya</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    @else

    <div class="alert alert-warning border-0 shadow-sm rounded-3 p-4 d-flex align-items-center gap-3">
        <span class="fs-3">⚠️</span>
        <div>
            <h6 class="fw-bold mb-1 text-warning-emphasis">Berita Tidak Ditemukan</h6>
            <p class="text-muted small mb-0">Saat ini tidak ada berita terbaru yang dapat dimuat. Silakan coba segarkan halaman beberapa saat lagi.</p>
        </div>
    </div>

    @endif

</div>

<style>
    .card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .backdrop-blur {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
    .title-limit {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection