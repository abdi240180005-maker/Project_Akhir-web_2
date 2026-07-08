<div class="sidebar d-flex flex-column justify-content-between" style="height: 100vh; overflow-y: auto;">

    <div>

        <div class="logo d-flex align-items-center gap-2 p-3 border-bottom border-secondary border-opacity-25">
            <div class="logo-icon fs-3">
                🌍
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-white" style="font-size: 0.85rem; line-height: 1.2; letter-spacing: 0.03em;">
                    RANTAI PASOKAN GLOBAL
                </h6>
                <span class="badge bg-primary text-uppercase mt-1" style="font-size: 0.65rem; padding: 3px 6px; font-weight: 600;">
                    SISTEM PEMANTAUAN
                </span>
            </div>
        </div>

        <div class="menu mt-4 px-2">

            <a href="{{ route('dashboard') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-3 fs-5"></i>
                <span class="nav-text">Dasbor</span>
            </a>

            <a href="{{ route('countries.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('countries.*') ? 'active' : '' }}">
                <i class="bi bi-globe2 me-3 fs-5"></i>
                <span class="nav-text">Negara</span>
            </a>

            <a href="{{ route('weather.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('weather.*') ? 'active' : '' }}">
                <i class="bi bi-cloud-sun me-3 fs-5"></i>
                <span class="nav-text">Cuaca</span>
            </a>

            <a href="{{ route('currency.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('currency.*') ? 'active' : '' }}">
                <i class="bi bi-currency-exchange me-3 fs-5"></i>
                <span class="nav-text">Mata Uang</span>
            </a>

            <a href="{{ route('economy.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('economy.*') ? 'active' : '' }}">
                <i class="bi bi-graph-up me-3 fs-5"></i>
                <span class="nav-text">Ekonomi</span>
            </a>

            <a href="{{ route('news.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('news.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper me-3 fs-5"></i>
                <span class="nav-text">Berita</span>
            </a>
<!-- Pelabuhan -->

<a href="#"
   class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">

    <i class="bi bi-geo-alt-fill me-3 fs-5"></i>

    <span class="nav-text">Pelabuhan</span>

</a>

<!-- Analisis Risiko -->

<a href="#"
   class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">

    <i class="bi bi-shield-exclamation me-3 fs-5"></i>

    <span class="nav-text">Analisis Risiko</span>

</a>

<!-- Perbandingan Negara -->

<a href="#"
   class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">

    <i class="bi bi-bar-chart-line-fill me-3 fs-5"></i>

    <span class="nav-text">Perbandingan Negara</span>

</a>

<!-- Daftar Pantau -->

<a href="#"
   class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">

    <i class="bi bi-bookmark-star-fill me-3 fs-5"></i>

    <span class="nav-text">Daftar Pantau</span>

</a>

<!-- Dashboard Admin -->

<a href="#"
   class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">

    <i class="bi bi-person-workspace me-3 fs-5"></i>

    <span class="nav-text">Dashboard Admin</span>

</a>
            <a href="#" class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">
                <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                <span class="nav-text">Analisis Risiko</span>
            </a>

            <a href="#" class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">
                <i class="bi bi-star-fill me-3 fs-5"></i>
                <span class="nav-text">Daftar Pantau</span>
            </a>

        </div>

    </div>

    <div class="sidebar-footer p-3 mb-5 border-top border-secondary border-opacity-10">

        <div class="user-card d-flex align-items-center gap-3 p-2 rounded-3 bg-black bg-opacity-20">
            
            <div class="avatar-fallback shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>

            <div class="user-info overflow-hidden">
                <strong class="text-white d-block text-truncate" style="max-width: 130px; font-size: 0.85rem; font-weight: 600;">
                    {{ Auth::user()->name }}
                </strong>
                <small class="text-light-muted d-block text-truncate" style="font-size: 0.75rem;">
                    Administrator
                </small>
            </div>

        </div>

    </div>

</div>

<style>
    /* Styling Dasar Link Menu agar Font Kelihatan Jelas */
    .sidebar .menu .nav-link-custom {
        color: #94a3b8 !important; /* Warna abu-abu terang, sangat kontras di latar gelap */
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }

    /* Efek saat Menu Diarahkan Kursor (Hover) */
    .sidebar .menu .nav-link-custom:hover {
        background-color: rgba(255, 255, 255, 0.05);
        color: #f8fafc !important; /* Menjadi putih terang */
    }

    /* Override paksa untuk menu yang sedang Aktif (Biru sesuai gambar Anda) */
    .sidebar .menu .nav-link-custom.active {
        background-color: #0d6efd !important; /* Warna biru Bootstrap */
        color: #ffffff !important; /* Font putih bersih */
    }

    /* Ketebalan Font Menu */
    .sidebar .nav-text {
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* Warna Teks Administrator di Bagian Bawah */
    .text-light-muted {
        color: #cbd5e1 !important;
    }

    /* Desain Bulatan Avatar Admin */
    .avatar-fallback {
        width: 36px;
        height: 36px;
        background-color: #475569;
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
    }
</style>