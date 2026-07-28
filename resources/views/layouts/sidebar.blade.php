<div class="sidebar d-flex flex-column justify-content-between" style="position: fixed; top: 0; left: 0; width: 270px; height: 100vh; overflow-y: auto; background-color: var(--midnight-blue); border-right: 1px solid rgba(197, 160, 89, 0.15); z-index: 1000;">

    <div>
        <div class="logo d-flex align-items-center gap-3 p-3 border-bottom border-secondary border-opacity-10" style="background-color: var(--slate-blue);">
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

        <div class="menu mt-4 px-3">
            
            @if(Auth::user()->role == 'admin')
                <div class="mb-2 px-2">
                    <div class="menu-title">ADMINISTRASI</div>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 text-warning fw-bold">
                    <i class="bi bi-shield-lock-fill me-3 fs-5 text-warning"></i>
                    <span class="nav-text text-warning">Masuk Panel Admin</span>
                </a>

                <hr style="border-color: rgba(197, 160, 89, 0.15); opacity: 1; margin: 1rem 0;">
            @endif

            <div class="mb-2 px-2">
                <div class="menu-title">UTAMA</div>
            </div>

            <a href="{{ route('dashboard') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2 me-3 fs-5"></i>
                <span class="nav-text">Dashboard Monitoring</span>
            </a>

            <a href="{{ route('watchlist.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('watchlist.*') ? 'active' : '' }}">
                <i class="bi bi-bookmark-star-fill me-3 fs-5"></i>
                <span class="nav-text">Negara Favorit</span>
            </a>

            <div class="mb-2 px-2">
                <div class="menu-title">ANALISIS & RISIKO</div>
            </div>

            <a href="{{ route('countries.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('countries.*') ? 'active' : '' }}">
                <i class="bi bi-globe2 me-3 fs-5"></i>
                <span class="nav-text">Negara</span>
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

            <a href="{{ route('visualisasi.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('visualisasi.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill me-3 fs-5"></i>
                <span class="nav-text">Visualisasi Data</span>
            </a>

            <div class="mb-2 px-2">
                <div class="menu-title">INDIKATOR RANTAI PASOK</div>
            </div>

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

            <a href="{{ route('ports.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->is('ports*') || request()->routeIs('ports.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt-fill me-3 fs-5"></i>
                <span class="nav-text">Pelabuhan</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer p-3 mb-3 border-top border-secondary border-opacity-10">
        <div class="user-card d-flex align-items-center gap-3 p-2 rounded-3" style="background-color: var(--slate-blue); border: 1px solid rgba(255,255,255,0.05);">
            
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
        color: rgba(245, 245, 247, 0.7) !important;
        text-decoration: none;
        position: relative;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
    }

    /* Efek Hover Glassmorphic */
    .sidebar .menu .nav-link-custom:hover {
        background-color: rgba(197, 160, 89, 0.08) !important;
        color: #E5BA73 !important;
        transform: translateX(6px);
    }

    /* Efek Menu Aktif */
    .sidebar .menu .nav-link-custom.active {
        background-color: rgba(197, 160, 89, 0.12) !important;
        color: #E5BA73 !important;
        font-weight: 600;
        border-left: 3px solid #E5BA73;
        border-radius: 0 8px 8px 0 !important;
        box-shadow: 0 4px 15px rgba(197, 160, 89, 0.08);
    }
    
    .sidebar .menu .nav-link-custom.active i {
        color: #E5BA73 !important;
    }

    .sidebar .nav-text {
        font-weight: 500;
        font-size: 0.86rem;
    }

    .avatar-fallback {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #1F2833 0%, #0B0C10 100%);
        color: #E5BA73;
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
        opacity: 0.65;
        font-size: 0.66rem;
        letter-spacing: 0.08em;
        font-weight: 800;
        margin: 20px 10px 6px;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(197, 160, 89, 0.1);
        padding-bottom: 4px;
    }
    
    ::-moz-selection { background-color: #C5A059 !important; color: #0B0C10 !important; }
    ::selection { background-color: #C5A059 !important; color: #0B0C10 !important; }

    .sidebar .menu .nav-link-custom.logout-link:hover {
        background-color: rgba(220, 53, 69, 0.08) !important;
        color: #ff8787 !important;
    }
    .sidebar .menu .nav-link-custom.logout-link:hover i,
    .sidebar .menu .nav-link-custom.logout-link:hover span {
        color: #ff8787 !important;
    }
</style>