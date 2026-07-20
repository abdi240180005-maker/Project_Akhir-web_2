<div class="sidebar d-flex flex-column justify-content-between" style="height: 100vh; overflow-y: auto; background-color: var(--midnight-blue); border-right: 1px solid rgba(197, 160, 89, 0.15);">

    <div>
        <div class="logo d-flex align-items-center gap-3 p-3 border-bottom border-secondary border-opacity-10" style="background-color: var(--slate-blue);">
            <div class="logo-icon">
                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                     style="width:48px; height:48px; background: linear-gradient(135deg, #D4AF37 0%, #C5A059 100%); font-size:22px; box-shadow: 0 0 12px rgba(197, 160, 89, 0.25);">
                    🛡️
                </div>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-size:0.88rem; letter-spacing:.04em; line-height: 1.2; color: #F5F5F7;">
                    RISK INTEL
                </h6>
                <small class="d-block" style="font-size: 0.75rem; color: #C5A059; opacity: 0.85; font-weight: 500;">
                    Admin Panel
                </small>
            </div>
        </div>

        <div class="menu mt-4 px-3">
            <div class="mb-2 px-2">
                <div class="menu-title">MENU UTAMA</div>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-3 fs-5"></i>
                <span class="nav-text">Dashboard</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-3 fs-5"></i>
                <span class="nav-text">Kelola User</span>
            </a>

            <a href="{{ route('admin.ports.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('admin.ports.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt-fill me-3 fs-5"></i>
                <span class="nav-text">Kelola Dataset Pelabuhan</span>
            </a>

            <a href="{{ route('admin.articles.index') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3 {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper me-3 fs-5"></i>
                <span class="nav-text">Kelola Artikel Analisis</span>
            </a>

            <div class="mb-2 px-2 mt-4">
                <div class="menu-title">NAVIGASI PENGGUNA</div>
            </div>

            <a href="{{ route('dashboard') }}"
               class="nav-link-custom d-flex align-items-center py-2 px-3 my-1 rounded-3">
                <i class="bi bi-arrow-left-circle me-3 fs-5"></i>
                <span class="nav-text">Kembali ke Dashboard User</span>
            </a>

            <hr style="border-color: rgba(197, 160, 89, 0.15); opacity: 1; margin: 1.5rem 0;">

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
               class="nav-link-custom logout-link d-flex align-items-center py-2 px-3 my-1 rounded-3 text-danger">
                <i class="bi bi-box-arrow-right me-3 fs-5 text-danger"></i>
                <span class="nav-text text-danger">Logout</span>
            </a>
            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
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
                <small class="d-block text-uppercase fw-bold text-truncate" style="font-size: 0.65rem; letter-spacing: 0.05em; color: #C5A059;">
                    Administrator
                </small>
            </div>
        </div>
    </div>

</div>

<style>
    .sidebar .menu .nav-link-custom {
        color: rgba(245, 245, 247, 0.7) !important;
        text-decoration: none;
        position: relative;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
    }

    .sidebar .menu .nav-link-custom:hover {
        background-color: rgba(197, 160, 89, 0.08) !important;
        color: #E5BA73 !important;
        transform: translateX(6px);
    }

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
        background: linear-gradient(135deg, #111827 0%, #0b0f19 100%);
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
</style>
