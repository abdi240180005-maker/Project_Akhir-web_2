@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            🌦 Weather Monitoring
        </h2>

        <p class="text-muted mb-0">
            Real-time weather monitoring around the world
        </p>

    </div>

</div>

<!-- SEARCH -->

<div class="card shadow-sm mb-4">

    <div class="card-body">

        <form method="GET"
              action="{{ route('weather.index') }}">

            <div class="row">

                <div class="col-md-10">

                    <select
                        class="form-select form-select-lg"
                        name="country">

                        @foreach($countries as $c)

                        <option
                            value="{{ $c->id }}"
                            {{ $country && $country->id==$c->id ? 'selected' : '' }}>

                            {{ $c->flag }}
                            {{ $c->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-2">

                    <button
                        class="btn btn-primary btn-lg w-100">

                        Cari

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@if($country && !empty($weather))

<div class="row g-4">

    <!-- TEMPERATURE -->

    <div class="col-xl-3 col-md-6">

        <div class="card">

            <div class="card-body text-center">

                <div class="display-3">

                    🌡️

                </div>

                <small class="text-muted">

                    Temperature

                </small>

                <h1 class="fw-bold text-primary">

                    {{ $weather['current']['temperature_2m'] }}°C

                </h1>

            </div>

        </div>

    </div>

    <!-- HUMIDITY -->

    <div class="col-xl-3 col-md-6">

        <div class="card">

            <div class="card-body text-center">

                <div class="display-3">

                    💧

                </div>

                <small class="text-muted">

                    Humidity

                </small>

                <h1 class="fw-bold">

                    {{ $weather['current']['relative_humidity_2m'] }}%

                </h1>

            </div>

        </div>

    </div>

    <!-- WIND -->

    <div class="col-xl-3 col-md-6">

        <div class="card">

            <div class="card-body text-center">

                <div class="display-3">

                    🌬️

                </div>

                <small class="text-muted">

                    Wind

                </small>

                <h1 class="fw-bold">

                    {{ $weather['current']['wind_speed_10m'] }}

                </h1>

                <small>

                    km/h

                </small>

            </div>

        </div>

    </div>

    <!-- COUNTRY -->

    <div class="col-xl-3 col-md-6">

        <div class="card">

            <div class="card-body text-center">

                <div style="font-size:60px">

                    {{ $country->flag }}

                </div>

                <h4 class="fw-bold">

                    {{ $country->name }}

                </h4>

                <small class="text-muted">

                    {{ $country->capital }}

                </small>

            </div>

        </div>

    </div>

</div>

<!-- MAP -->

<div class="card mt-4">

    <div class="card-header bg-white fw-bold">

        🗺️ Location Map

    </div>

    <div class="card-body p-0">

        <div id="weatherMap"
             style="height:500px;"></div>

    </div>

</div>

<!-- FORECAST -->

<div class="card mt-4">

    <div class="card-header bg-white fw-bold">

        📅 7 Days Forecast

    </div>

    <div class="card-body">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Date</th>

                    <th>Maximum</th>

                    <th>Minimum</th>

                </tr>

            </thead>

            <tbody>

                @foreach($weather['daily']['time'] as $i=>$date)

                <tr>

                    <td>

                        {{ $date }}

                    </td>

                    <td>

                        <span class="badge bg-danger">

                            {{ $weather['daily']['temperature_2m_max'][$i] }}°C

                        </span>

                    </td>

                    <td>

                        <span class="badge bg-primary">

                            {{ $weather['daily']['temperature_2m_min'][$i] }}°C

                        </span>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endif

@endsection

@push('scripts')

<script>

window.addEventListener('load', function () {

    @if($country)

    const map = L.map('weatherMap',{

        zoomControl:true

    }).setView(

        [

            {{ $country->latitude }},

            {{ $country->longitude }}

        ],

        5

    );

    L.tileLayer(

        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',

        {

            attribution:'© OpenStreetMap',

            maxZoom:19

        }

    ).addTo(map);

    const marker = L.marker(

        [

            {{ $country->latitude }},

            {{ $country->longitude }}

        ]

    ).addTo(map);

    marker.bindPopup(

        `

        <div style="text-align:center">

            <h5>{{ $country->flag }} {{ $country->name }}</h5>

            <hr>

            <b>Capital :</b> {{ $country->capital }}<br>

            <b>Temperature :</b> {{ $weather['current']['temperature_2m'] }} °C<br>

            <b>Humidity :</b> {{ $weather['current']['relative_humidity_2m'] }} %<br>

            <b>Wind :</b> {{ $weather['current']['wind_speed_10m'] }} km/h

        </div>

        `

    ).openPopup();

    setTimeout(function(){

        map.invalidateSize();

    },300);

    @endif

});

</script>

@endpush