@extends('layouts.master')

@section('content')
<div class="container-fluid px-4 py-4" style="background-color: #f8fafc; min-height: 100vh;">

    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-light">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-cloud-sun text-primary"></i> Weather Monitoring
            </h3>
            <p class="text-muted small mb-0">
                Real-time weather data and global environmental tracking around the world.
            </p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('weather.index') }}">
                <div class="row g-3 align-items-center">
                    <div class="col-md-9 col-lg-10">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted px-3">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <select class="form-select border-start-0 bg-light py-2.5" name="country" style="font-size: 0.95rem;">
                                <option value="" disabled {{ !$country ? 'selected' : '' }}>Pilih negara untuk memantau cuaca...</option>
                                @foreach($countries as $c)
                                <option value="{{ $c->id }}" {{ $country && $country->id == $c->id ? 'selected' : '' }}>
                                    {{ $c->flag }} &nbsp; {{ $c->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <button class="btn btn-primary w-100 py-2.5 fw-semibold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-search"></i> Cari Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($country && !empty($weather))
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Temperature</small>
                        <h2 class="fw-bold text-primary mb-0">
                            {{ $weather['current']['temperature_2m'] }}°C
                        </h2>
                    </div>
                    <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 1.5rem;">
                        🌡️
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Humidity</small>
                        <h2 class="fw-bold text-slate-800 mb-0">
                            {{ $weather['current']['relative_humidity_2m'] }}%
                        </h2>
                    </div>
                    <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 1.5rem;">
                        💧
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1">Wind Speed</small>
                        <h2 class="fw-bold text-slate-800 mb-0">
                            {{ $weather['current']['wind_speed_10m'] }} <span class="fs-6 fw-normal text-muted">km/h</span>
                        </h2>
                    </div>
                    <div class="icon-shape bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 1.5rem;">
                        🌬️
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-dark text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div style="font-size: 2.8rem; line-height: 1;">
                        {{ $country->flag }}
                    </div>
                    <div class="overflow-hidden">
                        <h5 class="fw-bold text-truncate mb-0" style="font-size: 1.05rem;">
                            {{ $country['name']['common'] ?? $country->name }}
                        </h5>
                        <small class="text-light-muted text-truncate d-block mt-0.5" style="font-size: 0.8rem; color: #94a3b8;">
                            Capital: {{ is_array($country['capital']) ? ($country['capital'][0] ?? '-') : ($country->capital ?? '-') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <span class="fw-bold text-slate-800"><i class="bi bi-map text-muted me-2"></i>Location Map Geotarget</span>
                </div>
                <div class="card-body p-0 position-relative">
                    <div id="weatherMap" style="height: 420px; z-index: 1;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-slate-800"><i class="bi bi-calendar3 text-muted me-2"></i>7 Days Forecast</span>
                </div>
                <div class="card-body p-0" style="max-height: 420px; overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted sticky-top bg-white border-bottom" style="z-index: 10;">
                                <tr>
                                    <th class="ps-4 py-3 border-0 small tracking-wider text-uppercase fw-bold">Date</th>
                                    <th class="py-3 border-0 small tracking-wider text-uppercase fw-bold text-center">Max Temp</th>
                                    <th class="pe-4 py-3 border-0 small tracking-wider text-uppercase fw-bold text-center">Min Temp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($weather['daily']['time'] as $i => $date)
                                <tr>
                                    <td class="ps-4 py-3 border-light fw-medium text-slate-700 font-monospace" style="font-size: 0.85rem;">
                                        {{ $date }}
                                    </td>
                                    <td class="py-3 text-center border-light">
                                        <span class="badge px-2.5 py-1.5 rounded-2 fw-semibold" style="background-color: #fef2f2; color: #ef4444; font-size: 0.8rem;">
                                            {{ $weather['daily']['temperature_2m_max'][$i] }}°C
                                        </span>
                                    </td>
                                    <td class="pe-4 text-center border-light">
                                        <span class="badge px-2.5 py-1.5 rounded-2 fw-semibold" style="background-color: #eff6ff; color: #3b82f6; font-size: 0.8rem;">
                                            {{ $weather['daily']['temperature_2m_min'][$i] }}°C
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
window.addEventListener('load', function () {
    @if($country)
    const map = L.map('weatherMap', {
        zoomControl: true,
        scrollWheelZoom: false // Mencegah peta ter-zoom otomatis saat men-scroll halaman utama
    }).setView([{{ $country->latitude }}, {{ $country->longitude }}], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    const marker = L.marker([{{ $country->latitude }}, {{ $country->longitude }}]).addTo(map);

    // Desain ulang popup agar kontras dan terbaca dengan jelas
    marker.bindPopup(`
        <div style="font-family: system-ui, -apple-system, sans-serif; padding: 4px; text-align: left; min-width: 160px;">
            <div style="font-size: 1.4rem; margin-bottom: 4px;">{{ $country->flag }}</div>
            <h6 style="margin: 0 0 8px 0; font-weight: 700; color: #1e293b;">{{ $country->name }}</h6>
            <div style="font-size: 0.78rem; color: #475569; line-height: 1.5;">
                <p style="margin: 2px 0;">🔴 <b>Temp:</b> {{ $weather['current']['temperature_2m'] }} °C</p>
                <p style="margin: 2px 0;">🔵 <b>Humidity:</b> {{ $weather['current']['relative_humidity_2m'] }} %</p>
                <p style="margin: 2px 0;">🟢 <b>Wind:</b> {{ $weather['current']['wind_speed_10m'] }} km/h</p>
            </div>
        </div>
    `).openPopup();

    setTimeout(function() {
        map.invalidateSize();
    }, 300);
    @endif
});
</script>
@endpush

<style>
    .text-slate-800 { color: #1e293b; }
    .text-slate-700 { color: #334155; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Modifikasi Input Focus Bootstrap */
    .form-select:focus {
        border-color: #cbd5e1 !important;
        box-shadow: none !important;
    }

    /* Efek Translasi & Animasi Hover Ringan */
    .transition-hover {
        transition: transform 0.22s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.22s ease;
    }
    .transition-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03) !important;
    }

    /* Kustomisasi scrollbar internal 7 Days Forecast */
    .card-body::-webkit-scrollbar {
        width: 5px;
    }
    .card-body::-webkit-scrollbar-track {
        background: transparent;
    }
    .card-body::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .card-body::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>