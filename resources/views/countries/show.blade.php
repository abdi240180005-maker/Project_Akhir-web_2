@extends('layouts.master')

@section('content')

<div class="card">

    <div class="card-header">

        <h3>{{ $country->name }}</h3>

    </div>

    <div class="card-body">

        <h1 style="font-size:80px">
            {{ $country->flag }}
        </h1>

        <table class="table">

            <tr>
                <th>Country</th>
                <td>{{ $country->name }}</td>
            </tr>

            <tr>
                <th>Capital</th>
                <td>{{ $country->capital }}</td>
            </tr>

            <tr>
                <th>Region</th>
                <td>{{ $country->region }}</td>
            </tr>

            <tr>
                <th>Sub Region</th>
                <td>{{ $country->subregion }}</td>
            </tr>

            <tr>
                <th>Currency</th>
                <td>{{ $country->currency }}</td>
            </tr>

            <tr>
                <th>Population</th>
                <td>{{ number_format($country->population) }}</td>
            </tr>

        </table>

        <a href="{{ route('countries.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

@endsection