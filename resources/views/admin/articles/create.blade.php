@extends('layouts.admin')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                📋 Tambah Analisis
            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.articles.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Judul Analisis
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Negara
                    </label>

                    <input
                        type="text"
                        name="country"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Tingkat Risiko
                    </label>

                    <select
                        name="risk_level"
                        class="form-select"
                        required>

                        <option value="">-- Pilih Risiko --</option>

                        <option value="Rendah">
                            Rendah
                        </option>

                        <option value="Sedang">
                            Sedang
                        </option>

                        <option value="Tinggi">
                            Tinggi
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Kesimpulan
                    </label>

                    <textarea
                        name="conclusion"
                        rows="6"
                        class="form-control"
                        required></textarea>

                </div>

                <button class="btn btn-primary">

                    Simpan Analisis

                </button>

                <a href="{{ route('admin.articles.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection