<!-- Sisi Kiri / Sidebar Utama (Midnight Blue) -->
<div class="sidebar d-flex flex-column justify-content-between" style="height: 100vh; overflow-y: auto; background-color: #0B0C10; border-right: 1px solid rgba(197, 160, 89, 0.15);">

    <div>
        <!-- Logo Header -->
        <div class="logo d-flex align-items-center gap-3 p-3 border-bottom border-secondary border-opacity-10" style="background-color: #1F2833;">
            <div class="logo-icon">
                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                     style="width:48px; height:48px; background: linear-gradient(135deg, #D4AF37 0%, #C5A059 100%); font-size:22px; box-shadow: 0 0 12px rgba(197, 160, 89, 0.25);">
                    🌍
                </div>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-size:0.88rem; letter-spacing:.04em; line-height: 1.2; color: #F5F5F7;">
                    GLOBAL SUPPLY CHAIN
                </h6>
                <small class="d-block" style="font-size: 0.75rem; color: #C5A059; opacity: 0.85; font-weight: 500;">
                    Risk Intelligence System
                </small>
            </div>
        </div>

        <!-- Menu Navigation -->
        <div class="menu mt-4 px-3">
            
            <!-- ==================== AREA PROTEKSI MENU ADMIN ==================== -->
            <!-- ==================== AREA PROTEKSI MENU ADMIN ==================== -->
@if(Auth::user()->role == 'admin')
    <div class="mb-2 px-2">
        <div class="menu-title">MENU ADMIN</div>
    </div>

    <a href="{{ route('admin.dashboard') }}"
       class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-3 fs-5"></i>
        <span class="nav-text">Dashboard Admin</span>
    </a>

    <!-- KELOLA USER (Rutenya sudah diarahkan ke admin.users.index) -->
    <a href="{{ route('admin.users.index') }}"
       class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="bi bi-people-fill me-3 fs-5"></i>
        <span class="nav-text">Kelola User</span>
    </a>

    <!-- KELOLA ARTIKEL (Rutenya mengarah ke admin.articles.index) -->
    <a href="{{ route('admin.articles.index') }}"
       class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
        <i class="bi bi-newspaper me-3 fs-5"></i>
        <span class="nav-text">Kelola Artikel</span>
    </a>

    <a href="#" class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">
        <i class="bi bi-geo-alt-fill me-3 fs-5"></i>
        <span class="nav-text">Kelola Pelabuhan</span>
    </a>

    <hr style="border-color: rgba(197, 160, 89, 0.15); opacity: 1; margin: 1.5rem 0;">
@endif

            <!-- ==================== MENU MONITORING (SEMUA USER) ==================== -->
            <div class="mb-2 px-2">
                <div class="menu-title">MENU MONITORING</div>
            </div>

            <a href="{{ route('dashboard') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2 me-3 fs-5"></i>
                <span class="nav-text">Dashboard Monitoring</span>
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

            <a href="#" class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">
                <i class="bi bi-anchor me-3 fs-5"></i>
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

        </div>
    </div>

    <!-- Sidebar Footer (Informasi Akun) -->
    <div class="sidebar-footer p-3 mb-3 border-top border-secondary border-opacity-10">
        <div class="user-card d-flex align-items-center gap-3 p-2 rounded-3" style="background-color: #1F2833; border: 1px solid rgba(255,255,255,0.05);">
            
            <div class="avatar-fallback shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>

            <div class="user-info overflow-hidden">
                <strong class="d-block text-truncate" style="max-width: 130px; font-size: 0.85rem; font-weight: 600; color: #F5F5F7;">
                    {{ Auth::user()->name }}
                </strong>
                <small class="d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05em; color: #C5A059;">
                    @if(Auth::user()->role == 'admin')
                        Administrator
                    @else
                        User Monitoring
                    @endif
                </small>
            </div>

        </div>
    </div>

</div>

<style>
    /* Styling Menu Navigasi Normal */
    .sidebar .menu .nav-link-custom {
        color: rgba(245, 245, 247, 0.65) !important;
        text-decoration: none;
        position: relative;
        transition: all 0.25s ease-in-out;
    }

    /* Efek Hover */
    .sidebar .menu .nav-link-custom:hover {
        background-color: #1F2833 !important;
        color: #C5A059 !important;
        padding-left: 1.25rem !important;
    }

    /* Efek Menu Aktif */
    .sidebar .menu .nav-link-custom.active {
        background-color: #1F2833 !important;
        color: #C5A059 !important;
        font-weight: 600;
        border-left: 3px solid #C5A059;
        border-radius: 0 8px 8px 0 !important;
        box-shadow: inset 5px 0 15px rgba(197, 160, 89, 0.05);
    }
    
    .sidebar .menu .nav-link-custom.active i {
        color: #C5A059 !important;
    }

    .sidebar .nav-text {
        font-weight: 500;
        font-size: 0.875rem;
    }

    .avatar-fallback {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #1F2833 0%, #0B0C10 100%);
        color: #C5A059;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
        border: 1px solid rgba(197, 160, 89, 0.3);
    }

    .menu-title {
        color: #C5A059;
        opacity: 0.5;
        font-size: .72rem;
        letter-spacing: .08em;
        font-weight: 700;
        margin: 22px 10px 8px;
        text-transform: uppercase;
    }
    
    ::-moz-selection { background-color: #C5A059 !important; color: #0B0C10 !important; }
    ::selection { background-color: #C5A059 !important; color: #0B0C10 !important; }
</style>