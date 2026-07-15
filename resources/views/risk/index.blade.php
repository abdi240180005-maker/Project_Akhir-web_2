@extends('layouts.master')

@push('styles')
<style>
    /* Desain Palet Warna Kontemporer */
    .text-slate-400 { color: #94a3b8; }
    .text-slate-500 { color: #64748b; }
    .text-slate-800 { color: #0f172a; }
    .bg-slate-50 { background-color: #f8fafc; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .border-slate-100 { border-color: #f1f5f9; }
    
    .card-custom {
        border: 1px solid #f1f5f9 !important;
        border-radius: 1.25rem !important;
        background: #ffffff;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    
    .card-custom:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -10px rgba(15, 23, 42, 0.08) !important;
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Memperbaiki seleksi teks */
    ::-moz-selection { background-color: #3b82f6 !important; color: #ffffff !important; }
    ::selection { background-color: #3b82f6 !important; color: #ffffff !important; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4 bg-slate-50" style="min-height: 100vh;">

    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 mb-4 pb-3 border-bottom border-slate-100">
        <div>
            <h4 class="fw-bold text-slate-800 mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-shield-exclamation text-primary"></i> Analisis Risiko Rantai Pasokan
            </h4>
            <p class="text-slate-500 small mb-0">
                Pemantauan metrik volatilitas operasional berdasarkan cuaca, inflasi, valas, dan sentimen berita global.
            </p>
        </div>
    </div>

    <div class="card card-custom shadow-sm mb-4 border-0">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('risk.index') }}">
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-slate-50 border-0 text-slate-500 ps-3">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <select name="country" class="form-select border-0 bg-slate-50 text-slate-800 py-2.5 fw-medium">
                                @foreach($countries as $c)
                                    <option value="{{ $c->id }}" {{ $country && $country->id == $c->id ? 'selected' : '' }}>
                                        {{ $c->flag }} &nbsp; {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold shadow-sm">
                            <i class="bi bi-cpu me-1"></i> Hitung Risiko
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card card-custom shadow-sm h-100 border-0 p-3">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-slate-500 fw-semibold small text-uppercase tracking-wider d-block mb-1">Risiko Cuaca (30%)</span>
                        <h3 class="fw-bold text-slate-800 mb-0 font-monospace">{{ $weatherRisk }}</h3>
                        <small class="text-slate-400 d-block mt-1">Maksimum: 30</small>
                    </div>
                    <div class="icon-box bg-info bg-opacity-10 text-info">
                        🌤
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card card-custom shadow-sm h-100 border-0 p-3">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-slate-500 fw-semibold small text-uppercase tracking-wider d-block mb-1">Risiko Inflasi (20%)</span>
                        <h3 class="fw-bold text-slate-800 mb-0 font-monospace">{{ $inflationRisk }}</h3>
                        <small class="text-slate-400 d-block mt-1">Maksimum: 20</small>
                    </div>
                    <div class="icon-box bg-danger bg-opacity-10 text-danger">
                        📈
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card card-custom shadow-sm h-100 border-0 p-3">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-slate-500 fw-semibold small text-uppercase tracking-wider d-block mb-1">Risiko Valas (10%)</span>
                        <h3 class="fw-bold text-slate-800 mb-0 font-monospace">{{ $currencyRisk }}</h3>
                        <small class="text-slate-400 d-block mt-1">Maksimum: 10</small>
                    </div>
                    <div class="icon-box bg-warning bg-opacity-10 text-warning">
                        💱
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card card-custom shadow-sm h-100 border-0 p-3">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-slate-500 fw-semibold small text-uppercase tracking-wider d-block mb-1">Risiko Berita (40%)</span>
                        <h3 class="fw-bold text-slate-800 mb-0 font-monospace">{{ $newsRisk }}</h3>
                        @php
                            $sentimentBadge = 'bg-secondary';
                            if ($sentimentResult === 'Positive') {
                                $sentimentBadge = 'bg-success';
                            } elseif ($sentimentResult === 'Negative') {
                                $sentimentBadge = 'bg-danger';
                            }
                        @endphp
                        <small class="text-slate-500 d-block mt-1">
                            Sentimen: <span class="badge {{ $sentimentBadge }} bg-opacity-10 text-{{ str_replace('bg-', '', $sentimentBadge) }} font-monospace px-1.5 py-0.5" style="font-size: 0.72rem;">{{ $sentimentResult }}</span>
                        </small>
                    </div>
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        📰
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-custom shadow-sm border-0 h-100 d-flex flex-column justify-content-center p-4 text-center">
                <div class="py-3">
                    <span class="text-slate-500 fw-bold small text-uppercase tracking-widest d-block mb-3">Akumulasi Skor</span>
                    
                    <div class="d-inline-flex align-items-center justify-content-center bg-{{ $color }} bg-opacity-10 rounded-circle mb-3" style="width: 130px; height: 130px;">
                        <h1 class="display-4 fw-black text-{{ $color }} mb-0 font-monospace" style="letter-spacing: -2px;">
                            {{ $totalRisk }}
                        </h1>
                    </div>
                    
                    <h5 class="fw-bold text-slate-800 mb-2">Status Keamanan</h5>
                    <span class="badge bg-{{ $color }} px-3 py-2 rounded-pill fs-6 fw-semibold shadow-sm text-uppercase tracking-wider">
                        {{ $status }}
                    </span>
                </div>
                <div class="mt-3 pt-3 border-top border-slate-100 bg-light bg-opacity-50 p-3 rounded-3 text-start">
                    <p class="small text-slate-500 mb-0">
                        <i class="bi bi-info-circle me-1"></i> <strong>Distribusi Bobot Risiko:</strong>
                        <ul class="small text-slate-500 mb-0 ps-3 mt-1">
                            <li>Cuaca (Bobot 30%) - Skor: {{ $weatherRisk }}/30</li>
                            <li>Volatilitas Inflasi (Bobot 20%) - Skor: {{ $inflationRisk }}/20</li>
                            <li>Fluktuasi Valas (Bobot 10%) - Skor: {{ $currencyRisk }}/10</li>
                            <li>Sentimen Berita (Bobot 40%) - Skor: {{ $newsRisk }}/40</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-custom shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-slate-800 fs-6">
                        <i class="bi bi-app-indicator text-muted me-2"></i>Pemetaan Vektor Risiko
                    </span>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="riskChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('riskChart');
    if (!ctx) return;

    // Deteksi warna dinamis dari status backend untuk diterapkan ke grafik
    const statusColorMap = {
        'success': '#198754',
        'warning': '#ffc107',
        'danger': '#dc3545',
        'primary': '#0d6efd'
    };
    const activeColor = statusColorMap['{{ $color }}'] || '#3b82f6';

    // Menggunakan grafik tipe RADAR agar analisis multi-faktor terlihat jauh lebih elegan & profesional
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Faktor Cuaca', 'Volatilitas Inflasi', 'Fluktuasi Valas', 'Eksposur Berita'],
            datasets: [{
                label: 'Skor Indeks Risiko',
                data: [
                    {{ $weatherRisk ?? 0 }},
                    {{ $inflationRisk ?? 0 }},
                    {{ $currencyRisk ?? 0 }},
                    {{ $newsRisk ?? 0 }}
                ],
                backgroundColor: activeColor + '18', // Warna fill transparan mengikuti status risiko
                borderColor: activeColor,
                borderWidth: 2.5,
                pointBackgroundColor: activeColor,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                r: {
                    angleLines: { color: '#f1f5f9' },
                    grid: { color: '#e2e8f0' },
                    pointLabels: {
                        color: '#64748b',
                        font: { size: 12, weight: '600' }
                    },
                    ticks: {
                        backdropColor: 'transparent',
                        color: '#94a3b8',
                        font: { size: 10 },
                        stepSize: 25
                    },
                    suggestedMin: 0,
                    suggestedMax: 100
                }
            }
        }
    });
});
</script>
@endpush