@extends('layouts.admin')

@section('content')
<style>
    .form-dark-premium { background-color: #0B0C10 !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; color: #F5F5F7 !important; }
    .form-dark-premium:focus { border-color: #C5A059 !important; box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.15) !important; }
    .input-group-text-dark { background-color: #0B0C10; border: 1px solid rgba(255, 255, 255, 0.1); border-right: none; color: #C5A059; }
    .btn-gold { background: linear-gradient(135deg, #D4AF37 0%, #C5A059 100%); color: #0B0C10; font-weight: 600; border: none; }
    .btn-gold:hover { background: linear-gradient(135deg, #C5A059 0%, #B38F49 100%); color: #0B0C10; transform: translateY(-1px); }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="mb-3">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none small d-inline-flex align-items-center gap-1" style="color: rgba(245, 245, 247, 0.6);">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar User
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-3" style="background-color: #1F2833; border: 1px solid rgba(197, 160, 89, 0.1) !important;">
                <div class="card-header border-bottom-0 pt-4 px-4 pb-2" style="background-color: transparent;">
                    <h4 class="fw-bold d-flex align-items-center gap-2 mb-0" style="color: #F5F5F7;">
                        <i class="bi bi-person-plus-fill" style="color: #C5A059;"></i> Tambah User Baru
                    </h4>
                    <p class="small mb-0 mt-1" style="color: rgba(245, 245, 247, 0.5);">Daftarkan pengguna baru ke dalam sistem intelijen.</p>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold small" style="color: rgba(245, 245, 247, 0.7);">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control form-dark-premium ps-2" required placeholder="Masukkan nama">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small" style="color: rgba(245, 245, 247, 0.7);">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control form-dark-premium ps-2" required placeholder="name@example.com">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small" style="color: rgba(245, 245, 247, 0.7);">Password</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" class="form-control form-dark-premium ps-2" required placeholder="Buat kata sandi">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small" style="color: rgba(245, 245, 247, 0.7);">Hak Akses (Role)</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-shield-lock"></i></span>
                                <select name="role" class="form-select form-dark-premium ps-2">
                                    <option value="user">User (Pengguna Biasa)</option>
                                    <option value="admin">Admin (Administrator)</option>
                                </select>
                            </div>
                        </div>

                        <hr style="border-color: rgba(197, 160, 89, 0.2); margin: 1.5rem 0;">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn px-4" style="border: 1px solid rgba(245, 245, 247, 0.2); color: #F5F5F7;">Batal</a>
                            <button type="submit" class="btn btn-gold px-4 d-inline-flex align-items-center gap-2">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection