@extends('layouts.master')

@section('content')
<style>
    /* JUDUL UTAMA & DESKRIPSI (Diubah menjadi gelap agar kontras dengan background putih halaman web) */
    .text-judul-utama {
        color: #0B0C10 !important;
        font-weight: 700 !important;
    }

    .text-deskripsi-header {
        color: #4A4B4C !important; /* Abu-abu gelap agar terbaca jelas di background putih */
    }

    /* Mengubah warna header tabel menjadi Midnight Black & Emas */
    .table thead th {
        background-color: #0B0C10 !important;
        color: #C5A059 !important;
        font-weight: 700 !important;
        border-bottom: 2px solid rgba(197, 160, 89, 0.3) !important;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        padding: 12px !important;
    }

    /* Mengubah baris body tabel menjadi Slate Blue Gelap agar tulisan putih terlihat jelas */
    .table tbody tr {
        background-color: #1F2833 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    /* Memastikan teks di dalam sel tabel tetap kontras abu-abu terang */
    .table tbody td {
        background-color: #1F2833 !important;
        color: #E5E5E7 !important;
        padding: 14px 12px !important;
    }

    /* Khusus untuk teks Nama User agar putih tegas di dalam tabel gelap */
    .text-nama-user {
        color: #FFFFFF !important;
        font-weight: 600 !important;
    }

    /* Khusus untuk teks Email User agar abu-abu kontras di dalam tabel gelap */
    .text-email-user {
        color: #C5C6C7 !important;
    }
    
    /* Tombol Aksi Kustom Kontras Gelap */
    .btn-outline-gold { 
        border: 1px solid #C5A059 !important; 
        color: #C5A059 !important; 
        background: transparent !important; 
    }
    .btn-outline-gold:hover { 
        background-color: #C5A059 !important; 
        color: #0B0C10 !important; 
    }
    .btn-outline-red { 
        border: 1px solid rgba(220, 53, 69, 0.6) !important; 
        color: #ff6b6b !important; 
        background: transparent !important; 
    }
    .btn-outline-red:hover { 
        background-color: #dc3545 !important; 
        color: #fff !important; 
    }
    .btn-gold { 
        background: linear-gradient(135deg, #D4AF37 0%, #C5A059 100%) !important; 
        color: #0B0C10 !important; 
        font-weight: 600 !important; 
        border: none !important; 
    }
    .btn-gold:hover { 
        background: linear-gradient(135deg, #C5A059 0%, #B38F49 100%) !important; 
        color: #0B0C10 !important;
    }
    
    /* Badges Role */
    .badge-admin { background-color: rgba(220, 53, 69, 0.15) !important; border: 1px solid rgba(220, 53, 69, 0.3) !important; color: #ff6b6b !important; padding: 6px 12px; }
    .badge-user { background-color: rgba(197, 160, 89, 0.1) !important; border: 1px solid rgba(197, 160, 89, 0.3) !important; color: #C5A059 !important; padding: 6px 12px; }
</style>

<div class="container py-5">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="d-flex align-items-center gap-2 mb-1 text-judul-utama">
                <i class="bi bi-people-fill" style="color: #C5A059 !important;"></i> Kelola User
            </h2>
            <p class="mb-0 text-deskripsi-header">
                Daftar seluruh pengguna sistem yang terdaftar. 
                <span class="badge border ms-2" style="background-color: #1F2833 !important; color: #F5F5F7 !important; border-color: rgba(255,255,255,0.1) !important;">Total: {{ $users->count() }} User</span>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn d-inline-flex align-items-center gap-2" style="background-color: #1F2833 !important; border: 1px solid rgba(255,255,255,0.1) !important; color: #F5F5F7 !important;">
                <i class="bi bi-arrow-left"></i> Dashboard Admin
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-gold d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Tambah User
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: rgba(25, 135, 84, 0.15) !important; border-left: 4px solid #198754 !important; color: #d1e7dd !important;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: rgba(220, 53, 69, 0.15) !important; border-left: 4px solid #dc3545 !important; color: #f8d7da !important;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0 rounded-3" style="background-color: #1F2833 !important; border: 1px solid rgba(197, 160, 89, 0.15) !important; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="80">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th width="140">Role</th>
                            <th class="pe-4" width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4 fw-medium" style="color: #C5C6C7 !important;">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="text-nama-user">{{ $user->name }}</div>
                                </td>
                                <td>
                                    <div class="text-email-user">{{ $user->email }}</div>
                                </td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge badge-admin rounded-pill small">
                                            <i class="bi bi-shield-lock-fill me-1"></i> Admin
                                        </span>
                                    @else
                                        <span class="badge badge-user rounded-pill small">
                                            <i class="bi bi-person me-1"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-gold d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        
                                        @if($user->id != auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-red d-inline-flex align-items-center gap-1" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="small fst-italic" style="color: #C5A059 !important; display: flex; align-items: center;">Sesi Aktif</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5" style="color: #A9AHB3 !important;">
                                    <i class="bi bi-folder-x display-6 mb-2 d-block"></i>
                                    Belum ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection