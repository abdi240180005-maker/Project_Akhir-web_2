@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            🌍 Countries
        </h2>

        <p class="text-muted">
            Monitoring data negara di seluruh dunia
        </p>

    </div>

</div>

<!-- Statistik -->

<div class="row g-4 mb-4">

    <div class="col-lg-4">

        <div class="card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-muted">
                        Total Countries
                    </small>

                    <h2 class="fw-bold">
                        {{ $totalCountries }}
                    </h2>

                </div>

                <div class="icon-circle bg-primary">

                    <i class="bi bi-globe2"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-muted">
                        Asia
                    </small>

                    <h2 class="fw-bold">
                        {{ $asiaCountries }}
                    </h2>

                </div>

                <div class="icon-circle bg-success">

                    <i class="bi bi-geo-alt-fill"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-muted">
                        Europe
                    </small>

                    <h2 class="fw-bold">
                        {{ $europeCountries }}
                    </h2>

                </div>

                <div class="icon-circle bg-warning">

                    <i class="bi bi-flag-fill"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Search -->

<div class="card mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-10">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari Negara..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-md-2">

                    <button class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>

                        Cari

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- Table -->

<div class="card">

    <div class="card-body">

        <table class="table table-hover align-middle">

            <thead class="table-light">

                <tr>

                    <th>Flag</th>
                    <th>Country</th>
                    <th>Capital</th>
                    <th>Region</th>
                    <th>Population</th>
                    <th width="160">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($countries as $country)

                <tr>

                    <td style="font-size:28px">
                        {{ $country->flag }}
                    </td>

                    <td>

                        <strong>

                            {{ $country->name }}

                        </strong>

                    </td>

                    <td>

                        {{ $country->capital }}

                    </td>

                    <td>

                        {{ $country->region }}

                    </td>

                    <td>

                        {{ number_format($country->population) }}

                    </td>

                    <td>

                        <button
                            class="btn btn-info btn-sm">

                            <i class="bi bi-eye"></i>

                            Detail

                        </button>

                        <button
                            class="btn btn-success btn-sm">

                            <i class="bi bi-plus-circle"></i>

                            Monitor

                        </button>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">

                        Tidak ada data negara.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-3">

            {{ $countries->links() }}

        </div>

    </div>

</div>

@endsection