<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Global Supply Chain</title>
    
    <!-- Bootstrap Icons & Font Awesome (Untuk estetika ikon) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        /* --- PALET WARNA THE CLASSIC LUXURY --- */
        :root {
            --midnight-blue: #0B0C10;
            --slate-blue: #1F2833;
            --metallic-gold: #C5A059;
            --soft-white: #F5F5F7;
        }

        body {
            background-color: var(--midnight-blue);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Desain Sisi Kiri (Premium Dark & Gold Grid) */
        .bg-gradient-hero {
            background: radial-gradient(circle at top left, var(--slate-blue) 0%, var(--midnight-blue) 100%);
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(197, 160, 89, 0.15);
        }

        /* Dekorasi Elemen Abstrak Emas Halus */
        .bg-gradient-hero::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(197, 160, 89, 0.05) 0%, transparent 70%);
            top: -100px;
            left: -100px;
        }

        /* Card Berwarna Emas untuk Ikon */
        .gold-icon-box {
            background: linear-gradient(135deg, rgba(197, 160, 89, 0.1) 0%, rgba(197, 160, 89, 0.2) 100%);
            border: 1px solid rgba(197, 160, 89, 0.3);
            backdrop-filter: blur(10px);
        }

        /* Sisi Kanan / Form Login Layout */
        .login-sidebar {
            background-color: var(--midnight-blue) !important;
        }

        /* Styling Input Form Premium */
        .form-dark-premium {
            background-color: var(--slate-blue) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: var(--soft-white) !important;
        }

        .form-dark-premium:focus {
            border-color: var(--metallic-gold) !important;
            box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.15) !important;
        }

        /* Menyesuaikan label warna teks pada Floating Label Bootstrap */
        .form-floating > .form-dark-premium:focus ~ label,
        .form-floating > .form-dark-premium:not(:placeholder-shown) ~ label {
            color: var(--metallic-gold) !important;
            opacity: 0.8;
        }
        
        .form-floating > label {
            color: rgba(245, 245, 247, 0.5);
        }

        /* Transisi Tombol Login Emas */
        .btn-login {
            background: linear-gradient(135deg, #D4AF37 0%, var(--metallic-gold) 100%);
            border: none;
            color: var(--midnight-blue);
            transition: all 0.3s ease-in-out;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--metallic-gold) 0%, #B38F49 100%);
            color: var(--midnight-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(197, 160, 89, 0.3);
        }

        /* Checkbox Custom Emas */
        .form-check-input:checked {
            background-color: var(--metallic-gold);
            border-color: var(--metallic-gold);
        }
    </style>
</head>

<body>

<div class="container-fluid p-0">
    <div class="row g-0 vh-100">

        <!-- SISI KIRI: Brand & Informasi (Midnight & Gold) -->
        <div class="col-lg-7 d-none d-lg-flex align-items-center justify-content-center bg-gradient-hero text-white p-5">
            <div class="text-center p-4" style="max-width: 550px;">
                <div class="mb-4 d-inline-block p-4 rounded-4 shadow-sm gold-icon-box">
                    <i class="fas fa-globe fa-4x" style="color: var(--metallic-gold);"></i>
                </div>

                <h1 class="fw-extrabold mb-2 tracking-tight" style="font-size: 2.75rem; color: var(--soft-white);">
                    Global Supply Chain
                </h1>

                <h3 class="fw-normal fs-4 mb-4" style="color: var(--metallic-gold); letter-spacing: 1px;">
                    Risk Intelligence System
                </h3>

                <p class="lh-lg" style="font-size: 1.05rem; font-weight: 400; color: rgba(245, 245, 247, 0.7);">
                    Monitoring cuaca, analisis ekonomi, kurs mata uang global, berita logistik, dan deteksi risiko secara <span style="color: var(--metallic-gold); font-weight: 600;">real-time</span> dalam satu dasbor terintegrasi.
                </p>
            </div>
        </div>

        <!-- SISI KANAN: Form Login (Dark Luxury Minimalis) -->
        <div class="col-lg-5 d-flex align-items-center login-sidebar shadow-lg">
            <div class="w-100 px-4 px-md-5 py-5" style="max-width: 480px; margin: 0 auto;">
                
                <!-- Header Form -->
                <div class="mb-4 text-center text-lg-start">
                    <h2 class="fw-bold mb-2" style="color: var(--soft-white);">
                        Selamat Datang 👋
                    </h2>
                    <p class="small" style="color: rgba(245, 245, 247, 0.5);">
                        Silakan masukkan kredensial Anda untuk mengakses sistem pemantauan.
                    </p>
                </div>

                <!-- Alert Validasi Laravel -->
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 p-3 mb-4 small" style="background-color: rgba(220, 53, 69, 0.2); color: #f8d7da;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Input Email dengan Floating Label -->
                    <div class="form-floating mb-3">
                        <input
                            type="email"
                            name="email"
                            id="floatingEmail"
                            class="form-control form-dark-premium rounded-3 @error('email') is-invalid @enderror"
                            placeholder="nama@perusahaan.com"
                            value="{{ old('email') }}"
                            required 
                            autofocus>
                        <label for="floatingEmail" class="small"><i class="bi bi-envelope me-2"></i>Alamat Email</label>
                    </div>

                    <!-- Input Password dengan Floating Label -->
                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            name="password"
                            id="floatingPassword"
                            class="form-control form-dark-premium rounded-3"
                            placeholder="Password"
                            required>
                        <label for="floatingPassword" class="small"><i class="bi bi-lock me-2"></i>Kata Sandi</label>
                    </div>

                    <!-- Opsi Tambahan (Remember Me) -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="remember"
                                id="rememberMe">
                            <label class="form-check-label small" for="rememberMe" style="user-select: none; color: rgba(245, 245, 247, 0.6);">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <!-- Tombol Login Premium (Emas) -->
                    <button type="submit" class="btn w-100 btn-lg btn-login rounded-3 py-2-5 fs-6 shadow-sm">
                        MASUK KE SISTEM <i class="bi bi-arrow-right-short ms-1 fs-5 align-middle"></i>
                    </button>
                </form>

                <!-- Footer Hak Cipta -->
                <div class="mt-5 text-center">
                    <p style="font-size: 0.75rem; color: rgba(245, 245, 247, 0.3);">
                        &copy; 2026 Global Supply Chain Corp. Seluruh Hak Cipta Dilindungi.
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>