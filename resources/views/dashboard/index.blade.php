@extends('layouts.master')

@section('content')
@php
if (!function_exists('format_gdp_id')) {
    function format_gdp_id($value) {
        if (!$value) return '-';
        if ($value >= 1e12) {
            return '$ ' . number_format($value / 1e12, 2, ',', '.') . ' T';
        }
        if ($value >= 1e9) {
            return '$ ' . number_format($value / 1e9, 2, ',', '.') . ' Miliar';
        }
        if ($value >= 1e6) {
            return '$ ' . number_format($value / 1e6, 2, ',', '.') . ' Juta';
        }
        return '$ ' . number_format($value, 0, ',', '.');
    }
}
@endphp
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
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Suhu Cuaca ({{ $selectedCountryObj->iso2 }})</small>
                        <h2 class="fw-extrabold text-dark mb-1">
                            {{ $apiCountryData['weather']['temp'] ?? '--' }}°C
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
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Kurs USD → {{ $selectedCurrencyCode }}</small>
                        <h2 class="fw-extrabold text-dark mb-1">
                            {{ $selectedCurrencyRate ? number_format($selectedCurrencyRate, $selectedCurrencyRate < 10 ? 2 : 0, ',', '.') : '--' }}
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

    {{-- Analisis & Integrasi Data Negara Global (Real-time) --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
            <span class="d-flex align-items-center gap-2">
                <span>🔍</span> Analisis & Integrasi Data Negara Global (Waktu Nyata)
            </span>
            <div style="min-width: 250px;">
                <form method="GET" action="{{ route('dashboard') }}" id="countrySelectForm">
                    <select name="selected_country" class="form-select form-select-sm border bg-light py-2 fw-medium rounded-3" onchange="document.getElementById('countrySelectForm').submit()">
                        @foreach($allCountries as $item)
                            <option value="{{ $item->iso2 }}" {{ $selectedCountryObj->iso2 == $item->iso2 ? 'selected' : '' }}>
                                {{ $item->flag }} &nbsp; {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body p-4 bg-light bg-opacity-10">
            <div class="row g-4">
                {{-- Informasi Umum --}}
                <div class="col-lg-4">
                    <div class="card h-100 border border-light shadow-none rounded-3 p-4 bg-white d-flex flex-column justify-content-between align-items-center text-center">
                        <div>
                            <div class="mb-3">
                                <img
                                    src="{{ $apiCountryData['flag'] }}"
                                    alt="Flag"
                                    class="rounded shadow-sm border border-light"
                                    style="width: 140px; height: auto; object-fit: cover;">
                            </div>
                            <h3 class="fw-bold text-dark mb-1">{{ $apiCountryData['name'] }}</h3>
                            <p class="text-muted small mb-0">Ibu Kota: <strong class="text-secondary">{{ $apiCountryData['capital'] }}</strong></p>
                        </div>
                        
                        <div class="w-100 mt-4 pt-3 border-top border-light">
                            @if($isFavorite)
                                <button class="btn btn-warning w-100 rounded-3 py-2 fw-bold text-white d-flex align-items-center justify-content-center gap-2" disabled>
                                    <i class="bi bi-star-fill"></i> Sudah di Favorit
                                </button>
                            @else
                                <form action="{{ route('countries.monitor', $selectedCountryObj) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-warning w-100 rounded-3 py-2 fw-bold text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #ffc107; border-color: #ffc107;">
                                        <i class="bi bi-star"></i> Tambah ke Favorit
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Data Ekonomi & Populasi --}}
                <div class="col-lg-4">
                    <div class="card h-100 border border-light shadow-none rounded-3 p-4 bg-white">
                        <h6 class="fw-bold text-slate-500 text-uppercase tracking-wider mb-4" style="font-size: 0.75rem;">
                            📊 Data Demografi & Ekonomi (World Bank & Rest Countries)
                        </h6>
                        
                        <div class="mb-3 pb-3 border-bottom border-light">
                            <small class="text-muted d-block mb-1">PDB (GDP Nominal)</small>
                            <strong class="fs-5 text-dark font-monospace">{{ format_gdp_id($apiCountryData['gdp']) }}</strong>
                        </div>
                        
                        <div class="mb-3 pb-3 border-bottom border-light">
                            <small class="text-muted d-block mb-1">Tingkat Inflasi Tahunan</small>
                            <strong class="fs-5 text-dark font-monospace">
                                {{ $apiCountryData['inflation'] !== null ? number_format($apiCountryData['inflation'], 2, ',', '.') . '%' : '-' }}
                            </strong>
                        </div>

                        <div class="mb-3 pb-3 border-bottom border-light">
                            <small class="text-muted d-block mb-1">Jumlah Penduduk (Populasi)</small>
                            <strong class="fs-5 text-dark font-monospace">
                                {{ is_numeric($apiCountryData['population']) ? number_format($apiCountryData['population'], 0, ',', '.') : $apiCountryData['population'] }}
                            </strong>
                        </div>

                        <div class="mb-0">
                            <small class="text-muted d-block mb-1">Mata Uang</small>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary fs-6 px-2.5 py-1.5 rounded font-monospace fw-bold mt-1">
                                {{ $apiCountryData['currency'] }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Data Cuaca Waktu Nyata --}}
                <div class="col-lg-4">
                    <div class="card h-100 border border-light shadow-none rounded-3 p-4 bg-white">
                        <h6 class="fw-bold text-slate-500 text-uppercase tracking-wider mb-4" style="font-size: 0.75rem;">
                            🌦️ Kondisi Cuaca Saat Ini (Open-Meteo)
                        </h6>
                        
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <span style="font-size: 3.5rem; line-height: 1;">{{ $apiCountryData['weather']['icon'] }}</span>
                            <div>
                                <h1 class="fw-extrabold text-primary mb-1 font-monospace">{{ $apiCountryData['weather']['temp'] ?? '--' }}°C</h1>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2.5 py-1 rounded-pill small fw-bold">
                                    {{ $apiCountryData['weather']['condition'] }}
                                </span>
                            </div>
                        </div>

                        <div class="row pt-2 text-center bg-light rounded-3 p-3 border">
                            <div class="col border-end border-light">
                                <strong class="fs-5 text-dark">{{ $apiCountryData['weather']['humidity'] ?? '--' }}%</strong>
                                <div class="text-muted small mt-1" style="font-size: 0.75rem;">Kelembapan</div>
                            </div>
                            <div class="col border-end border-light">
                                <strong class="fs-5 text-dark">{{ $apiCountryData['weather']['wind'] ?? '--' }} km/j</strong>
                                <div class="text-muted small mt-1" style="font-size: 0.75rem;">Angin</div>
                            </div>
                            <div class="col">
                                <strong class="fs-5 text-dark">{{ $apiCountryData['weather']['precipitation'] ?? '0' }} mm</strong>
                                <div class="text-muted small mt-1" style="font-size: 0.75rem;">Curah Hujan</div>
                            </div>
                        </div>
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

        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
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

    {{-- Ringkasan Praktis Kondisi Negara --}}
    <div class="row g-4 mt-2 mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex justify-content-between align-items-center">
                    <span class="d-flex align-items-center gap-2">
                        <span>📋</span> Ringkasan Praktis Kondisi Negara
                    </span>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-3 py-1.5 rounded-pill fs-7 fw-semibold">
                        PDB, Inflasi, Populasi, Mata Uang, & Cuaca
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-slate-800 border-bottom">
                                <tr>
                                    <th class="ps-4 py-3 small text-uppercase fw-bold" style="width: 8%;">Bendera</th>
                                    <th class="py-3 small text-uppercase fw-bold" style="width: 20%;">Negara</th>
                                    <th class="py-3 small text-uppercase fw-bold text-end" style="width: 18%;">PDB (GDP)</th>
                                    <th class="py-3 small text-uppercase fw-bold text-end" style="width: 12%;">Inflasi</th>
                                    <th class="py-3 small text-uppercase fw-bold text-end" style="width: 16%;">Populasi</th>
                                    <th class="py-3 small text-uppercase fw-bold text-center" style="width: 12%;">Mata Uang</th>
                                    <th class="py-3 small text-uppercase fw-bold text-center" style="width: 14%;">Cuaca</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($summaryCountries as $c)
                                <tr>
                                    <td class="ps-4 py-3 border-slate-100">
                                        <img
                                            src="https://flagcdn.com/32x24/{{ strtolower($c['code']) }}.png"
                                            alt="{{ $c['name'] }}"
                                            class="rounded shadow-sm border border-light"
                                            style="width: 32px; height: auto; display: block; object-fit: cover;">
                                    </td>
                                    <td class="py-3 border-slate-100">
                                        <span class="fw-bold text-slate-800">{{ $c['name'] }}</span>
                                    </td>
                                    <td class="py-3 border-slate-100 text-end fw-medium text-dark">
                                        {{ format_gdp_id($c['gdp']) }}
                                    </td>
                                    <td class="py-3 border-slate-100 text-end text-slate-600">
                                        {{ $c['inflation'] ? number_format($c['inflation'], 2, ',', '.') . '%' : '-' }}
                                    </td>
                                    <td class="py-3 border-slate-100 text-end text-slate-600">
                                        {{ number_format($c['population'], 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 border-slate-100 text-center">
                                        @if($c['currency'])
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                @foreach(explode(',', $c['currency']) as $curr)
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary font-monospace px-2 py-1 rounded-1" style="font-size: 0.72rem;">{{ $curr }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-3 border-slate-100 text-center">
                                        @if($c['weather'] !== '--')
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5 rounded-2 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.78rem;">
                                                <i class="bi bi-cloud-sun-fill text-warning"></i>
                                                {{ $c['weather'] }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        Tidak ada data ringkasan negara.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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