@extends('layouts.master')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">💱 Pemantauan Mata Uang</h2>
        <p class="text-muted mb-0">
            Nilai tukar waktu nyata (Mata Uang Dasar: USD)
        </p>
    </div>

    <div class="row g-4">
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body p-4">
                    <div class="display-5 mb-2">💵</div>
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">USD</small>
                    <h3 class="fw-bold text-dark mb-0">
                        {{ number_format($rates['USD'], 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body p-4">
                    <div class="display-5 mb-2">🇮🇩</div>
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Rupiah Indonesia</small>
                    <h3 class="fw-bold text-primary mb-0">
                        {{ number_format($rates['IDR'], 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body p-4">
                    <div class="display-5 mb-2">🇪🇺</div>
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Euro</small>
                    <h3 class="fw-bold text-dark mb-0">
                        {{ number_format($rates['EUR'], 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body p-4">
                    <div class="display-5 mb-2">🇯🇵</div>
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">Yen Jepang</small>
                    <h3 class="fw-bold text-dark mb-0">
                        {{ number_format($rates['JPY'], 2, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden h-100">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark">
                    💱 Tabel Nilai Tukar
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="ps-4 py-3">Mata Uang</th>
                                    <th class="pe-4 py-3 text-end">Nilai Tukar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rates as $currency => $rate)
                                <tr>
                                    <td class="ps-4 fw-bold text-secondary py-3">
                                        {{ $currency }}
                                    </td>
                                    <td class="pe-4 text-end fw-medium text-dark py-3">
                                        {{ number_format($rate, 2, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-white border-bottom fw-bold py-3 text-dark">
                    📈 Grafik Nilai Tukar
                </div>
                <div class="card-body p-4">
                    <div class="w-100" style="position: relative; height: 320px;">
                        <canvas id="currencyChart"></canvas>
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
    const ctx = document.getElementById('currencyChart');

    // Menyesuaikan dengan warna tema utama aplikasi secara otomatis
    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary') || '#0d6efd';

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'USD',
                'IDR',
                'EUR',
                'JPY',
                'SGD'
            ],
            datasets: [{
                label: 'Nilai Tukar',
                data: [
                    {{ $rates['USD'] }},
                    {{ $rates['IDR'] }},
                    {{ $rates['EUR'] }},
                    {{ $rates['JPY'] }},
                    {{ $rates['SGD'] }}
                ],
                backgroundColor: primaryColor + 'cc', // Warna utama transparan
                borderColor: primaryColor,
                borderWidth: 1,
                borderRadius: 4 // Membuat grafik batang memiliki sudut tumpul modern
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Menyembunyikan kotak label atas agar chart bersih
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('id-ID'); // Format angka ribuan Indonesia
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush