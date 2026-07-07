@extends('layouts.master')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold">
        Dashboard
    </h2>

    <p class="text-muted">
        Welcome back, {{ Auth::user()->name }}
    </p>

</div>

<div class="row g-4">

    <div class="col-xl-3 col-md-6">

        <div class="card">

            <div class="card-body d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Countries
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $totalCountries }}
                    </h2>

                    <small class="text-success">
                        +5 Today
                    </small>

                </div>

                <div class="display-5">
                    🌍
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card">

            <div class="card-body d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Weather Alert
                    </small>

                    <h2 class="fw-bold mt-2">
                        12
                    </h2>

                    <small class="text-warning">
                        Warning
                    </small>

                </div>

                <div class="display-5">
                    🌦
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card">

            <div class="card-body d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        News
                    </small>

                    <h2 class="fw-bold mt-2">
                        28
                    </h2>

                    <small class="text-primary">
                        Updated
                    </small>

                </div>

                <div class="display-5">
                    📰
                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card">

            <div class="card-body d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        High Risk
                    </small>

                    <h2 class="fw-bold mt-2">
                        4
                    </h2>

                    <small class="text-danger">
                        Critical
                    </small>

                </div>

                <div class="display-5">
                    ⚠
                </div>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header bg-white fw-bold">

                🗺️ Global Monitoring Map

            </div>

            <div class="card-body">

                <div id="worldMap"
                    style="height:620px;border-radius:15px;"></div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card mb-4">

            <div class="card-header bg-white fw-bold">

                🌦 Weather

            </div>

            <div class="card-body">

                <h4>Indonesia</h4>

                <h2>31°C</h2>

                <p>Cerah</p>

                <hr>

                <p>Humidity : 80%</p>

                <p>Wind : 15 km/h</p>

            </div>

        </div>

        <div class="card">

            <div class="card-header bg-white fw-bold">

                📰 Latest News

            </div>

            <div class="card-body">

                <ul class="list-group list-group-flush">

                    <li class="list-group-item">
                        Konflik Laut Merah...
                    </li>

                    <li class="list-group-item">
                        Nilai Yen turun...
                    </li>

                    <li class="list-group-item">
                        Harga minyak naik...
                    </li>

                    <li class="list-group-item">
                        Badai Jepang...
                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-lg-6">

        <div class="card">

            <div class="card-header bg-white fw-bold">

                📊 Currency Chart

            </div>

            <div class="card-body">

                <canvas id="currencyChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="card">

            <div class="card-header bg-white fw-bold">

                📈 Risk Analysis

            </div>

            <div class="card-body">

                <canvas id="riskChart"></canvas>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded',function(){

    const map=L.map('worldMap').setView([20,0],2);

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom:18,
            attribution:'© OpenStreetMap'
        }
    ).addTo(map);

    const countries=[

        {
            name:'Indonesia',
            lat:-6.2088,
            lng:106.8456
        },

        {
            name:'Japan',
            lat:35.6762,
            lng:139.6503
        },

        {
            name:'Singapore',
            lat:1.3521,
            lng:103.8198
        },

        {
            name:'Germany',
            lat:52.5200,
            lng:13.4050
        }

    ];

    countries.forEach(country=>{

        L.marker([country.lat,country.lng])

            .addTo(map)

            .bindPopup(
                "<b>"+country.name+"</b>"
            );

    });

});

</script>

@endpush