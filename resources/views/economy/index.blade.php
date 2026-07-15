@extends('layouts.master')

@push('styles')
<style>
    .text-slate-400 { color: #94a3b8; }
    .text-slate-500 { color: #64748b; }
    .text-slate-800 { color: #0f172a; }
    .bg-slate-50 { background-color: #f8fafc; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .border-slate-100 { border-color: #f1f5f9; }
    
    .card-custom {
        border: 1px solid #f1f5f9 !important;
        border-radius: 1rem !important;
        background: #ffffff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05) !important;
    }

    .icon-square {
        width: 44px;
        height: 44px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* SOLUSI TEXT BLOK: Memperbaiki kontras teks saat diseleksi browser */
    ::-moz-selection {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
    }
    ::selection {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4 bg-slate-50" style="min-height: 100vh;">

    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 mb-4 pb-3 border-bottom border-slate-100">
        <div>
            <h4 class="fw-bold text-slate-800 mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-graph-up text-primary"></i> Pemantauan Ekonomi
            </h4>
            <p class="text-slate-500 small mb-0">
                Data indikator ekonomi makro bersumber dari API Bank Dunia.
            </p>
        </div>
    </div>

    <div class="card card-custom shadow-sm mb-4 border-0">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('economy.index') }}">
                <div class="input-group">
                    <span class="input-group-text bg-slate-50 border-0 text-slate-500 ps-3">
                        <i class="bi bi-globe"></i>
                    </span>
                    <select name="country" class="form-select border-0 bg-slate-50 text-slate-800 py-2.5 fw-medium">
                        @foreach($countries as $c)
                        <option value="{{ $c->id }}" {{ $country && $country->id == $c->id ? 'selected' : '' }}>
                            {{ $c->flag }} {{ $c->name }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                        Cari Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($country)
    
    <div class="card card-custom border-0 shadow-sm p-3 mb-4 bg-white">
        <div class="row g-3 text-center text-sm-start align-items-center">
            <div class="col-sm-4 border-sm-end border-slate-100">
                <span class="text-slate-400 small d-block text-uppercase tracking-wider mb-0.5" style="font-size: 0.75rem;">Negara</span>
                <span class="fw-bold text-slate-800">{{ $country->name }}</span>
            </div>
            <div class="col-sm-4 border-sm-end border-slate-100">
                <span class="text-slate-400 small d-block text-uppercase tracking-wider mb-0.5" style="font-size: 0.75rem;">Ibu Kota</span>
                <span class="fw-semibold text-slate-800">{{ $country->capital ?? '-' }}</span>
            </div>
            <div class="col-sm-4">
                <span class="text-slate-400 small d-block text-uppercase tracking-wider mb-0.5" style="font-size: 0.75rem;">Wilayah</span>
                <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5 rounded-2 fw-semibold">
                    {{ $country->region ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-4 mb-4">
        <div class="col">
            <div class="card card-custom shadow-sm h-100 border-0 p-3 bg-white">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-square bg-primary bg-opacity-10 text-primary flex-shrink-0">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                    <div>
                        <small class="text-slate-500 fw-semibold d-block mb-1">PDB (Produk Domestik Bruto)</small>
                        <h4 class="fw-bold text-primary mb-0 font-monospace">
                            US$ {{ number_format($currentGdp ?? 0,0,',','.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-custom shadow-sm h-100 border-0 p-3 bg-white">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-square bg-danger bg-opacity-10 text-danger flex-shrink-0">
                        <i class="bi bi-graph-up-arrow fs-4"></i>
                    </div>
                    <div>
                        <small class="text-slate-500 fw-semibold d-block mb-1">Tingkat Inflasi Tahunan</small>
                        <h4 class="fw-bold text-danger mb-0 font-monospace">
                            {{ $currentInflation ? number_format($currentInflation,2,',','.') : '-' }} %
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-custom shadow-sm h-100 border-0 p-3 bg-white">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-square bg-warning bg-opacity-10 text-warning flex-shrink-0">
                        <i class="bi bi-currency-exchange fs-4"></i>
                    </div>
                    <div>
                        <small class="text-slate-500 fw-semibold d-block mb-1">Mata Uang Resmi</small>
                        <h4 class="fw-bold text-slate-800 mb-0 font-monospace">
                            {{ $country->currency ?? '-' }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- GDP Trend --}}
        <div class="col-lg-6">
            <div class="card card-custom shadow-sm border-0 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom border-slate-100 fw-bold text-slate-800 py-3">
                    📊 Tren Nilai PDB (GDP - 5 Tahun Terakhir)
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="gdpChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inflation Trend --}}
        <div class="col-lg-6">
            <div class="card card-custom shadow-sm border-0 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom border-slate-100 fw-bold text-slate-800 py-3">
                    📈 Tren Tingkat Inflasi (5 Tahun Terakhir)
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="inflationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Currency Trend --}}
        <div class="col-lg-6">
            <div class="card card-custom shadow-sm border-0 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom border-slate-100 fw-bold text-slate-800 py-3">
                    💱 Tren Perubahan Kurs (7 Hari Terakhir terhadap USD)
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="currencyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Risk Trend --}}
        <div class="col-lg-6">
            <div class="card card-custom shadow-sm border-0 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom border-slate-100 fw-bold text-slate-800 py-3">
                    ⚠️ Tren Indeks Risiko Rantai Pasok (7 Hari Terakhir)
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="riskChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($country)
    
    // Inisialisasi Grafik GDP Trend (Line Chart 5 Tahun)
    const ctxGdp = document.getElementById('gdpChart');
    if (ctxGdp) {
        const gradientGdp = ctxGdp.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradientGdp.addColorStop(0, 'rgba(13, 110, 253, 0.15)');
        gradientGdp.addColorStop(1, 'rgba(13, 110, 253, 0.00)');

        new Chart(ctxGdp, {
            type: 'line',
            data: {
                labels: @json($gdpYears),
                datasets: [{
                    label: 'PDB (GDP) USD',
                    data: @json($gdpData),
                    backgroundColor: gradientGdp,
                    borderColor: '#0d6efd',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#0d6efd',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4
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
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1e12) return '$ ' + (value / 1e12).toFixed(1) + ' T';
                                if (value >= 1e9) return '$ ' + (value / 1e9).toFixed(1) + ' Miliar';
                                return '$ ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Inisialisasi Grafik Inflation Trend (Line Chart 5 Tahun)
    const ctxInf = document.getElementById('inflationChart');
    if (ctxInf) {
        const gradientInf = ctxInf.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradientInf.addColorStop(0, 'rgba(220, 53, 69, 0.15)');
        gradientInf.addColorStop(1, 'rgba(220, 53, 69, 0.00)');

        new Chart(ctxInf, {
            type: 'line',
            data: {
                labels: @json($inflationYears),
                datasets: [{
                    label: 'Inflasi (%)',
                    data: @json($inflationData),
                    backgroundColor: gradientInf,
                    borderColor: '#dc3545',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#dc3545',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4
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
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return value.toFixed(1) + ' %';
                            }
                        }
                    }
                }
            }
        });
    }

    // Inisialisasi Grafik Currency Trend (Line Chart 7 Hari)
    const ctxCurr = document.getElementById('currencyChart');
    if (ctxCurr) {
        const gradientCurr = ctxCurr.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradientCurr.addColorStop(0, 'rgba(255, 193, 7, 0.15)');
        gradientCurr.addColorStop(1, 'rgba(255, 193, 7, 0.00)');

        new Chart(ctxCurr, {
            type: 'line',
            data: {
                labels: @json($currencyDays),
                datasets: [{
                    label: '1 USD ke {{ $mainCurrency }}',
                    data: @json($currencyData),
                    backgroundColor: gradientCurr,
                    borderColor: '#ffc107',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#ffc107',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4
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
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }

    // Inisialisasi Grafik Risk Trend (Line Chart 7 Hari)
    const ctxRisk = document.getElementById('riskChart');
    if (ctxRisk) {
        const gradientRisk = ctxRisk.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradientRisk.addColorStop(0, 'rgba(111, 66, 193, 0.15)');
        gradientRisk.addColorStop(1, 'rgba(111, 66, 193, 0.00)');

        new Chart(ctxRisk, {
            type: 'line',
            data: {
                labels: @json($currencyDays), // Menggunakan tanggal 7 hari terakhir yang sama
                datasets: [{
                    label: 'Indeks Risiko',
                    data: @json($riskData),
                    backgroundColor: gradientRisk,
                    borderColor: '#6f42c1',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#6f42c1',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4
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
                        min: 0,
                        max: 100,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return value + ' / 100';
                            }
                        }
                    }
                }
            }
        });
    }
    
    @endif
});
</script>
@endpush