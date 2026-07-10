@extends('layouts.master')

@section('content')

<div class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold">
            ⚖️ Perbandingan Negara
        </h2>

        <p class="text-muted">
            Membandingkan kondisi ekonomi dua negara.
        </p>
    </div>

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-5">

                        <label class="form-label fw-bold">

                            Negara Pertama

                        </label>

                        <select
                            name="country1"
                            class="form-select">

                            @foreach($countries as $country)

                            <option
                                value="{{ $country->id }}"
                                {{ $country1 && $country1->id == $country->id ? 'selected' : '' }}>

                                {{ $country->flag }}
                                {{ $country->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-5">

                        <label class="form-label fw-bold">

                            Negara Kedua

                        </label>

                        <select
                            name="country2"
                            class="form-select">

                            @foreach($countries as $country)

                            <option
                                value="{{ $country->id }}"
                                {{ $country2 && $country2->id == $country->id ? 'selected' : '' }}>

                                {{ $country->flag }}
                                {{ $country->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2 d-flex align-items-end">

                        <button
                            class="btn btn-primary w-100">

                            Bandingkan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white fw-bold">

            Hasil Perbandingan

        </div>

        <div class="table-responsive">

            <table class="table table-bordered align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Informasi</th>

                        <th class="text-center">

                            {{ $country1->name }}

                        </th>

                        <th class="text-center">

                            {{ $country2->name }}

                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>💰 GDP</td>

                        <td>

                            US$

                            {{ number_format($data1['gdp'] ?? 0,0,',','.') }}

                        </td>

                        <td>

                            US$

                            {{ number_format($data2['gdp'] ?? 0,0,',','.') }}

                        </td>

                    </tr>

                    <tr>

                        <td>📈 Inflasi</td>

                        <td>

                            {{ $data1['inflation'] ? number_format($data1['inflation'],2) : '-' }} %

                        </td>

                        <td>

                            {{ $data2['inflation'] ? number_format($data2['inflation'],2) : '-' }} %

                        </td>

                    </tr>

                    <tr>

                        <td>💵 Mata Uang</td>

                        <td>

                            {{ $data1['currency'] }}

                        </td>

                        <td>

                            {{ $data2['currency'] }}

                        </td>

                    </tr>

                    <tr>

                        <td>🏛️ Ibu Kota</td>

                        <td>

                            {{ $data1['capital'] }}

                        </td>

                        <td>

                            {{ $data2['capital'] }}

                        </td>

                    </tr>

                    <tr>

                        <td>🌍 Wilayah</td>

                        <td>

                            {{ $data1['region'] }}

                        </td>

                        <td>

                            {{ $data2['region'] }}

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="card shadow-sm border-0 mt-4">

        <div class="card-header bg-white fw-bold">

            📊 Grafik Perbandingan GDP

        </div>

        <div class="card-body">

            <div style="height:350px">

                <canvas id="comparisonChart"></canvas>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded',function(){

new Chart(

document.getElementById('comparisonChart'),

{

type:'bar',

data:{

labels:[

'{{ $country1->name }}',

'{{ $country2->name }}'

],

datasets:[{

label:'GDP',

data:[

{{ $data1['gdp'] ?? 0 }},

{{ $data2['gdp'] ?? 0 }}

],

borderWidth:1

}]

},

options:{

responsive:true,

maintainAspectRatio:false

}

}

);

});

</script>

@endpush