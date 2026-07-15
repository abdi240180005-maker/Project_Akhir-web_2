@extends('layouts.master')

@section('content')

<div class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold">
            ⚖️ Perbandingan Negara
        </h2>

        <p class="text-muted">
            Membandingkan kondisi ekonomi dua negara.
        </p>
    </div>

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-5">

                        <label class="form-label fw-bold">

                            Negara Pertama

                        </label>

                        <select
                            name="country1"
                            class="form-select">

                            @foreach($countries as $country)

                            <option
                                value="{{ $country->id }}"
                                {{ $country1 && $country1->id == $country->id ? 'selected' : '' }}>

                                {{ $country->flag }}
                                {{ $country->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-5">

                        <label class="form-label fw-bold">

                            Negara Kedua

                        </label>

                        <select
                            name="country2"
                            class="form-select">

                            @foreach($countries as $country)

                            <option
                                value="{{ $country->id }}"
                                {{ $country2 && $country2->id == $country->id ? 'selected' : '' }}>

                                {{ $country->flag }}
                                {{ $country->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2 d-flex align-items-end">

                        <button
                            class="btn btn-primary w-100">

                            Bandingkan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Hero Cards Profil Negara --}}
    <div class="row g-4 mb-4">
        {{-- Negara 1 --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 border-top border-primary border-4 text-center text-sm-start">
                <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
                    <span class="display-3 shadow-sm rounded-circle px-3 py-2 bg-light">{{ $country1->flag }}</span>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">{{ $country1->name }}</h4>
                        <p class="text-muted mb-0 small">Ibu Kota: <strong class="text-secondary">{{ $data1['capital'] ?? '-' }}</strong></p>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle mt-2 px-2.5 py-1.5 rounded-2">
                            Region: {{ $data1['region'] ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Negara 2 --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 border-top border-success border-4 text-center text-sm-start">
                <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
                    <span class="display-3 shadow-sm rounded-circle px-3 py-2 bg-light">{{ $country2->flag }}</span>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">{{ $country2->name }}</h4>
                        <p class="text-muted mb-0 small">Ibu Kota: <strong class="text-secondary">{{ $data2['capital'] ?? '-' }}</strong></p>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle mt-2 px-2.5 py-1.5 rounded-2">
                            Region: {{ $data2['region'] ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Perbandingan Hasil --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex align-items-center gap-2">
            ⚖️ Hasil Perbandingan Komparatif
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-slate-800 border-bottom">
                    <tr>
                        <th width="30%">Indikator Makro</th>
                        <th class="text-center" width="35%">{{ $country1->name }}</th>
                        <th class="text-center" width="35%">{{ $country2->name }}</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- GDP Row --}}
                    @php
                        $gdp1 = $data1['gdp'] ?? 0;
                        $gdp2 = $data2['gdp'] ?? 0;
                        $gdpWinner1 = $gdp1 > $gdp2;
                        $gdpWinner2 = $gdp2 > $gdp1;
                    @endphp
                    <tr>
                        <td class="fw-semibold ps-4">💰 PDB (Gross Domestic Product)</td>
                        <td class="text-center font-monospace">
                            <span class="d-block fw-bold text-dark">US$ {{ number_format($gdp1,0,',','.') }}</span>
                            @if($gdpWinner1)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-2.5 py-1 mt-1" style="font-size:0.7rem;">
                                    Ekonomi Lebih Besar
                                </span>
                            @endif
                        </td>
                        <td class="text-center font-monospace">
                            <span class="d-block fw-bold text-dark">US$ {{ number_format($gdp2,0,',','.') }}</span>
                            @if($gdpWinner2)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-2.5 py-1 mt-1" style="font-size:0.7rem;">
                                    Ekonomi Lebih Besar
                                </span>
                            @endif
                        </td>
                    </tr>

                    {{-- Inflation Row --}}
                    @php
                        $inf1 = $data1['inflation'] ?? null;
                        $inf2 = $data2['inflation'] ?? null;
                        $infWinner1 = false;
                        $infWinner2 = false;
                        if ($inf1 !== null && $inf2 !== null) {
                            $infWinner1 = $inf1 < $inf2;
                            $infWinner2 = $inf2 < $inf1;
                        }
                    @endphp
                    <tr>
                        <td class="fw-semibold ps-4">📈 Tingkat Inflasi Tahunan</td>
                        <td class="text-center font-monospace">
                            <span class="d-block fw-bold text-dark">{{ $inf1 ? number_format($inf1, 2, ',', '.') . ' %' : '-' }}</span>
                            @if($infWinner1)
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-2.5 py-1 mt-1" style="font-size:0.7rem;">
                                    Lebih Stabil (Rendah)
                                </span>
                            @endif
                        </td>
                        <td class="text-center font-monospace">
                            <span class="d-block fw-bold text-dark">{{ $inf2 ? number_format($inf2, 2, ',', '.') . ' %' : '-' }}</span>
                            @if($infWinner2)
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-2.5 py-1 mt-1" style="font-size:0.7rem;">
                                    Lebih Stabil (Rendah)
                                </span>
                            @endif
                        </td>
                    </tr>

                    {{-- Risk Row --}}
                    @php
                        $score1 = $data1['risk_score'] ?? 0;
                        $score2 = $data2['risk_score'] ?? 0;
                        
                        $riskClass1 = 'bg-secondary';
                        if ($score1 <= 30) $riskClass1 = 'bg-success bg-opacity-10 text-success border border-success-subtle';
                        elseif ($score1 <= 60) $riskClass1 = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle';
                        else $riskClass1 = 'bg-danger bg-opacity-10 text-danger border border-danger-subtle';

                        $riskClass2 = 'bg-secondary';
                        if ($score2 <= 30) $riskClass2 = 'bg-success bg-opacity-10 text-success border border-success-subtle';
                        elseif ($score2 <= 60) $riskClass2 = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle';
                        else $riskClass2 = 'bg-danger bg-opacity-10 text-danger border border-danger-subtle';
                        
                        $riskWinner1 = $score1 < $score2;
                        $riskWinner2 = $score2 < $score1;
                    @endphp
                    <tr>
                        <td class="fw-semibold ps-4">🛡️ Skor & Tingkat Risiko</td>
                        <td class="text-center">
                            <span class="badge {{ $riskClass1 }} px-2.5 py-1.5 rounded-2 fw-bold font-monospace">
                                {{ $score1 }} ({{ $data1['risk_level'] ?? '-' }})
                            </span>
                            @if($riskWinner1)
                                <span class="d-block badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-2 py-0.5 mt-1 mx-auto" style="font-size:0.7rem; max-width: fit-content;">
                                    Risiko Lebih Rendah
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $riskClass2 }} px-2.5 py-1.5 rounded-2 fw-bold font-monospace">
                                {{ $score2 }} ({{ $data2['risk_level'] ?? '-' }})
                            </span>
                            @if($riskWinner2)
                                <span class="d-block badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-2 py-0.5 mt-1 mx-auto" style="font-size:0.7rem; max-width: fit-content;">
                                    Risiko Lebih Rendah
                                </span>
                            @endif
                        </td>
                    </tr>

                    {{-- Weather Row --}}
                    @php
                        $w1 = $data1['weather'] ?? null;
                        $w2 = $data2['weather'] ?? null;
                    @endphp
                    <tr>
                        <td class="fw-semibold ps-4">🌤️ Kondisi Cuaca</td>
                        <td class="text-center">
                            @if($w1)
                                <span class="d-block fw-bold text-dark">{{ $w1['temp'] }}°C ({{ $w1['condition'] }})</span>
                                <span class="text-muted small">Angin: {{ $w1['wind'] }} km/h</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($w2)
                                <span class="d-block fw-bold text-dark">{{ $w2['temp'] }}°C ({{ $w2['condition'] }})</span>
                                <span class="text-muted small">Angin: {{ $w2['wind'] }} km/h</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Currency Row --}}
                    <tr>
                        <td class="fw-semibold ps-4">💵 Mata Uang Resmi</td>
                        <td class="text-center">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2.5 py-1.5 rounded-1 font-monospace">
                                {{ $data1['currency'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2.5 py-1.5 rounded-1 font-monospace">
                                {{ $data2['currency'] }}
                            </span>
                        </td>
                    </tr>

                    {{-- Capital Row --}}
                    <tr>
                        <td class="fw-semibold ps-4">🏛️ Ibu Kota</td>
                        <td class="text-center text-dark fw-medium">{{ $data1['capital'] ?? '-' }}</td>
                        <td class="text-center text-dark fw-medium">{{ $data2['capital'] ?? '-' }}</td>
                    </tr>

                    {{-- Region Row --}}
                    <tr>
                        <td class="fw-semibold ps-4">🌍 Wilayah Geografis</td>
                        <td class="text-center text-secondary small">{{ $data1['region'] ?? '-' }}</td>
                        <td class="text-center text-secondary small">{{ $data2['region'] ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Grafik Perbandingan Ganda --}}
    <div class="row g-4">
        {{-- Grafik GDP --}}
        <div class="col-lg-6">
            <div class="card card-custom shadow-sm border-0 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom border-slate-100 fw-bold text-slate-800 py-3">
                    📊 Grafik Perbandingan GDP (USD)
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="gdpComparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Inflasi --}}
        <div class="col-lg-6">
            <div class="card card-custom shadow-sm border-0 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom border-slate-100 fw-bold text-slate-800 py-3">
                    📈 Grafik Perbandingan Inflasi (%)
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="inflationComparisonChart"></canvas>
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
    // 1. Inisialisasi Grafik Perbandingan GDP
    const ctxGdp = document.getElementById('gdpComparisonChart');
    if (ctxGdp) {
        new Chart(ctxGdp, {
            type: 'bar',
            data: {
                labels: ['{{ $country1->name }}', '{{ $country2->name }}'],
                datasets: [{
                    label: 'GDP (USD)',
                    data: [{{ $gdp1 }}, {{ $gdp2 }}],
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.15)',
                        'rgba(25, 135, 84, 0.15)'
                    ],
                    borderColor: [
                        '#0d6efd',
                        '#198754'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                    barThickness: 60
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

    // 2. Inisialisasi Grafik Perbandingan Inflasi
    const ctxInf = document.getElementById('inflationComparisonChart');
    if (ctxInf) {
        new Chart(ctxInf, {
            type: 'bar',
            data: {
                labels: ['{{ $country1->name }}', '{{ $country2->name }}'],
                datasets: [{
                    label: 'Inflasi (%)',
                    data: [{{ $inf1 ?? 0 }}, {{ $inf2 ?? 0 }}],
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.15)',
                        'rgba(111, 66, 193, 0.15)'
                    ],
                    borderColor: [
                        '#dc3545',
                        '#6f42c1'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                    barThickness: 60
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
});
</script>
@endpush