@extends('layouts.master')

@push('styles')
<style>
    .text-slate-400 { color: #94a3b8; }
    .text-slate-500 { color: #64748b; }
    .text-slate-800 { color: #0f172a; }
    .bg-slate-50 { background-color: #f8fafc; }
    .border-slate-100 { border-color: #f1f5f9; }
    
    .card-custom {
        border: 1px solid #f1f5f9 !important;
        border-radius: 1.25rem !important;
        background: #ffffff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04) !important;
    }

    .currency-huge-val {
        font-size: 2.25rem;
        font-weight: 800;
        color: #0f172a;
        font-family: monospace;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4 bg-slate-50" style="min-height: 100vh;">

    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 mb-4 pb-3 border-bottom border-slate-100">
        <div>
            <h4 class="fw-bold text-slate-800 mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-currency-exchange text-primary"></i> Pemantauan Mata Uang Global
            </h4>
            <p class="text-slate-500 small mb-0">
                Nilai tukar mata uang waktu nyata terintegrasi dengan data global.
            </p>
        </div>
    </div>

    {{-- Pemilihan Negara --}}
    <div class="card card-custom shadow-sm mb-4 border-0">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('currency.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-slate-50 border-0 text-slate-500 ps-3">
                                🌍
                            </span>
                            <select name="country" class="form-select border-0 bg-slate-50 text-slate-800 py-2.5 fw-medium" onchange="this.form.submit()">
                                @foreach($countries as $c)
                                    <option value="{{ $c->id }}" {{ $selectedCountry && $selectedCountry->id == $c->id ? 'selected' : '' }}>
                                        {{ $c->flag }} &nbsp; {{ $c->name }} ({{ explode(',', $c->currency)[0] ?? 'USD' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold shadow-sm">
                            <i class="bi bi-search me-1"></i> Periksa Kurs
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        {{-- Detail Mata Uang Fokus --}}
        <div class="col-lg-5">
            <div class="card card-custom shadow-sm border-0 h-100 p-4 bg-white d-flex flex-column justify-content-between">
                <div class="text-center text-sm-start">
                    <div class="d-flex align-items-center gap-3 justify-content-center justify-content-sm-start mb-3">
                        <span class="display-3 shadow-sm rounded-circle px-3 py-2 bg-light" style="line-height:1.2;">
                            {{ $selectedCountry->flag }}
                        </span>
                        <div>
                            <h4 class="fw-bold text-dark mb-1">{{ $selectedCountry->name }}</h4>
                            <p class="text-muted mb-0 small">Ibu Kota: <strong class="text-secondary">{{ $selectedCountry->capital ?? '-' }}</strong></p>
                        </div>
                    </div>
                    
                    <hr class="text-muted opacity-25 my-4">

                    <small class="text-slate-500 text-uppercase fw-bold tracking-wider d-block mb-1" style="font-size: 0.75rem;">Mata Uang Resmi</small>
                    <h5 class="fw-bold text-slate-800 mb-3">
                        {{ $selectedCurrency }}
                    </h5>

                    <small class="text-slate-500 text-uppercase fw-bold tracking-wider d-block mb-1" style="font-size: 0.75rem;">Nilai Tukar Terhadap USD</small>
                    <div class="currency-huge-val mb-1">
                        1 USD = {{ number_format($currentRate, $currentRate < 10 ? 4 : 2, ',', '.') }} {{ $selectedCurrency }}
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2.5 py-1.5 rounded-2 font-monospace" style="font-size:0.75rem;">
                        Terakhir Diperbarui: Terkini
                    </span>
                </div>

                <div class="mt-4 pt-3 border-top border-slate-100">
                    <h6 class="fw-bold text-slate-800 mb-3">
                        📌 Kurs Referensi Lainnya (1 USD)
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-start" style="font-size: 0.85rem;">
                            <tbody>
                                @foreach($popularRates as $code => $rate)
                                    @if($code !== $selectedCurrency)
                                        <tr>
                                            <td class="fw-bold text-secondary ps-0">{{ $code }}</td>
                                            <td class="text-end fw-bold text-dark pe-0 font-monospace">
                                                {{ number_format($rate, $rate < 10 ? 4 : 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Perubahan Kurs --}}
        <div class="col-lg-7">
            <div class="card card-custom shadow-sm border-0 overflow-hidden h-100 bg-white">
                <div class="card-header bg-white border-bottom border-slate-100 fw-bold text-slate-800 py-3.5">
                    📈 Grafik Perubahan Kurs {{ $selectedCurrency }} (Tren 7 Hari Terakhir)
                </div>
                <div class="card-body p-4 d-flex align-items-center justify-content-center">
                    <div class="w-100" style="position: relative; height: 380px;">
                        <canvas id="selectedCurrencyChart"></canvas>
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
    const ctx = document.getElementById('selectedCurrencyChart');
    if (!ctx) return;

    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary') || '#0d6efd';

    const chartData = @json($trend);
    const chartLabels = @json($days);

    const canvasContext = ctx.getContext('2d');
    const gradient = canvasContext.createLinearGradient(0, 0, 0, 380);
    gradient.addColorStop(0, primaryColor + '26'); // 15% opacity
    gradient.addColorStop(1, primaryColor + '00'); // 0% opacity

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: '1 USD ke {{ $selectedCurrency }}',
                data: chartData,
                backgroundColor: gradient,
                borderColor: primaryColor,
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: primaryColor,
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
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.dataset.label + ': ' + context.parsed.y.toLocaleString('id-ID', { minimumFractionDigits: 2 });
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false }
                },
                y: {
                    beginAtZero: false,
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
});
</script>
@endpush