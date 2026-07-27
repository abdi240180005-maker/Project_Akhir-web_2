@extends('layouts.master')

@section('content')

<div class="container-fluid px-4 py-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- Header --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom border-light">
        <div>
            <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <span style="font-size: 1.6rem;">⚓</span> Dashboard Pelabuhan Global
            </h3>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span id="clock" class="badge bg-white text-dark shadow-sm px-3 py-2 fw-semibold font-monospace border" style="font-size:0.88rem; border-radius: 0.5rem;">
                --.--.--
            </span>
            <span class="badge bg-white text-dark border shadow-sm px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2" style="font-size:0.88rem; border-radius: 0.5rem;">
                <span class="bg-success rounded-circle animate-pulse" style="width: 8px; height: 8px; display: inline-block;"></span> Online
            </span>
        </div>
    </div>

    {{-- 4 Kartu Ringkasan Atas --}}
    <div class="row g-3 mb-4">
        {{-- Total Pelabuhan --}}
        <div class="col-lg-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 border-start border-primary border-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                        ⚓
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0 font-monospace">{{ $totalPorts }}</h3>
                        <small class="text-muted d-block fw-semibold">Total Pelabuhan</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kemacetan Rendah --}}
        <div class="col-lg-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 border-start border-success border-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                        ✓
                    </div>
                    <div>
                        <h3 class="fw-bold text-success mb-0 font-monospace">{{ $lowCount }}</h3>
                        <small class="text-muted d-block fw-semibold">Kemacetan Rendah</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kemacetan Sedang --}}
        <div class="col-lg-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 border-start border-warning border-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                        ⚠️
                    </div>
                    <div>
                        <h3 class="fw-bold text-warning mb-0 font-monospace">{{ $mediumCount }}</h3>
                        <small class="text-muted d-block fw-semibold">Kemacetan Sedang</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kemacetan Tinggi --}}
        <div class="col-lg-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 border-start border-danger border-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                        🛑
                    </div>
                    <div>
                        <h3 class="fw-bold text-danger mb-0 font-monospace">{{ $highCount }}</h3>
                        <small class="text-muted d-block fw-semibold">Kemacetan Tinggi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kalkulator Estimasi Pengiriman Pelabuhan A ke Pelabuhan B --}}
    <div class="card shadow-sm border-0 mb-4 bg-white rounded-4 overflow-hidden border-top border-primary border-4">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <span>🚢</span> Kalkulator Estimasi Waktu Pengiriman (Port-to-Port Route Estimator)
            </h5>
            <p class="text-muted small mb-3">Hitung estimasi durasi pengiriman antar pelabuhan beserta alasan dan rincian faktor penundaan.</p>

            <form method="GET" action="{{ route('ports.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-secondary mb-1">Pelabuhan Asal (Origin Port)</label>
                        <select name="origin_port" class="form-select bg-light py-2 px-3 border-0" style="border-radius: 0.5rem;" required>
                            <option value="">-- Pilih Pelabuhan Asal --</option>
                            @foreach($allPorts as $p)
                                <option value="{{ $p->id }}" {{ request('origin_port') == $p->id ? 'selected' : '' }}>
                                    {{ $p->port_name }} ({{ $p->country }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-secondary mb-1">Pelabuhan Tujuan (Destination Port)</label>
                        <select name="destination_port" class="form-select bg-light py-2 px-3 border-0" style="border-radius: 0.5rem;" required>
                            <option value="">-- Pilih Pelabuhan Tujuan --</option>
                            @foreach($allPorts as $p)
                                <option value="{{ $p->id }}" {{ request('destination_port') == $p->id ? 'selected' : '' }}>
                                    {{ $p->port_name }} ({{ $p->country }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" style="border-radius: 0.5rem;">
                            <i class="bi bi-stopwatch me-1"></i> Cek Estimasi
                        </button>
                    </div>
                </div>
            </form>

            @if(isset($estimateResult) && $estimateResult)
            <div class="mt-4 p-4 rounded-4 bg-slate-50 border border-slate-200">
                <div class="row align-items-center g-4">
                    <div class="col-md-4 text-center border-end">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wider">Estimasi Total Waktu Tiba (ETA)</span>
                        <h1 class="display-4 fw-black text-primary mb-0 font-monospace">{{ $estimateResult['total_days'] }}</h1>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold">~ {{ $estimateResult['total_hours'] }} Jam (Hari)</span>
                    </div>
                    <div class="col-md-8">
                        <h6 class="fw-bold text-dark mb-2">📋 Rincian & Alasan Estimasi Waktu Pengiriman:</h6>
                        <ul class="list-group list-group-flush bg-transparent small">
                            <li class="list-group-item bg-transparent border-0 px-0 py-1 text-slate-700">
                                <strong>1. Jarak Tempuh Laut:</strong> {{ $estimateResult['reasons']['Distance'] }}
                            </li>
                            <li class="list-group-item bg-transparent border-0 px-0 py-1 text-slate-700">
                                <strong>2. Waktu Jelajah Kapal:</strong> {{ $estimateResult['reasons']['Sailing'] }}
                            </li>
                            <li class="list-group-item bg-transparent border-0 px-0 py-1 text-slate-700">
                                <strong>3. Hambatan & Kemacetan Pelabuhan:</strong> {{ $estimateResult['reasons']['PortCongestion'] }}
                            </li>
                            <li class="list-group-item bg-transparent border-0 px-0 py-1 text-slate-700">
                                <strong>4. Mitigasi Cuaca & Gelombang Laut:</strong> {{ $estimateResult['reasons']['WeatherSea'] }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Form Pencarian & Filter Negara --}}
    <div class="card shadow-sm border-0 mb-4 bg-white rounded-4">
        <div class="card-body p-3.5">
            <form method="GET" action="{{ route('ports.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-secondary mb-1.5">Cari Pelabuhan</label>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control bg-light py-2 px-3 border-0"
                            style="border-radius: 0.5rem; font-size: 0.9rem;"
                            placeholder="Nama pelabuhan, negara, wilayah...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-secondary mb-1.5">Filter Negara</label>
                        <select name="country" class="form-select bg-light py-2 px-3 border-0" style="border-radius: 0.5rem; font-size: 0.9rem;">
                            <option value="">Semua Negara</option>
                            @foreach($countries as $c)
                                <option value="{{ $c }}" {{ request('country') === $c ? 'selected' : '' }}>
                                    {{ $c }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold flex-fill" style="border-radius: 0.5rem;">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                        <button type="button" class="btn text-white px-4 py-2 fw-semibold flex-fill" style="background-color: #1a237e; border-radius: 0.5rem;" onclick="window.location.href='{{ route('ports.index') }}'">
                            <i class="bi bi-arrow-repeat me-1"></i> Sync Pelabuhan Global
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Dua Panel (Map + List) --}}
    <div class="row g-4">
        {{-- Peta (Panel Kiri) --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100 bg-white">
                <div class="card-body p-3" style="min-height: 580px;">
                    <div id="map" style="height: 580px; width: 100%;" class="rounded-3 border border-light shadow-sm"></div>
                </div>
            </div>
        </div>

        {{-- Daftar Pelabuhan (Panel Kanan) --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white h-100 d-flex flex-column" style="min-height: 580px;">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex align-items-center justify-content-between">
                    <span class="d-flex align-items-center gap-2">
                        <i class="bi bi-list-task text-primary"></i> Daftar Pelabuhan
                    </span>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill font-monospace px-2.5 py-1">
                        {{ $ports->total() }}
                    </span>
                </div>
                
                <div class="card-body p-3 overflow-y-auto style-scroll flex-grow-1" style="max-height: 440px;">
                    <div class="d-flex flex-column gap-2.5">
                        @forelse($ports as $port)
                            @php
                                $tagClass = 'bg-secondary';
                                if ($port->congestion === 'Rendah') $tagClass = 'bg-success bg-opacity-10 text-success border border-success-subtle';
                                elseif ($port->congestion === 'Sedang') $tagClass = 'bg-warning bg-opacity-10 text-warning border border-warning-subtle';
                                elseif ($port->congestion === 'Tinggi') $tagClass = 'bg-danger bg-opacity-10 text-danger border border-danger-subtle';
                            @endphp
                            <div class="port-item p-3 border rounded-3 bg-light bg-opacity-30 border-light-subtle cursor-pointer transition-all"
                                 onclick="focusPort({{ $port->id }}, {{ $port->latitude }}, {{ $port->longitude }})">
                                <div class="d-flex justify-content-between align-items-start mb-1.5">
                                    <h6 class="fw-bold text-dark mb-0 port-title-text" title="{{ $port->port_name }}">{{ $port->port_name }}</h6>
                                    <span class="badge {{ $tagClass }} small-badge rounded-pill">{{ $port->congestion }}</span>
                                </div>
                                <div class="text-muted small mb-2 d-flex flex-wrap align-items-center gap-1.5" style="font-size: 0.72rem;">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-1.5 py-0.5 font-monospace rounded-1">{{ $port->country }}</span>
                                    <span>•</span>
                                    <span>{{ $port->region }}</span>
                                    <span>•</span>
                                    <span class="font-monospace text-secondary">{{ $port->wpi_code }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-muted" style="font-size: 0.76rem;">
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="bi bi-clock-history"></i> Tunda: <strong class="text-dark">{{ $port->delay_hours }}j</strong>
                                    </span>
                                    <span class="d-flex align-items-center gap-1 font-monospace">
                                        <i class="bi bi-geo-alt"></i> {{ number_format($port->latitude, 4) }}, {{ number_format($port->longitude, 4) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted small">
                                Belum ada data pelabuhan.
                            </div>
                        @endforelse
                    </div>
                </div>

                @if($ports->hasPages())
                    <div class="card-footer bg-white border-top py-2.5 d-flex justify-content-center">
                        <div class="scale-pagination w-100 d-flex justify-content-center">
                            {{ $ports->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<style>
    .style-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .style-scroll::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 4px;
    }
    .style-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .style-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    .port-item {
        border: 1px solid rgba(0,0,0,0.06);
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }
    .port-item:hover {
        transform: translateY(-2px);
        background-color: #ffffff !important;
        border-color: #0d6efd !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.08);
    }
    
    .port-title-text {
        font-size: 0.9rem;
        max-width: 75%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .small-badge {
        font-size: 0.68rem;
        padding: 0.35em 0.7em;
    }
    
    .scale-pagination .pagination {
        margin-bottom: 0;
        font-size: 0.8rem;
        gap: 2px;
    }
    
    .scale-pagination .page-link {
        padding: 0.35rem 0.65rem;
        border-radius: 0.375rem;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .4; }
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi Jam Digital Header
    function updateClock() {
        const now = new Date();
        const hrs = String(now.getHours()).padStart(2, '0');
        const mins = String(now.getMinutes()).padStart(2, '0');
        const secs = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').innerHTML = `<i class="bi bi-clock me-1"></i> ${hrs}.${mins}.${secs}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Inisialisasi Peta Leaflet
    var map = L.map('map', {
        scrollWheelZoom: false
    }).setView([20, 0], 2);

    L.tileLayer(
        'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
        {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }
    ).addTo(map);

    const bounds = [];
    const markersMap = {};

    // Render Markers dari All Ports yang Ter-filter
    @foreach($allPorts as $port)
        @if($port->latitude && $port->longitude)
            (function() {
                const id = {{ $port->id }};
                const lat = {{ $port->latitude }};
                const lng = {{ $port->longitude }};
                const name = {!! json_encode($port->port_name) !!};
                const country = {!! json_encode($port->country) !!};
                const congestion = "{{ $port->congestion }}";
                const delay = {{ $port->delay_hours }};
                const region = "{{ $port->region }}";
                
                let color = '#00ffcc'; // Rendah (Neon Green/Turquoise)
                let badgeClass = 'bg-success';
                if (congestion === 'Sedang') {
                    color = '#ff9f1c'; // Sedang (Neon Orange)
                    badgeClass = 'bg-warning text-dark';
                } else if (congestion === 'Tinggi') {
                    color = '#ff0055'; // Tinggi (Neon Pink-Red)
                    badgeClass = 'bg-danger';
                }

                // Lingkaran luar (efek pendaran neon glow)
                const glow = L.circleMarker([lat, lng], {
                    radius: 13,
                    fillColor: color,
                    color: 'transparent',
                    fillOpacity: 0.25,
                    interactive: false
                }).addTo(map);

                // Lingkaran dalam (core marker)
                const marker = L.circleMarker([lat, lng], {
                    radius: 6,
                    fillColor: color,
                    color: '#ffffff',
                    weight: 1.2,
                    opacity: 1,
                    fillOpacity: 0.95
                }).addTo(map);

                const popupContent = `
                    <div style="font-family: inherit; min-width: 180px;">
                        <h6 class="fw-bold mb-1 text-dark">${name}</h6>
                        <div class="small text-muted mb-2">${region} - ${country}</div>
                        <div class="d-flex align-items-center justify-content-between border-top pt-2">
                            <span class="badge ${badgeClass} small-badge">${congestion}</span>
                            <span class="small font-monospace text-secondary">Tunda: ${delay}j</span>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);
                markersMap[id] = marker;
                bounds.push([lat, lng]);
            })();
        @endif
    @endforeach

    if (bounds.length > 0) {
        map.fitBounds(bounds, { maxZoom: 8, padding: [40, 40] });
    }

    // Fungsi Global untuk Menggeser Peta dan membuka Popup saat List di klik
    window.focusPort = function(id, lat, lng) {
        if (markersMap[id]) {
            map.flyTo([lat, lng], 8, {
                animate: true,
                duration: 1.2
            });
            setTimeout(() => {
                markersMap[id].openPopup();
            }, 1200);
        }
    };
});
</script>

@endpush