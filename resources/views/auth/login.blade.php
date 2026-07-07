<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body>

    <!-- isi login -->


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

            <div class="text-center mb-5">

                <h2 class="fw-bold">
                    Selamat Datang 👋
                </h2>

                <p class="text-muted">
                    Silakan login 
                </p>

            </div>

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <div class="mb-3">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-lg"
                        required>

                </div>

                <div class="mb-3">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control form-control-lg"
                        required>

                </div>

                <div class="mb-3 form-check">

                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="remember">

                    <label class="form-check-label">

                        Remember Me

                    </label>

                </div>

                <button
                    class="btn btn-primary w-100 btn-lg">

                    LOGIN

                </button>

            </form>

        </div>

    </div>

</div>

</div>

</body>

</html>