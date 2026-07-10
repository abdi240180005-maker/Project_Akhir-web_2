<div class="sidebar d-flex flex-column justify-content-between" style="height: 100vh; overflow-y: auto; background-color: #1e293b;">

    <div>
        <div class="logo d-flex align-items-center gap-2 p-3 border-bottom border-secondary border-opacity-10">
            <div class="logo-icon fs-3">🌍</div>
            <div>
                <h6 class="mb-0 fw-bold text-white" style="font-size: 0.85rem; line-height: 1.2; letter-spacing: 0.03em;">
                    RANTAI PASOKAN GLOBAL
                </h6>
                <span class="badge bg-primary text-uppercase mt-1" style="font-size: 0.65rem; padding: 3px 6px; font-weight: 600; letter-spacing: 0.02em;">
                    SISTEM PEMANTAUAN
                </span>
            </div>
        </div>

        <div class="menu mt-4 px-3">

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

            <a href="#"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">
                <i class="bi bi-geo-alt-fill me-3 fs-5"></i>
                <span class="nav-text">Pelabuhan</span>
            </a>

            <a href="{{ route('risk.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('risk.*') ? 'active' : '' }}">
                <i class="bi bi-shield-exclamation me-3 fs-5"></i>
                <span class="nav-text">Analisis Risiko</span>
            </a>

            <a href="{{ route('comparison.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('comparison.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line-fill me-3 fs-5"></i>
                <span class="nav-text">Perbandingan Negara</span>
            </a>

            <a href="{{ route('watchlist.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('watchlist.*') ? 'active' : '' }}">
                <i class="bi bi-bookmark-star-fill me-3 fs-5"></i>
                <span class="nav-text">Daftar Pantau</span>
            </a>

            <a href="#"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">
                <i class="bi bi-person-workspace me-3 fs-5"></i>
                <span class="nav-text">Dashboard Admin</span>
            </a>

        </div>
    </div>

    <div class="sidebar-footer p-3 mb-3 border-top border-secondary border-opacity-10">
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
    /* Styling Menu Navigasi */
    .sidebar .menu .nav-link-custom {
        color: #94a3b8 !important; 
        text-decoration: none;
        position: relative;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Efek Hover Modern: teks sedikit bergeser ke kanan (+3px) */
    .sidebar .menu .nav-link-custom:hover {
        background-color: rgba(255, 255, 255, 0.04);
        color: #f8fafc !important;
        padding-left: 1.25rem !important;
    }

    /* Efek Menu Aktif Lebih Glow & Estetik */
    .sidebar .menu .nav-link-custom.active {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
        font-weight: 600;
    }
    
    .sidebar .menu .nav-link-custom.active i {
        color: #ffffff !important;
    }

    /* Ketebalan Font Menu */
    .sidebar .nav-text {
        font-weight: 500;
        font-size: 0.875rem;
    }

    /* Aturan Elemen Kecil Lainnya */
    .text-light-muted { color: #94a3b8 !important; }

    .avatar-fallback {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #475569 0%, #334155 100%);
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
        border: 1px solid rgba(255,255,255,0.08);
    }
    
    /* Memperbaiki seleksi teks global */
    ::-moz-selection { background-color: #3b82f6 !important; color: #ffffff !important; }
    ::selection { background-color: #3b82f6 !important; color: #ffffff !important; }
</style>