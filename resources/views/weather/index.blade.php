@extends('layouts.master')

@section('content')
<div class="container-fluid px-4 py-4" style="background-color: #f8fafc; min-height: 100vh;">

    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-light">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-cloud-sun text-primary"></i> Pemantauan Cuaca Global
            </h3>
            <p class="text-muted small mb-0">
                Data cuaca real-time dan pelacakan kondisi lingkungan global di seluruh dunia.
            </p>
        </div>
        @if($country)
        <div class="d-flex align-items-center gap-2 bg-white px-3 py-2 rounded-4 shadow-sm border border-light-subtle">
            <span class="fs-3">{{ $country->flag }}</span>
            <div>
                <strong class="text-dark d-block mb-0">{{ $country->name }}</strong>
                <small class="text-muted small">Ibu Kota: {{ is_array($country['capital']) ? ($country['capital'][0] ?? '-') : ($country->capital ?? '-') }}</small>
            </div>
        </div>
        @endif
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4 bg-white rounded-4">
            <form method="GET" action="{{ route('weather.index') }}">
                <div class="row g-3 align-items-center">
                    <div class="col-md-9 col-lg-10">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted px-3" style="border-radius: 0.5rem 0 0 0.5rem;">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <select class="form-select border-start-0 bg-light py-2.5" name="country" style="font-size: 0.95rem; border-radius: 0 0.5rem 0.5rem 0;">
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
                        <button class="btn btn-primary w-100 py-2.5 fw-semibold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="border-radius: 0.5rem !important;">
                            <i class="bi bi-search"></i> Cari Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($country && !empty($weather))
    <div class="row g-4 mb-4">
        {{-- Suhu Udara --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border border-danger-subtle shadow-sm rounded-4 h-100 transition-hover bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.72rem;">Suhu Udara</small>
                        <h2 class="fw-bold text-danger mb-0 font-monospace">
                            {{ $weather['current']['temperature_2m'] }}°C
                        </h2>
                        <small class="text-muted small">Aktif</small>
                    </div>
                    <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        🌡️
                    </div>
                </div>
            </div>
        </div>

        {{-- Kelembapan --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border border-primary-subtle shadow-sm rounded-4 h-100 transition-hover bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.72rem;">Kelembapan</small>
                        <h2 class="fw-bold text-primary mb-0 font-monospace">
                            {{ $weather['current']['relative_humidity_2m'] }}%
                        </h2>
                        <small class="text-muted small">Relatif</small>
                    </div>
                    <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        💧
                    </div>
                </div>
            </div>
        </div>

        {{-- Kecepatan Angin & Angin Kencang --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            @php
                $wind = $weather['current']['wind_speed_10m'] ?? 0;
                $isStrongWind = $wind > 20;
            @endphp
            <div class="card border border-info-subtle shadow-sm rounded-4 h-100 transition-hover bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.72rem;">Kec. Angin</small>
                        <h2 class="fw-bold text-info mb-0 font-monospace">
                            {{ $wind }} <span class="fs-7 fw-normal text-muted">km/h</span>
                        </h2>
                        <small class="fw-bold {{ $isStrongWind ? 'text-danger' : 'text-success' }}">
                            {{ $isStrongWind ? '💨 Kencang' : '🍃 Normal' }}
                        </small>
                    </div>
                    <div class="icon-shape bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        🌬️
                    </div>
                </div>
            </div>
        </div>

        {{-- Curah Hujan & Status Hujan --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            @php
                $precip = $weather['current']['precipitation'] ?? 0;
                $isRaining = $precip > 0;
            @endphp
            <div class="card border border-primary-subtle shadow-sm rounded-4 h-100 transition-hover bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.72rem;">Hujan</small>
                        <h2 class="fw-bold text-primary mb-0 font-monospace">
                            {{ $precip }} <span class="fs-7 fw-normal text-muted">mm</span>
                        </h2>
                        <small class="fw-bold {{ $isRaining ? 'text-primary' : 'text-success' }}">
                            {{ $isRaining ? '🌧️ Hujan Aktif' : '☀️ Nihil' }}
                        </small>
                    </div>
                    <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        🌧️
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Badai --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            @php
                $wCode = $weather['current']['weather_code'] ?? 0;
                $isStorm = in_array($wCode, [95, 96, 99]);
            @endphp
            <div class="card border {{ $isStorm ? 'border-danger' : 'border-success-subtle' }} shadow-sm rounded-4 h-100 transition-hover bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.72rem;">Status Badai</small>
                        <h2 class="fw-bold {{ $isStorm ? 'text-danger' : 'text-success' }} mb-0 font-monospace" style="font-size: 1.2rem; margin-top: 4px; margin-bottom: 4px;">
                            {{ $isStorm ? 'BAHAYA' : 'AMAN' }}
                        </h2>
                        <small class="fw-bold {{ $isStorm ? 'text-danger' : 'text-success' }}">
                            {{ $isStorm ? '⛈️ Badai Aktif' : '🛡️ Badai Nihil' }}
                        </small>
                    </div>
                    <div class="icon-shape {{ $isStorm ? 'bg-danger bg-opacity-10 text-danger' : 'bg-success bg-opacity-10 text-success' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        ⛈️
                    </div>
                </div>
            </div>
        </div>

        {{-- Risiko Cuaca --}}
        <div class="col-xl-2 col-md-4 col-sm-6">
            @php
                $windSpeed = $weather['current']['wind_speed_10m'] ?? 0;
                if ($windSpeed < 20) {
                    $riskText = 'Rendah';
                    $riskScore = 10;
                    $riskColorClass = 'text-success';
                    $riskBorderClass = 'border-success-subtle';
                    $riskBgClass = 'bg-success bg-opacity-10';
                } elseif ($windSpeed < 40) {
                    $riskText = 'Sedang';
                    $riskScore = 20;
                    $riskColorClass = 'text-warning-emphasis';
                    $riskBorderClass = 'border-warning-subtle';
                    $riskBgClass = 'bg-warning bg-opacity-10';
                } else {
                    $riskText = 'Tinggi';
                    $riskScore = 30;
                    $riskColorClass = 'text-danger';
                    $riskBorderClass = 'border-danger-subtle';
                    $riskBgClass = 'bg-danger bg-opacity-10';
                }
            @endphp
            <div class="card border {{ $riskBorderClass }} shadow-sm rounded-4 h-100 transition-hover bg-white">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 0.72rem;">Risiko Cuaca</small>
                        <h2 class="fw-bold {{ $riskColorClass }} mb-0 font-monospace">
                            {{ $riskScore }} <span class="fs-7 fw-normal text-muted">/ 30</span>
                        </h2>
                        <small class="fw-bold {{ $riskColorClass }}">Tingkat {{ $riskText }}</small>
                    </div>
                    <div class="icon-shape {{ $riskBgClass }} {{ $riskColorClass }} rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        <i class="bi bi-shield-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Peta --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center border-bottom border-light">
                    <span class="fw-bold text-slate-800"><i class="bi bi-map text-muted me-2"></i>Peta Geospasial Wilayah & Cuaca</span>
                    <span class="badge bg-light text-secondary border px-2 py-1 rounded small">Data Real-Time</span>
                </div>
                <div class="card-body p-0 position-relative">
                    <div id="weatherMap" style="height: 420px; z-index: 1;"></div>
                </div>
            </div>
        </div>

        {{-- Prakiraan Cuaca --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between border-bottom border-light">
                    <span class="fw-bold text-slate-800"><i class="bi bi-calendar3 text-muted me-2"></i>Prakiraan Cuaca 7 Hari</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 rounded-pill small fw-semibold font-monospace">7 Hari Depan</span>
                </div>
                <div class="card-body p-0" style="max-height: 420px; overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-slate-700 sticky-top bg-white border-bottom" style="z-index: 10;">
                                <tr>
                                    <th class="ps-4 py-3 border-0 small tracking-wider text-uppercase fw-bold">Tanggal</th>
                                    <th class="py-3 border-0 small tracking-wider text-uppercase fw-bold text-center">Suhu Maks</th>
                                    <th class="pe-4 py-3 border-0 small tracking-wider text-uppercase fw-bold text-center">Suhu Min</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($weather['daily']['time'] as $i => $date)
                                <tr>
                                    <td class="ps-4 py-3 border-light fw-medium text-slate-700 font-monospace" style="font-size: 0.85rem;">
                                        {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMM Y') }}
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

    const baseMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Weather WMS Layers from Environment Canada (MSC GeoMet)
    const tempLayer = L.tileLayer.wms('https://geo.weather.gc.ca/geomet?', {
        layers: 'GDPS.ETA_TT',
        format: 'image/png',
        transparent: true,
        opacity: 0.4,
        version: '1.3.0',
        attribution: 'Environment Canada'
    });

    const precipLayer = L.tileLayer.wms('https://geo.weather.gc.ca/geomet?', {
        layers: 'GDPS.ETA_PR',
        format: 'image/png',
        transparent: true,
        opacity: 0.45,
        version: '1.3.0',
        attribution: 'Environment Canada'
    });

    // Add Layer Control
    const overlays = {
        "Temperatur Global": tempLayer,
        "Curah Hujan Global": precipLayer
    };
    L.control.layers(null, overlays, { collapsed: false }).addTo(map);

    const marker = L.marker([{{ $country->latitude }}, {{ $country->longitude }}]).addTo(map);

    // Desain ulang popup agar kontras dan terbaca dengan jelas
    marker.bindPopup(`
        <div style="font-family: system-ui, -apple-system, sans-serif; padding: 4px; text-align: left; min-width: 170px;">
            <div style="font-size: 1.4rem; margin-bottom: 4px;">{{ $country->flag }}</div>
            <h6 style="margin: 0 0 8px 0; font-weight: 700; color: #1e293b;">{{ $country->name }}</h6>
            <div style="font-size: 0.78rem; color: #475569; line-height: 1.5;">
                <p style="margin: 2px 0;">🔴 <b>Suhu:</b> {{ $weather['current']['temperature_2m'] }} °C</p>
                <p style="margin: 2px 0;">🔵 <b>Kelembapan:</b> {{ $weather['current']['relative_humidity_2m'] }} %</p>
                <p style="margin: 2px 0;">🟢 <b>Kec. Angin:</b> {{ $weather['current']['wind_speed_10m'] }} km/h ({{ ($weather['current']['wind_speed_10m'] ?? 0) > 20 ? 'Kencang' : 'Normal' }})</p>
                <p style="margin: 2px 0;">🌧️ <b>Hujan:</b> {{ $weather['current']['precipitation'] ?? 0 }} mm ({{ ($weather['current']['precipitation'] ?? 0) > 0 ? 'Ya' : 'Tidak' }})</p>
                <p style="margin: 2px 0;">⛈️ <b>Badai:</b> {{ in_array($weather['current']['weather_code'] ?? 0, [95, 96, 99]) ? 'Ya (Aktif)' : 'Tidak' }}</p>
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