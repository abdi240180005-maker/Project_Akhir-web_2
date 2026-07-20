@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">

    <!-- CSS khusus untuk cetak laporan & visualisasi premium -->
    <style>
        .icon-circle {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .chart-container {
            position: relative;
            height: 320px;
            width: 100%;
        }
        .kpi-card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        }
        .chart-card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            background: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .chart-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06) !important;
        }
        .profile-card {
            border: none !important;
            border-radius: 16px !important;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
        }
        /* Custom Styling for Select2 inside Card Header */
        .select-country-container .select2-container--default .select2-selection--single {
            border-radius: 10px !important;
            height: 40px !important;
            border: 1px solid rgba(0,0,0,0.1) !important;
            padding: 5px 12px !important;
            background-color: #f8f9fa !important;
        }
        .select-country-container .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
        }

        @media print {
            .sidebar, .top-navbar, .d-print-none, .btn, form {
                display: none !important;
            }
            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            .content-area {
                padding: 0 !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
            .card, .kpi-card, .chart-card, .profile-card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                break-inside: avoid;
                page-break-inside: avoid;
                margin-bottom: 20px !important;
            }
            .chart-container {
                height: 250px !important;
            }
        }
    </style>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom d-print-none">
        <div>
            <h2 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <span>📊</span> Visualisasi Statistik Risiko Global
            </h2>
            <p class="text-muted mb-0">
                Pemantauan data statistik, profil kerentanan, dan indikator rantai pasok global.
            </p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 rounded-3 fw-bold">
                <i class="bi bi-printer-fill"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- 4 KPI Summary Cards -->
    <div class="row g-4 mb-4">
        <!-- Card 1 -->
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 kpi-card">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Negara Dipantau</small>
                        <h2 class="fw-extrabold text-dark mb-1 font-monospace">{{ $totalCountries }}</h2>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-2.5 py-0.5 small fw-medium">Global</span>
                    </div>
                    <div class="icon-circle bg-primary bg-opacity-10 text-primary fs-3">
                        <i class="bi bi-globe"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 kpi-card">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Rata-Rata Risiko</small>
                        <h2 class="fw-extrabold text-dark mb-1 font-monospace">{{ $avgGlobalRisk }} / 100</h2>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-2.5 py-0.5 small fw-medium">Skor Global</span>
                    </div>
                    <div class="icon-circle bg-success bg-opacity-10 text-success fs-3">
                        <i class="bi bi-shield-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 kpi-card">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Risiko Tinggi</small>
                        <h2 class="fw-extrabold text-dark mb-1 font-monospace">{{ $highRiskCount }}</h2>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle rounded-pill px-2.5 py-0.5 small fw-medium">Butuh Perhatian</span>
                    </div>
                    <div class="icon-circle bg-danger bg-opacity-10 text-danger fs-3">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 kpi-card">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-uppercase tracking-wider text-muted fw-bold d-block mb-1" style="font-size: 0.75rem;">Pelabuhan Global</small>
                        <h2 class="fw-extrabold text-dark mb-1 font-monospace">{{ $totalPorts }}</h2>
                        <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle rounded-pill px-2.5 py-0.5 small fw-medium">Terintegrasi</span>
                    </div>
                    <div class="icon-circle bg-warning bg-opacity-10 text-warning-emphasis fs-3">
                        <i class="bi bi-anchor"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2x2 Grid of Charts -->
    <div class="row g-4 mb-4">
        <!-- Chart 1: Distribusi Tingkat Risiko -->
        <div class="col-lg-6">
            <div class="card chart-card">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-pie-chart text-primary"></i> Distribusi Tingkat Risiko Negara
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="riskDoughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 2: Top 10 Risiko Tertinggi -->
        <div class="col-lg-6">
            <div class="card chart-card">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart-steps text-danger"></i> Top 10 Negara Kerentanan Rantai Pasok Tertinggi
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="topRiskHorizontalChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 3: Top 10 Infrastruktur Pelabuhan -->
        <div class="col-lg-6">
            <div class="card chart-card">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart text-info"></i> 10 Negara Infrastruktur Pelabuhan Terbanyak
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="topPortsVerticalChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 4: Korelasi Inflasi vs Risiko -->
        <div class="col-lg-6">
            <div class="card chart-card">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-graph-up-arrow text-success"></i> Analisis Korelasi Skor Risiko vs Tingkat Inflasi
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="correlationBubbleChart"></canvas>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted">*Ukuran gelembung mewakili skala populasi negara.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Profiling Negara & Radar Chart Comparison -->
    <div class="card profile-card mb-4">
        <div class="card-header bg-white border-bottom fw-bold py-3 text-dark d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <span class="d-flex align-items-center gap-2">
                <span>🎯</span> Alat Profiling & Perbandingan Radar Negara
            </span>
            <div class="select-country-container" style="min-width: 280px;">
                <select id="country-select" class="form-select border bg-light py-2 fw-medium rounded-3">
                    @foreach($countries as $item)
                        <option value="{{ $item->iso2 }}" {{ $item->iso2 == 'ID' ? 'selected' : '' }}>
                            {{ $item->flag }} &nbsp; {{ $item->name }} ({{ $item->iso2 }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body p-4 bg-light bg-opacity-10">
            <div class="row g-4">
                <!-- Kolom Kiri: Profil Detail Negara -->
                <div class="col-lg-5">
                    <div class="card border border-light shadow-none rounded-3 p-4 bg-white d-flex flex-column h-100 justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <img
                                    id="profile-flag"
                                    src="https://flagcdn.com/w160/id.png"
                                    alt="Flag"
                                    class="rounded shadow-sm border border-light"
                                    style="width: 100px; height: 60px; object-fit: cover;">
                                <div>
                                    <h3 id="profile-name" class="fw-bold text-dark mb-1">Indonesia</h3>
                                    <span id="profile-code-badge" class="badge bg-secondary font-monospace">ID / IDN</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <tbody>
                                        <tr class="border-bottom border-light">
                                            <td class="text-muted py-2.5 ps-0">Ibu Kota</td>
                                            <td id="profile-capital" class="fw-semibold text-dark text-end py-2.5 pe-0">Jakarta</td>
                                        </tr>
                                        <tr class="border-bottom border-light">
                                            <td class="text-muted py-2.5 ps-0">Mata Uang</td>
                                            <td id="profile-currency" class="fw-semibold text-dark text-end py-2.5 pe-0">IDR (Indonesian Rupiah)</td>
                                        </tr>
                                        <tr class="border-bottom border-light">
                                            <td class="text-muted py-2.5 ps-0">Jumlah Populasi</td>
                                            <td id="profile-population" class="fw-semibold text-dark text-end py-2.5 pe-0 font-monospace">273.8M</td>
                                        </tr>
                                        <tr class="border-bottom border-light">
                                            <td class="text-muted py-2.5 ps-0">Suhu Cuaca Saat Ini</td>
                                            <td id="profile-temp" class="fw-semibold text-primary text-end py-2.5 pe-0 font-monospace">
                                                <div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...
                                            </td>
                                        </tr>
                                        <tr class="border-bottom border-light">
                                            <td class="text-muted py-2.5 ps-0">Jumlah Pelabuhan</td>
                                            <td id="profile-ports" class="fw-semibold text-dark text-end py-2.5 pe-0 font-monospace">13</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top border-light text-center">
                            <h6 class="text-muted text-uppercase tracking-wider mb-2" style="font-size: 0.72rem; font-weight: bold;">Tingkat Indeks Risiko Rantai Pasok</h6>
                            <span id="profile-risk-badge" class="badge bg-warning text-dark border border-warning-subtle fs-6 px-4 py-2 rounded-3 fw-bold">
                                RISIKO SEDANG (40/100)
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Radar Chart Comparison -->
                <div class="col-lg-7">
                    <div class="card border border-light shadow-none rounded-3 p-4 bg-white h-100">
                        <h6 class="fw-bold text-slate-500 text-uppercase tracking-wider mb-3" style="font-size: 0.75rem;">
                            🕸️ Perbandingan Metrik Relatif Terhadap Rata-Rata Global
                        </h6>
                        <div style="position: relative; height: 350px;">
                            <canvas id="radarChart"></canvas>
                        </div>
                        <div class="text-center mt-2">
                            <small class="text-muted">*Semua metrik dinormalisasi ke skala 0-100 demi keseimbangan grafik.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts Section: Chart.js & Select2 initialization & interactive JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ------------------------------------------------------------------
    // Data Server-Side yang Dilewatkan ke Client
    // ------------------------------------------------------------------
    const countriesData = {!! $countriesJson !!};
    const globalAverages = {!! json_encode($globalAverages) !!};
    const riskCounts = {!! json_encode($riskCounts) !!};
    const topRisk = {!! json_encode($topRisk) !!};
    const topPorts = {!! json_encode($topPorts) !!};
    const correlationData = {!! $correlationData !!};

    // ------------------------------------------------------------------
    // Grafik 1: Distribusi Tingkat Risiko (Doughnut Chart)
    // ------------------------------------------------------------------
    const riskDoughnutCtx = document.getElementById('riskDoughnutChart').getContext('2d');
    new Chart(riskDoughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Low Risk', 'Medium Risk', 'High Risk'],
            datasets: [{
                data: [riskCounts.Low, riskCounts.Medium, riskCounts.High],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.85)', // Green
                    'rgba(245, 158, 11, 0.85)',  // Gold/Orange
                    'rgba(239, 68, 68, 0.85)'    // Red
                ],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 15, font: { family: 'Poppins' } }
                }
            }
        }
    });

    // ------------------------------------------------------------------
    // Grafik 2: Top 10 Kerentanan Risiko (Horizontal Bar Chart)
    // ------------------------------------------------------------------
    const topRiskCtx = document.getElementById('topRiskHorizontalChart').getContext('2d');
    new Chart(topRiskCtx, {
        type: 'bar',
        data: {
            labels: topRisk.labels,
            datasets: [{
                label: 'Skor Risiko',
                data: topRisk.data,
                backgroundColor: 'rgba(239, 68, 68, 0.8)', // Merah lembut
                borderColor: '#ef4444',
                borderWidth: 1.5,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: '#f3f4f6' }
                },
                y: { grid: { display: false } }
            }
        }
    });

    // ------------------------------------------------------------------
    // Grafik 3: Top 10 Jumlah Pelabuhan (Vertical Bar Chart)
    // ------------------------------------------------------------------
    const topPortsCtx = document.getElementById('topPortsVerticalChart').getContext('2d');
    new Chart(topPortsCtx, {
        type: 'bar',
        data: {
            labels: topPorts.labels,
            datasets: [{
                label: 'Jumlah Pelabuhan',
                data: topPorts.data,
                backgroundColor: 'rgba(2, 132, 199, 0.8)', // Biru langit
                borderColor: '#0284c7',
                borderWidth: 1.5,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' }
                }
            }
        }
    });

    // ------------------------------------------------------------------
    // Grafik 4: Korelasi Inflasi vs Risiko (Bubble Chart)
    // ------------------------------------------------------------------
    const correlationCtx = document.getElementById('correlationBubbleChart').getContext('2d');
    new Chart(correlationCtx, {
        type: 'bubble',
        data: {
            datasets: [{
                label: 'Negara',
                data: correlationData,
                backgroundColor: 'rgba(79, 70, 229, 0.6)', // Indigo lembut
                borderColor: '#4f46e5',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const p = context.raw;
                            return `${p.country}: Inflasi: ${p.x}%, Risiko: ${p.y}, Populasi (Radius): ${p.r}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Tingkat Inflasi (%)', font: { family: 'Poppins', weight: 'bold' } },
                    grid: { color: '#f3f4f6' }
                },
                y: {
                    title: { display: true, text: 'Skor Risiko (0-100)', font: { family: 'Poppins', weight: 'bold' } },
                    beginAtZero: true,
                    max: 100,
                    grid: { color: '#f3f4f6' }
                }
            }
        }
    });

    // ------------------------------------------------------------------
    // Radar Chart: Profil Perbandingan Negara vs Global Average
    // ------------------------------------------------------------------
    const radarCtx = document.getElementById('radarChart').getContext('2d');
    const radarChart = new Chart(radarCtx, {
        type: 'radar',
        data: {
            labels: [
                'Skor Risiko',
                'Tingkat Inflasi',
                'Temperatur Lingkungan',
                'Skala Populasi',
                'Infrastruktur Pelabuhan'
            ],
            datasets: [
                {
                    label: 'Rata-Rata Global',
                    data: [
                        globalAverages.risk,
                        globalAverages.inflation,
                        globalAverages.temp,
                        globalAverages.population,
                        globalAverages.ports
                    ],
                    backgroundColor: 'rgba(209, 213, 219, 0.4)', // Abu-abu semi-transparan
                    borderColor: 'rgba(156, 163, 175, 0.8)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(156, 163, 175, 1)'
                },
                {
                    label: 'Indonesia (ID)', // Default awal
                    data: [0, 0, 0, 0, 0], // Diisi via JS saat load
                    backgroundColor: 'rgba(6, 78, 59, 0.2)', // Hijau semi-transparan
                    borderColor: 'rgba(6, 78, 59, 0.9)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(6, 78, 59, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(6, 78, 59, 1)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: 'Poppins' } } }
            },
            scales: {
                r: {
                    angleLines: { color: '#e5e7eb' },
                    grid: { color: '#e5e7eb' },
                    pointLabels: { font: { family: 'Poppins', size: 10 } },
                    suggestedMin: 0,
                    suggestedMax: 100
                }
            }
        }
    });

    // ------------------------------------------------------------------
    // Event Handler Dropdown & Fungsionalitas Profiling
    // ------------------------------------------------------------------
    const countrySelect = document.getElementById('country-select');

    // Helper Math Functions
    function log10(val) {
        return Math.log(val) / Math.LN10;
    }
    function normalize(val, max) {
        return Math.min(100, Math.max(0, (val / max) * 100));
    }
    function normalizeLog(val, maxLog) {
        if (val <= 0) return 0;
        return Math.min(100, Math.max(0, (log10(val) / maxLog) * 100));
    }
    function formatPopulation(num) {
        if (num >= 1.0e9) return (num / 1.0e9).toFixed(1) + ' B (Miliar)';
        if (num >= 1.0e6) return (num / 1.0e6).toFixed(1) + ' M (Juta)';
        if (num >= 1.0e3) return (num / 1.0e3).toFixed(1) + ' K (Ribu)';
        return num.toLocaleString('id-ID');
    }

    async function updateCountryProfile(isoCode) {
        const country = countriesData[isoCode];
        if (!country) return;

        // Tampilkan loading spinner untuk temperatur
        document.getElementById('profile-temp').innerHTML = `
            <div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...
        `;

        // 1. Perbarui Elemen Teks & Gambar Profil
        document.getElementById('profile-name').textContent = country.name;
        document.getElementById('profile-code-badge').textContent = `${country.iso2}`;
        document.getElementById('profile-capital').textContent = country.capital;
        document.getElementById('profile-currency').textContent = country.currency;
        document.getElementById('profile-population').textContent = formatPopulation(country.population);
        document.getElementById('profile-ports').textContent = country.ports_count;
        document.getElementById('profile-flag').src = `https://flagcdn.com/w160/${country.iso2.toLowerCase()}.png`;

        // 2. Perbarui Badge Level Risiko
        const risk = country.risk_score;
        let badgeClass = 'bg-success';
        let badgeLabel = `RISIKO RENDAH (${risk}/100)`;
        if (risk > 65) {
            badgeClass = 'bg-danger';
            badgeLabel = `RISIKO TINGGI (${risk}/100)`;
        } else if (risk > 35) {
            badgeClass = 'bg-warning text-dark';
            badgeLabel = `RISIKO SEDANG (${risk}/100)`;
        }

        const riskBadge = document.getElementById('profile-risk-badge');
        riskBadge.className = `badge ${badgeClass} border fs-6 px-4 py-2 rounded-3 fw-bold`;
        riskBadge.textContent = badgeLabel;

        // 3. Fetch real-time temperature (client-side API call)
        let currentTemp = 24.5; // Fallback
        if (country.latitude && country.longitude) {
            try {
                const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${country.latitude}&longitude=${country.longitude}&current=temperature_2m`);
                if (response.ok) {
                    const data = await response.json();
                    if (data && data.current && data.current.temperature_2m !== undefined) {
                        currentTemp = data.current.temperature_2m;
                    }
                }
            } catch (err) {
                console.error("Gagal memuat cuaca dari Open-Meteo API:", err);
            }
        }
        document.getElementById('profile-temp').textContent = `${currentTemp} °C`;

        // 4. Perbarui Dataset Radar Chart
        const normalizedRisk = country.risk_score;
        const normalizedInflation = normalize(country.inflation_rate, 15);
        const normalizedTemp = normalize(currentTemp, 40);
        const normalizedPop = normalizeLog(country.population, 9);
        const normalizedPorts = normalize(country.ports_count, 30);

        radarChart.data.datasets[1].label = `${country.name} (${country.iso2})`;
        radarChart.data.datasets[1].data = [
            normalizedRisk,
            normalizedInflation,
            normalizedTemp,
            normalizedPop,
            normalizedPorts
        ];
        radarChart.update();
    }

    // Listener Perubahan Dropdown Negara
    countrySelect.addEventListener('change', function () {
        updateCountryProfile(this.value);
    });

    // Inisialisasi Pertama Kali dengan 'ID' (Indonesia)
    updateCountryProfile('ID');
});
</script>
@endsection
