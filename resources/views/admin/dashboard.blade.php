@extends('layouts.admin')

@section('content')
<style>
    /* Mengubah warna teks sub-judul aplikasi menjadi emas */
    .text-primary.fw-semibold {
        color: #C5A059 !important;
    }

    /* Mengubah kotak statistik atas menjadi putih bersih dengan border emas tipis */
    .card.shadow-sm.border-0.rounded-3 {
        background-color: #FFFFFF !important;
        border: 1px solid rgba(197, 160, 89, 0.25) !important;
    }

    /* Mengubah warna lingkaran ikon statistik (User, Negara, Artikel, Pelabuhan) */
    .bg-primary-subtle.text-primary,
    .bg-success-subtle.text-success,
    .bg-info-subtle.text-info,
    .bg-warning-subtle.text-warning {
        background-color: #1F2833 !important;
        color: #C5A059 !important;
    }

    /* Mengubah warna ikon utama di menu manajemen kontrol bawah */
    .text-primary.fs-2,
    .text-success.fs-2,
    .text-warning.fs-2 {
        color: #1F2833 !important;
    }

    /* Mengubah warna ikon slider di judul menu bawah */
    .bi-sliders {
        color: #C5A059 !important;
    }

    /* Mengubah seluruh tombol outline menu menjadi tema emas & midnight */
    .btn-outline-primary,
    .btn-outline-success,
    .btn-outline-warning {
        border: 1px solid #C5A059 !important;
        color: #B38F49 !important;
        background: transparent !important;
        font-weight: 600 !important;
    }
    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-warning:hover {
        background-color: #1F2833 !important;
        color: #C5A059 !important;
        border-color: #1F2833 !important;
    }

    /* Efek hover untuk mempercantik interaksi menu manajemen tanpa merusak layout */
    .transition-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .transition-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1.5rem rgba(197, 160, 89, 0.1)!important;
        border: 1px solid rgba(197, 160, 89, 0.4) !important;
    }
</style>

<div class="mb-4">
    <p class="text-muted mb-0">
        Sistem Panel Kendali Utama <span class="fw-semibold text-primary">Global Supply Chain Risk Intelligence</span>.
    </p>
</div>

    <!-- Stats Section (Top Cards) -->
    <div class="row g-4 mb-5">
        <!-- Card Total User -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase d-block mb-1">Total User</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalUsers }}</h2>
                    </div>
                    <div class="p-3 bg-primary-subtle text-primary rounded-3 fs-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Artikel -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase d-block mb-1">Total Artikel Analisis</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalArticles }}</h2>
                    </div>
                    <div class="p-3 bg-info-subtle text-info rounded-3 fs-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Pelabuhan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase d-block mb-1">Dataset Pelabuhan</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalPorts }}</h2>
                    </div>
                    <div class="p-3 bg-warning-subtle text-warning rounded-3 fs-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-anchor"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4 mt-3">
        <!-- Kolom Kiri (Aktivitas Terbaru - col-lg-8) -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3 h-100" style="background-color: #FFFFFF !important; border: 1px solid rgba(197, 160, 89, 0.25) !important;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history" style="color: #C5A059 !important;"></i> Aktivitas Terbaru Sistem
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Daftar tindakan administratif dan pendaftaran pengguna terkini.</p>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr style="border-bottom: 2px solid rgba(197, 160, 89, 0.15);">
                                    <th width="100" class="text-muted small fw-bold text-uppercase">Tipe</th>
                                    <th class="text-muted small fw-bold text-uppercase">Aktivitas</th>
                                    <th class="text-muted small fw-bold text-uppercase">Keterangan</th>
                                    <th width="120" class="text-muted small fw-bold text-uppercase">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $act)
                                    <tr style="border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                        <td>
                                            <span class="badge bg-{{ $act['color'] }} bg-opacity-10 text-{{ $act['color'] }} border border-{{ $act['color'] }}-subtle px-2.5 py-1.5 rounded-pill d-inline-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                                <i class="bi {{ $act['icon'] }}"></i> {{ ucfirst($act['type']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-dark small">{{ $act['title'] }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted small text-break">{{ $act['description'] }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $act['time'] ? $act['time']->diffForHumans() : '-' }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder-x display-6 mb-2 d-block"></i>
                                            Belum ada aktivitas tercatat hari ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan (Menu Aksi Cepat Vertikal - col-lg-4) -->
        <div class="col-lg-4">
            <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                <i class="bi bi-sliders"></i> Kontrol Cepat
            </h5>

            <div class="d-flex flex-column gap-4">
                <!-- Kelola User -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="text-primary fs-3">
                                <i class="bi bi-person-gear"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Kelola User</h5>
                        </div>
                        <p class="text-muted small mb-3">
                            Tambah, edit hak akses, atau hapus kredensial pengguna sistem.
                        </p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                            Masuk Menu <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>

                <!-- Kelola Artikel Analisis -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="text-success fs-3">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Artikel Analisis</h5>
                        </div>
                        <p class="text-muted small mb-3">
                            Manajemen artikel analisis, intelijen risiko logistik, dan laporan rantai pasok.
                        </p>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-success btn-sm w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                            Masuk Menu <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>

                <!-- Kelola Dataset Pelabuhan -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="text-warning fs-3">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Dataset Pelabuhan</h5>
                        </div>
                        <p class="text-muted small mb-3">
                            Perbarui dataset koordinat pelabuhan dunia serta data titik risiko simpul maritim.
                        </p>
                        <a href="{{ route('admin.ports.index') }}" class="btn btn-outline-warning btn-sm w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                            Masuk Menu <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection