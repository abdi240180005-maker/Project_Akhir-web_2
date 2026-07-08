@extends('layouts.master')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">
        🌍 Pemantauan Ekonomi
    </h2>
    <p class="text-muted">
        Data ekonomi berdasarkan API Bank Dunia
    </p>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('economy.index') }}">
            <div class="row align-items-center">
                <div class="col-md-10 mb-2 mb-md-0">
                    <select name="country" class="form-select">
                        @foreach($countries as $c)
                        <option value="{{ $c->id }}" {{ $country && $country->id == $c->id ? 'selected' : '' }}>
                            {{ $c->flag }} {{ $c->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@if($country)

<div class="row g-4">
    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="display-4 mb-2">💰</div>
                <h6 class="text-muted fw-bold text-uppercase small">PDB (GDP)</h6>
                <h5 class="fw-bold text-primary mb-0">
                    {{ number_format($economy['value'] ?? 0, 0, ',', '.') }}
                </h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="display-4 mb-2">🌍</div>
                <h6 class="text-muted fw-bold text-uppercase small">Negara</h6>
                <h5 class="fw-bold mb-0">
                    {{ $country->name }}
                </h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="display-4 mb-2">🏛️</div>
                <h6 class="text-muted fw-bold text-uppercase small">Ibu Kota</h6>
                <h5 class="fw-bold mb-0">
                    {{ $country->capital }}
                </h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="display-4 mb-2">🌎</div>
                <h6 class="text-muted fw-bold text-uppercase small">Wilayah</h6>
                <h5 class="fw-bold mb-0">
                    {{ $country->region }}
                </h5>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-white fw-bold py-3">
        📊 Grafik PDB (GDP)
    </div>
    <div class="card-body">
        <div style="position: relative; height: 300px; w-100">
            <canvas id="gdpChart" height="120"></canvas>
        </div>
    </div>
</div>

@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($country)
    
    new Chart(
        document.getElementById('gdpChart'),
        {
            type: 'bar',
            data: {
                labels: ['PDB (GDP)'],
                datasets: [{
                    label: 'PDB',
                    data: [{{ $economy['value'] ?? 0 }}],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    );
    
    @endif
});
</script>
@endpush