@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <span>🌍</span> Intelijen Risiko Rantai Pasokan Global
            </h2>
            <p class="text-muted mb-0">
                Selamat datang kembali, <strong class="text-dark">{{ Auth::user()->name }}</strong>
            </p>
        </div>
        <div>
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-3 py-2 fs-6 rounded-3 fw-semibold">
                📅 {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Negara Terpantau</small>
                        <h2 class="fw-extrabold text-dark mb-1">
                            {{ $totalCountries }}
                        </h2>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 small fw-medium">Basis Data</span>
                    </div>
                    <div class="icon-circle bg-primary bg-opacity-10 text-primary fs-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-globe2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Suhu Cuaca</small>
                        <h2 class="fw-extrabold text-dark mb-1">
                            {{ $weather['current']['temperature_2m'] ?? '--' }}°C
                        </h2>
                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-0.5 small fw-medium">Langsung</span>
                    </div>
                    <div class="icon-circle bg-warning bg-opacity-10 text-warning fs-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-cloud-sun-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Kurs USD → IDR</small>
                        <h2 class="fw-extrabold text-dark mb-1">
                            {{ number_format($currency['rates']['IDR'] ?? 0, 0, ',', '.') }}
                        </h2>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 small fw-medium">Nilai Tukar</span>
                    </div>
                    <div class="icon-circle bg-success bg-opacity-10 text-success fs-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-currency-exchange"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Total Berita</small>
                        <h2 class="fw-extrabold text-dark mb-1">
                            {{ count($articles ?? []) }}
                        </h2>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-0.5 small fw-medium">Diperbarui</span>
                    </div>
                    <div class="icon-circle bg-danger bg-opacity-10 text-danger fs-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark">
                    🗺️ Peta Pemantauan Global
                </div>
                <div class="card-body p-0">
                    <div id="worldMap" style="height: 650px; z-index: 1;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 d-flex flex-column gap-4">
            <div class="card shadow-sm border-0 rounded-4 w-100">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark">
                    🌦️ Pemantauan Kondisi Cuaca
                </div>
                <div class="card-body text-center p-4">
                    <i class="bi bi-cloud-sun-fill text-warning" style="font-size: 70px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));"></i>
                    <h3 class="fw-bold mt-3 text-dark">Indonesia</h3>
                    <h1 class="fw-extrabold text-primary my-2 fs-1">
                        {{ $weather['current']['temperature_2m'] ?? '--' }}°C
                    </h1>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill small fw-medium mb-3">Waktu Nyata</span>
                    <hr class="text-muted opacity-25">
                    <div class="row pt-2">
                        <div class="col border-end border-light">
                            <strong class="fs-5 text-dark">
                                {{ $weather['current']['relative_humidity_2m'] ?? '--' }}%
                            </strong>
                            <div class="text-muted small mt-1">Kelembapan</div>
                        </div>
                        <div class="col">
                            <strong class="fs-5 text-dark">
                                {{ $weather['current']['wind_speed_10m'] ?? '--' }}
                            </strong>
                            <div class="text-muted small mt-1">Kecepatan Angin (km/j)</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 flex-grow-1 overflow-hidden">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark">
                    📰 Berita Sekilas Terkini
                </div>
                <div class="card-body p-4 style-scroll" style="max-height: px; overflow-y: auto;">
                    @forelse($articles as $article)
                    <div class="mb-3 pb-3 border-bottom border-light last-no-border">
                        <span class="badge bg-light text-dark border font-monospace fw-bold px-2 py-0.5 mb-1" style="font-size: 0.7rem;">
                            {{ $article['source']['name'] ?? '-' }}
                        </span>
                        <p class="mb-0 text-dark font-medium lh-sm" style="font-size: 0.85rem;">
                            {{ \Illuminate\Support\Str::limit($article['title'], 70) }}
                        </p>
                    </div>
                    @empty
                    <p class="text-muted small text-center my-4">
                        Tidak Ada Berita Tersedia
                    </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex justify-content-between align-items-center">
                    <span>💱 Grafik Nilai Tukar Mata Uang</span>
                    <a href="{{ route('currency.index') }}" class="btn btn-sm btn-outline-primary rounded-3 px-3 fw-bold">
                        Detail Lengkap
                    </a>
                </div>
                <div class="card-body p-4">
                    <div style="height: 350px; position: relative;">
                        <canvas id="currencyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark">
                    ⚠️ Ringkasan Indeks Risiko
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-secondary fw-medium">Risiko Cuaca</span>
                            <span class="badge bg-success border border-success-subtle rounded-pill px-3 py-1 text-uppercase font-monospace fw-bold small">Rendah</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-secondary fw-medium">Fluktuasi Kurs</span>
                            <span class="badge bg-warning text-dark border border-warning-subtle rounded-pill px-3 py-1 text-uppercase font-monospace fw-bold small">Sedang</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-secondary fw-medium">Kondisi Ekonomi</span>
                            <span class="badge bg-danger border border-danger-subtle rounded-pill px-3 py-1 text-uppercase font-monospace fw-bold small">Tinggi</span>
                        </div>
                    </div>
                    
                    <hr class="text-muted opacity-25 my-3">
                    
                    <div class="text-center bg-light p-3 rounded-3 border">
                        <h6 class="fw-bold text-secondary mb-2 text-uppercase tracking-wider" style="font-size: 0.75rem;">Total Tingkat Risiko Keseluruhan</h6>
                        <span class="badge bg-warning text-dark border border-warning-subtle fs-6 px-4 py-2 rounded-3 fw-bold">
                            SEDANG
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // =======================
    // LEAFLET MAP
    // =======================
    const map = L.map('worldMap').setView([20, 0], 2);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const countries = [
        { name: 'Indonesia', lat: -6.2088, lng: 106.8456 },
        { name: 'Jepang', lat: 35.6762, lng: 139.6503 },
        { name: 'Singapura', lat: 1.3521, lng: 103.8198 },
        { name: 'Jerman', lat: 52.5200, lng: 13.4050 }
    ];

    countries.forEach(country => {
        L.marker([country.lat, country.lng])
            .addTo(map)
            .bindPopup("<b>" + country.name + "</b>");
    });

    // =======================
    // CHART.JS
    // =======================
    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary') || '#0d6efd';

    new Chart(document.getElementById('currencyChart'), {
        type: 'bar',
        data: {
            labels: ['USD', 'IDR', 'EUR', 'JPY', 'SGD'],
            datasets: [{
                label: 'Nilai Tukar',
                data: [
                    {{ $currency['rates']['USD'] ?? 0 }},
                    {{ $currency['rates']['IDR'] ?? 0 }},
                    {{ $currency['rates']['EUR'] ?? 0 }},
                    {{ $currency['rates']['JPY'] ?? 0 }},
                    {{ $currency['rates']['SGD'] ?? 0 }}
                ],
                backgroundColor: primaryColor + '1a', // Warna semi transparan
                borderColor: primaryColor,
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush