@extends('layouts.master')

@push('styles')
<style>
    /* Utility warna kustom agar tampilan terlihat premium & clean */
    .text-slate-500 { color: #64748b; }
    .text-slate-800 { color: #0f172a; }
    .bg-slate-50 { background-color: #f8fafc; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .border-slate-100 { border-color: #f1f5f9; }
    
    /* Efek hover melayang halus pada kartu statistik */
    .transition-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04) !important;
    }

    /* Efek hover baris tabel yang lembut */
    .table-hover tbody tr {
        transition: background-color 0.15s ease;
    }
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }
</style>
@endpush

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

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center py-3 px-4 mb-4">
    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning border-0 shadow-sm rounded-3 d-flex align-items-center py-3 px-4 mb-4">
    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
    <div>{{ session('warning') }}</div>
</div>
@endif

<div class="container-fluid px-4 py-4 bg-slate-50" style="min-height: 100vh;">

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1">🌍 Negara</h3>
            <p class="text-slate-500 small mb-0">
                Monitoring data negara di seluruh dunia
            </p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-slate-500 text-uppercase fw-bold tracking-wider d-block mb-1" style="font-size: 0.75rem;">
                            Total Negara
                        </small>
                        <h2 class="fw-bold text-primary mb-0">
                            {{ $totalCountries }}
                        </h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-globe2 fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-slate-500 text-uppercase fw-bold tracking-wider d-block mb-1" style="font-size: 0.75rem;">
                            Negara Asia
                        </small>
                        <h2 class="fw-bold text-success mb-0">
                            {{ $asiaCountries }}
                        </h2>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-geo-alt-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-slate-500 text-uppercase fw-bold tracking-wider d-block mb-1" style="font-size: 0.75rem;">
                            Negara Eropa
                        </small>
                        <h2 class="fw-bold text-warning mb-0">
                            {{ $europeCountries }}
                        </h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-flag-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET">
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 text-muted ps-3">
                                <i class="bi bi-search"></i>
                            </span>
                            <select
                                name="search"
                                class="form-select border-0 bg-white text-slate-800"
                                onchange="this.form.submit()"
                                style="outline: none; box-shadow: none;">
                                <option value="">-- Semua Negara --</option>
                                @foreach($allCountriesList as $item)
                                    <option value="{{ $item->name }}" {{ request('search') == $item->name ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100 fw-semibold shadow-sm">
                            Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Negara --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-slate-800 border-bottom">
                    <tr>
                        <th class="ps-4 py-3 small text-uppercase fw-bold" style="width: 8%;">Bendera</th>
                        <th class="py-3 small text-uppercase fw-bold" style="width: 17%;">Negara</th>
                        <th class="py-3 small text-uppercase fw-bold text-end" style="width: 16%;">PDB (GDP)</th>
                        <th class="py-3 small text-uppercase fw-bold text-end" style="width: 11%;">Inflasi</th>
                        <th class="py-3 small text-uppercase fw-bold text-end" style="width: 14%;">Populasi</th>
                        <th class="py-3 small text-uppercase fw-bold text-center" style="width: 12%;">Mata Uang</th>
                        <th class="py-3 small text-uppercase fw-bold text-center" style="width: 12%;">Skor Risiko</th>
                        <th class="text-end pe-4 py-3 small text-uppercase fw-bold text-slate-800" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($countries as $country)
                    <tr>
                        <td class="ps-4 py-3 border-slate-100">
                            <img
                                src="https://flagcdn.com/32x24/{{ strtolower($country->iso2) }}.png"
                                alt="{{ $country->name }}"
                                class="rounded shadow-sm border border-light"
                                style="width: 32px; height: auto; display: block; object-fit: cover;">
                        </td>

                        <td class="py-3 border-slate-100">
                            <span class="fw-bold text-slate-800">{{ $country->name }}</span>
                            <small class="d-block text-muted" style="font-size: 0.75rem;">Capital: {{ $country->capital ?? '-' }}</small>
                        </td>

                        <td class="py-3 border-slate-100 text-end fw-medium text-dark">
                            {{ format_gdp_id($country->gdp) }}
                        </td>

                        <td class="py-3 border-slate-100 text-end text-slate-600">
                            {{ $country->inflation_rate ? number_format($country->inflation_rate, 2, ',', '.') . '%' : '-' }}
                        </td>

                        <td class="py-3 border-slate-100 text-end text-slate-600">
                            {{ number_format($country->population, 0, ',', '.') }}
                        </td>

                        <td class="py-3 border-slate-100 text-center">
                            @if($country->currency)
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    @foreach(explode(',', $country->currency) as $curr)
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary font-monospace px-2 py-1 rounded-1" style="font-size: 0.72rem;">{{ $curr }}</span>
                                    @endforeach
                                </div>
                            @else
                                -
                            @endif
                        </td>

                        <td class="py-3 border-slate-100 text-center">
                            @php
                                $score = $country->risk_score ?? 0;
                                if ($score <= 30) {
                                    $riskStatus = 'Rendah';
                                    $riskClass = 'bg-success bg-opacity-10 text-success';
                                } elseif ($score <= 60) {
                                    $riskStatus = 'Sedang';
                                    $riskClass = 'bg-warning bg-opacity-10 text-warning-emphasis';
                                } else {
                                    $riskStatus = 'Tinggi';
                                    $riskClass = 'bg-danger bg-opacity-10 text-danger';
                                }
                            @endphp
                            <span class="badge {{ $riskClass }} px-2.5 py-1.5 rounded-2 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                <span class="d-inline-block rounded-circle" style="width: 6px; height: 6px; background-color: currentColor;"></span>
                                {{ $score }} ({{ $riskStatus }})
                            </span>
                        </td>

                        <td class="text-end pe-4 py-3 border-slate-100">
                            <div class="d-inline-flex gap-1">
                                <a
                                    href="{{ route('countries.show', $country) }}"
                                    class="btn btn-light btn-sm fw-medium text-slate-800 border d-inline-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px;"
                                    title="Detail">
                                    <i class="bi bi-eye text-slate-500"></i>
                                </a>

                                <form
                                    action="{{ route('countries.monitor', $country) }}"
                                    method="POST"
                                    class="d-inline m-0">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-warning btn-sm fw-medium d-inline-flex align-items-center justify-content-center text-white"
                                        style="width: 32px; height: 32px; background-color: #ffc107; border-color: #ffc107;"
                                        title="Tambah ke Favorit">
                                        <i class="bi bi-star-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-exclamation-circle d-block fs-3 mb-2 text-slate-500"></i>
                            Tidak ada data negara.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-top border-slate-100 py-3 px-4 d-flex justify-content-center">
            {{ $countries->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection