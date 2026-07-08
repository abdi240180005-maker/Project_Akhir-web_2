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
        /* Desain Gradient Estetik untuk Sisi Kiri */
        .bg-gradient-hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #0d6efd 50%, #2563eb 100%);
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi Elemen Abstrak di Background */
        .bg-gradient-hero::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            top: -50px;
            left: -50px;
        }

        /* Efek Fokus Halus pada Input */
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        /* Transisi Tombol */
        .btn-login {
            background-color: #2563eb;
            border: none;
            transition: all 0.2s ease-in-out;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>

<body class="bg-light">

<div class="container-fluid p-0">
    <div class="row g-0 vh-100">

        <!-- SISI KIRI: Brand & Informasi (Estetik & Berkelas) -->
        <div class="col-lg-7 d-none d-lg-flex align-items-center justify-content-center bg-gradient-hero text-white p-5">
            <div class="text-center style-card p-4" style="max-width: 550px;">
                <div class="mb-4 bg-white bg-opacity-10 d-inline-block p-4 rounded-4 shadow-sm backdrop-blur">
                    <i class="fas fa-globe fa-4x text-white animate-bounce"></i>
                </div>

                <h1 class="fw-extrabold text-white mb-2 tracking-tight" style="font-size: 2.75rem;">
                    Global Supply Chain
                </h1>

                <h3 class="fw-normal text-white-50 fs-4 mb-4">
                    Risk Intelligence System
                </h3>

                <p class="text-white-50 lh-lg" style="font-size: 1.05rem; font-weight: 400;">
                    Monitoring cuaca, analisis ekonomi, kurs mata uang global, berita logistik, dan deteksi risiko secara <span class="text-white fw-bold">real-time</span> dalam satu dasbor terintegrasi.
                </p>
            </div>
        </div>

        <!-- SISI KANAN: Form Login (Bersih, Putih Minimalis) -->
        <div class="col-lg-5 d-flex align-items-center bg-white shadow-lg">
            <div class="w-100 px-4 px-md-5 py-5" style="max-width: 480px; margin: 0 auto;">
                
                <!-- Header Form -->
                <div class="mb-4 text-center text-lg-start">
                    <h2 class="fw-bold text-dark mb-2">
                        Selamat Datang 👋
                    </h2>
                    <p class="text-muted small">
                        Silakan masukkan kredensial Anda untuk mengakses sistem pemantauan.
                    </p>
                </div>

                <!-- Alert Validasi Laravel (Jika Email/Password Salah) -->
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 p-3 mb-4 small">
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
                            class="form-control rounded-3 @error('email') is-invalid @enderror"
                            placeholder="nama@perusahaan.com"
                            value="{{ old('email') }}"
                            required 
                            autofocus>
                        <label for="floatingEmail" class="text-muted small"><i class="bi bi-envelope me-2"></i>Alamat Email</label>
                    </div>

                    <!-- Input Password dengan Floating Label -->
                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            name="password"
                            id="floatingPassword"
                            class="form-control rounded-3"
                            placeholder="Password"
                            required>
                        <label for="floatingPassword" class="text-muted small"><i class="bi bi-lock me-2"></i>Kata Sandi</label>
                    </div>

                    <!-- Opsi Tambahan (Remember Me & Lupa Password) -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="remember"
                                id="rememberMe">
                            <label class="form-check-label text-secondary small" for="rememberMe" style="user-select: none;">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <!-- Tombol Login Premium -->
                    <button type="submit" class="btn btn-primary w-100 btn-lg btn-login rounded-3 py-2-5 fs-6 shadow-sm">
                        MASUK KE SISTEM <i class="bi bi-arrow-right-short ms-1 fs-5 align-middle"></i>
                    </button>
                </form>

                <!-- Footer Hak Cipta -->
                <div class="mt-5 text-center">
                    <p class="text-muted" style="font-size: 0.75rem;">
                        &copy; 2026 Global Supply Chain Corp. Seluruh Hak Cipta Dilindungi.
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>