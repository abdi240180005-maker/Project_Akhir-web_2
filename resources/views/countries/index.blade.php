@extends('layouts.master')

@section('content')

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

@if(session('warning'))

<div class="alert alert-warning">

    {{ session('warning') }}

</div>

@endif

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">🌍 Negara</h2>
            <p class="text-muted mb-0">
                Monitoring data negara di seluruh dunia
            </p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <small class="text-muted fw-semibold text-uppercase d-block mb-1">Total Negara</small>
                        <h2 class="fw-bold mb-0 text-primary">{{ $totalCountries }}</h2>
                    </div>
                    <div class="icon-circle bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-globe2 fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <small class="text-muted fw-semibold text-uppercase d-block mb-1">Asia</small>
                        <h2 class="fw-bold mb-0 text-success">{{ $asiaCountries }}</h2>
                    </div>
                    <div class="icon-circle bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-geo-alt-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <small class="text-muted fw-semibold text-uppercase d-block mb-1">Eropa</small>
                        <h2 class="fw-bold mb-0 text-warning">{{ $europeCountries }}</h2>
                    </div>
                    <div class="icon-circle bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-flag-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form method="GET">
                <div class="row g-2">
                    <div class="col-md-10">
                        <input
                            type="text"
                            name="search"
                            class="form-control py-2"
                            placeholder="Cari Negara..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 h-100 fw-medium">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted">
                    <tr>
                        <th class="ps-4">Bendera</th>
                        <th>Negara</th>
                        <th>Ibu Kota</th>
                        <th>Wilayah</th>
                        <th>Total Populasi</th>
                        <th class="pe-4 text-end" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($countries as $country)
                    <tr>
                        <td class="ps-4" style="font-size:28px; line-height: 1;">
                            {{ $country->flag }}
                        </td>
                        <td>
                            <strong class="text-dark">{{ $country->name }}</strong>
                        </td>
                        <td>
                            {{ $country->capital }}
                        </td>
                        <td>
                            {{ $country->region }}
                        </td>
                        <td class="fw-medium">
                            {{ number_format($country->population, 0, ',', '.') }}
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('countries.show', $country) }}" class="btn btn-info btn-sm text-white rounded-2">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <form
    action="{{ route('countries.monitor', $country) }}"
    method="POST"
    class="d-inline">

    @csrf

    <button
        class="btn btn-success btn-sm">

        <i class="bi bi-plus-circle"></i>

        Monitor

    </button>

</form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Tidak ada data negara.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-transparent border-top p-3 d-flex justify-content-center">
            {{ $countries->links() }}
        </div>
    </div>

</div>
@endsection