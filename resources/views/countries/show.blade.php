@extends('layouts.master')

@section('content')
@php
if (!function_exists('format_gdp_id')) {
    function format_gdp_id($value) {
        if (!$value) return '-';
        if ($value >= 1e12) {
            return '$ ' . number_format($value / 1e12, 2, ',', '.') . ' T (Triliun)';
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
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        
        <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Detail Negara</h4>
            <span class="badge bg-light text-primary fw-semibold fs-6">Profil Wilayah</span>
        </div>
        
        <div class="card-body p-4">
            <div class="row align-items-center mb-4">
                <div class="col-md-3 text-center text-md-start mb-3 mb-md-0">
                    <div class="display-1 text-dark p-3 bg-light rounded-3 d-inline-block shadow-sm" style="line-height: 1;">
                        {{ $country->flag }}
                    </div>
                </div>
                <div class="col-md-9 text-center text-md-start">
                    <h1 class="fw-bold mb-1">{{ $country->name }}</h1>
                    <p class="text-muted mb-0 fs-5">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $country->region }} &bull; {{ $country->subregion }}
                    </p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle border-top">
                    <tbody>
                        <tr>
                            <th class="text-muted fw-semibold py-3" style="width: 25%;">Nama Negara</th>
                            <td class="fw-bold py-3 text-dark">{{ $country->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-semibold py-3">Ibu Kota</th>
                            <td class="py-3">{{ $country->capital }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-semibold py-3">Wilayah (Region)</th>
                            <td class="py-3">{{ $country->region }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-semibold py-3">Sub-Wilayah</th>
                            <td class="py-3">{{ $country->subregion }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-semibold py-3">Mata Uang</th>
                            <td class="py-3"><span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6 rounded-pill">{{ $country->currency }}</span></td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-semibold py-3">Total Populasi</th>
                            <td class="py-3 fw-medium">
                                <i class="bi bi-people-fill text-secondary me-1"></i> {{ number_format($country->population, 0, ',', '.') }} Jiwa
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-semibold py-3">PDB (GDP)</th>
                            <td class="py-3 fw-medium text-dark">
                                {{ format_gdp_id($country->gdp) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-semibold py-3">Tingkat Inflasi</th>
                            <td class="py-3">
                                {{ $country->inflation_rate ? number_format($country->inflation_rate, 2, ',', '.') . '%' : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-semibold py-3">Skor Risiko</th>
                            <td class="py-3">
                                @php
                                    $score = $country->risk_score ?? 0;
                                    if ($score <= 30) {
                                        $riskStatus = 'Rendah';
                                        $riskClass = 'bg-success bg-opacity-10 text-success border border-success-subtle';
                                    } elseif ($score <= 60) {
                                        $riskStatus = 'Sedang';
                                        $riskClass = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle';
                                    } else {
                                        $riskStatus = 'Tinggi';
                                        $riskClass = 'bg-danger bg-opacity-10 text-danger border border-danger-subtle';
                                    }
                                @endphp
                                <span class="badge {{ $riskClass }} px-3 py-2 fs-6 rounded-pill fw-bold">
                                    {{ $score }} ({{ $riskStatus }})
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('countries.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>
            
        </div>
    </div>
</div>
@endsection