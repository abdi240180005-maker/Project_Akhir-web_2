<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Global Supply Chain</title>
    
    <!-- Bootstrap Icons & Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        /* --- PALET WARNA ROYAL EMERALD & GOLD --- */
        :root {
            --midnight-blue: #022C22;
            --slate-blue: #064E3B;
            --metallic-gold: #C5A059;
            --soft-white: #F4F6F5;
        }

        body {
            background: radial-gradient(circle at center, rgba(6, 78, 59, 0.5) 0%, rgba(2, 44, 34, 0.95) 100%), 
                        url('https://images.unsplash.com/photo-1569336415962-a4bd9f69cd83?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        /* Glassmorphic Login Card */
        .login-card {
            background: rgba(2, 44, 34, 0.55);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 45px 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4), 
                        0 0 45px rgba(197, 160, 89, 0.15);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.4s ease;
        }

        .login-card:hover {
            transform: translateY(-2px);
            border-color: rgba(197, 160, 89, 0.35);
        }

        /* Gold Icon Box */
        .gold-icon-box {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, rgba(197, 160, 89, 0.12) 0%, rgba(197, 160, 89, 0.25) 100%);
            border: 1px solid rgba(197, 160, 89, 0.35);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            font-size: 2rem;
            color: var(--metallic-gold);
        }

        /* Input Premium Floating Labels */
        .form-dark-premium {
            background-color: rgba(255, 255, 255, 0.06) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: var(--soft-white) !important;
            border-radius: 12px !important;
            height: 58px !important;
            backdrop-filter: blur(5px);
        }

        .form-dark-premium:focus {
            border-color: var(--metallic-gold) !important;
            box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.25) !important;
            background-color: rgba(255, 255, 255, 0.12) !important;
        }

        .form-floating > .form-dark-premium:focus ~ label,
        .form-floating > .form-dark-premium:not(:placeholder-shown) ~ label {
            color: var(--metallic-gold) !important;
            opacity: 0.9;
        }
        
        .form-floating > label {
            color: rgba(244, 246, 245, 0.6);
            padding-left: 16px;
        }

        /* Button Login Custom Gold */
        .btn-login {
            background: linear-gradient(135deg, #D4AF37 0%, var(--metallic-gold) 100%);
            border: none;
            color: #022C22;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            font-weight: 700;
            letter-spacing: 0.06em;
            padding: 14px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(197, 160, 89, 0.2);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--metallic-gold) 0%, #B38F49 100%);
            color: #022C22;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(197, 160, 89, 0.4);
        }

        .btn-login:active {
            transform: translateY(1px);
        }

        /* Checkbox Custom */
        .form-check-input {
            background-color: rgba(6, 78, 59, 0.6);
            border: 1px solid rgba(197, 160, 89, 0.3);
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--metallic-gold);
            border-color: var(--metallic-gold);
        }
    </style>
</head>

<body>

    <div class="login-card">
        <!-- Logo Icon -->
        <div class="gold-icon-box">
            <i class="fas fa-globe-asia"></i>
        </div>

        <!-- Title -->
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1" style="color: var(--soft-white); letter-spacing: -0.5px;">
                Global Supply Chain
            </h2>
            <p class="small text-uppercase fw-semibold mb-2" style="color: var(--metallic-gold); letter-spacing: 2px; font-size: 0.72rem;">
                Risk Intelligence System
            </p>
            <p class="small mb-0" style="color: rgba(244, 246, 245, 0.5);">
                Silakan masuk dengan kredensial terdaftar Anda.
            </p>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-3 p-3 mb-4 small" style="background-color: rgba(220, 53, 69, 0.2); color: #f8d7da; border-left: 4px solid #dc3545 !important;">
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

            <!-- Email Field -->
            <div class="form-floating mb-3">
                <input
                    type="email"
                    name="email"
                    id="floatingEmail"
                    class="form-control form-dark-premium @error('email') is-invalid @enderror"
                    placeholder="nama@perusahaan.com"
                    value="{{ old('email') }}"
                    required 
                    autofocus>
                <label for="floatingEmail" class="small"><i class="bi bi-envelope me-2"></i>Alamat Email</label>
            </div>

            <div style="height: 15px;"></div>

            <!-- Password Field -->
            <div class="form-floating mb-4">
                <input
                    type="password"
                    name="password"
                    id="floatingPassword"
                    class="form-control form-dark-premium"
                    placeholder="Password"
                    required>
                <label for="floatingPassword" class="small"><i class="bi bi-lock me-2"></i>Kata Sandi</label>
            </div>

            <!-- Extra options (Remember Me) -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check d-flex align-items-center gap-2">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="remember"
                        id="rememberMe">
                    <label class="form-check-label small" for="rememberMe" style="user-select: none; color: rgba(244, 246, 245, 0.7); cursor: pointer;">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn w-100 btn-login d-flex align-items-center justify-content-center gap-2">
                MASUK KE SISTEM <i class="bi bi-arrow-right-short fs-5 align-middle"></i>
            </button>
        </form>

        <!-- Copyright Footer -->
        <div class="mt-5 text-center">
            <p style="font-size: 0.72rem; color: rgba(244, 246, 245, 0.35); margin: 0;">
                &copy; 2026 Global Supply Chain Corp. Seluruh Hak Cipta Dilindungi.
            </p>
        </div>
    </div>

</body>
</html>