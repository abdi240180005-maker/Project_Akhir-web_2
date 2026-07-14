@extends('layouts.master')

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

<div class="container py-5"> 
        <p class="text-muted mb-0">
            Sistem Panel Kendali Utama <span class="fw-semibold text-primary">Global Supply Chain Risk Intelligence</span>.
        </p>
    </div>

    <!-- Stats Section (Top Cards) -->
    <div class="row g-4 mb-5">
        <!-- Card Total User -->
        <div class="col-sm-6 col-lg-3">
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

        <!-- Card Total Negara -->
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase d-block mb-1">Total Negara</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalCountries }}</h2>
                    </div>
                    <div class="p-3 bg-success-subtle text-success rounded-3 fs-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-globe-americas"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Artikel -->
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase d-block mb-1">Total Artikel</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalArticles }}</h2>
                    </div>
                    <div class="p-3 bg-info-subtle text-info rounded-3 fs-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Pelabuhan -->
        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium text-uppercase d-block mb-1">Pelabuhan</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalPorts }}</h2>
                    </div>
                    <div class="p-3 bg-warning-subtle text-warning rounded-3 fs-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-anchor"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section (Bottom Cards) -->
    <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-sliders"></i> Menu Manajemen Kontrol
    </h5>

    <div class="row g-4">
        <!-- Kelola User -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 h-100 transition-card">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="text-primary fs-2 mb-3">
                            <i class="bi bi-person-gear"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Kelola Pengguna</h5>
                        <p class="text-muted small mb-4">
                            Tambah, edit hak akses, atau hapus kredensial pengguna sistem.
                        </p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                        Masuk Menu <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Kelola Analisis -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 h-100 transition-card">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="text-success fs-2 mb-3">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Kelola Analisis</h5>
                        <p class="text-muted small mb-4">
                            Manajemen artikel analisis, intelijen risiko logistik, dan laporan rantai pasok.
                        </p>
                    </div>
                    <!-- Sesuaikan route artikel Anda disini jika sudah ada -->
                    <a href="#" class="btn btn-outline-success btn-sm w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                        Masuk Menu <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Kelola Pelabuhan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 h-100 transition-card">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="text-warning fs-2 mb-3">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Kelola Pelabuhan</h5>
                        <p class="text-muted small mb-4">
                            Perbarui dataset koordinat pelabuhan dunia serta data titik risiko simpul maritim.
                        </p>
                    </div>
                    <!-- Sesuaikan route pelabuhan Anda disini jika sudah ada -->
                    <a href="#" class="btn btn-outline-warning btn-sm w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                        Masuk Menu <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection