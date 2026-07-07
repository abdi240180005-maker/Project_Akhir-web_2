<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body>

<div class="container-fluid p-0">

<div class="row g-0 vh-100">

    <!-- KIRI -->

    <div class="col-lg-7 d-none d-lg-flex
        align-items-center
        justify-content-center
        bg-primary
        text-white">

        <div class="text-center">

            <i class="fas fa-globe fa-5x mb-4"></i>

            <h1 class="fw-bold">
                Global Supply Chain
            </h1>

            <h2 class="fw-light">
                Risk Intelligence System
            </h2>

            <p class="mt-4 fs-5">

                Monitoring cuaca, ekonomi,
                kurs mata uang, berita,
                dan risiko global secara realtime.

            </p>

        </div>

    </div>

    <!-- KANAN -->

    <div class="col-lg-5 d-flex align-items-center">

        <div class="w-100 px-5">

            <div class="text-center mb-4">

                <h2 class="fw-bold">
                    Buat Akun Baru
                </h2>

                <p class="text-muted">
                    Silakan isi data di bawah ini
                </p>

            </div>

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form method="POST" action="{{ route('register') }}">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Nama Lengkap

                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control form-control-lg"
                        value="{{ old('name') }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-lg"
                        value="{{ old('email') }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control form-control-lg"
                        required>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Konfirmasi Password

                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control form-control-lg"
                        required>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary btn-lg w-100">

                    DAFTAR

                </button>

            </form>

            <div class="text-center mt-4">

                Sudah punya akun?

                <a href="{{ route('login') }}"
                   class="text-decoration-none fw-bold">

                    Login

                </a>

            </div>

        </div>

    </div>

</div>

</div>

</body>

</html>