@extends('layouts.master')

@push('styles')
<style>
    /* Premium Contemporary Styling */
    .text-slate-400 { color: #94a3b8; }
    .text-slate-500 { color: #64748b; }
    .text-slate-800 { color: #0f172a; }
    .bg-slate-50 { background-color: #f8fafc; }
    .border-slate-100 { border-color: #f1f5f9; }
    
    .card-stat {
        border: 1px solid #f1f5f9 !important;
        border-radius: 1.25rem !important;
        background: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }

    .table-custom {
        background: #ffffff;
        border-radius: 1.25rem !important;
        overflow: hidden;
    }

    .table-custom th {
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #475569;
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
    }

    .table-custom td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.9rem;
    }

    .badge-pill-custom {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 700;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .btn-refresh {
        border: 1px solid #0d6efd;
        color: #0d6efd;
        background: #ffffff;
        border-radius: 9999px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
    }

    .btn-refresh:hover {
        background: #0d6efd;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.15);
    }
    
    .favorite-star {
        color: #eab308;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4 bg-slate-50" style="min-height: 100vh;">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center py-3 px-4 mb-4">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4 pb-2">
        <div>
            <h2 class="fw-bold text-slate-800 mb-1 d-flex align-items-center gap-2">
                <span>⭐</span> Pemantauan Favorit
            </h2>
            <p class="text-slate-500 small mb-0">
                Daftar pantau khusus negara yang Anda prioritas-kan untuk pengawasan logistik rantai pasok
            </p>
        </div>
        <div>
            <button class="btn btn-refresh d-flex align-items-center gap-2" onclick="window.location.reload();">
                <i class="bi bi-arrow-clockwise"></i> Segarkan Data
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-stat border-0 p-4">
                <div class="text-center">
                    <small class="text-slate-500 text-uppercase fw-bold tracking-wider d-block mb-2" style="font-size: 0.75rem;">
                        TOTAL NEGARA DIPANTAU
                    </small>
                    <h1 class="fw-extrabold text-primary mb-0 font-monospace" style="font-size: 2.5rem;">
                        {{ $totalDipantau }}
                    </h1>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stat border-0 p-4">
                <div class="text-center">
                    <small class="text-slate-500 text-uppercase fw-bold tracking-wider d-block mb-2" style="font-size: 0.75rem;">
                        🔴 KATEGORI RISIKO TINGGI
                    </small>
                    <h1 class="fw-extrabold text-danger mb-0 font-monospace" style="font-size: 2.5rem;">
                        {{ $risikoTinggi }}
                    </h1>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stat border-0 p-4">
                <div class="text-center">
                    <small class="text-slate-500 text-uppercase fw-bold tracking-wider d-block mb-2" style="font-size: 0.75rem;">
                        🟢 KATEGORI RISIKO SEDANG & RENDAH
                    </small>
                    <h1 class="fw-extrabold text-success mb-0 font-monospace" style="font-size: 2.5rem;">
                        {{ $risikoSedangRendah }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="card-header bg-white border-0 py-3.5 px-4 border-bottom">
            <h5 class="fw-bold text-slate-800 mb-0 d-flex align-items-center gap-2">
                📝 Daftar Negara Prioritas
            </h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-custom">
                <thead>
                    <tr>
                        <th style="width: 22%;">Negara</th>
                        <th style="width: 18%;" class="text-center">Skor & Tingkat Risiko</th>
                        <th style="width: 18%;" class="text-center">Kondisi Cuaca Saat Ini</th>
                        <th style="width: 12%;" class="text-center">Mata Uang</th>
                        <th style="width: 18%;" class="text-center">Kepadatan Pelabuhan</th>
                        <th style="width: 12%;" class="text-center">Status Pantau</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($watchlists as $item)
                        @php
                            $c = $item->country;
                            $score = $c->risk_score ?? 35;
                            
                            $riskClass = 'bg-secondary text-white';
                            $riskLabel = 'Sedang';
                            if ($score <= 30) {
                                $riskClass = 'bg-success bg-opacity-10 text-success border border-success-subtle';
                                $riskLabel = 'Rendah';
                            } elseif ($score <= 60) {
                                $riskClass = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning-subtle';
                                $riskLabel = 'Sedang';
                            } else {
                                $riskClass = 'bg-danger bg-opacity-10 text-danger border border-danger-subtle';
                                $riskLabel = 'Tinggi';
                            }
                        @endphp
                        <tr>
                            <td class="fw-bold text-slate-800">
                                <div class="d-flex align-items-center gap-2.5">
                                    <img
                                        src="https://flagcdn.com/32x24/{{ strtolower($item->country_code) }}.png"
                                        alt="{{ $item->country_name }}"
                                        class="rounded shadow-sm border border-light"
                                        style="width: 28px; height: auto; object-fit: cover;">
                                    <span>{{ $item->country_name }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge-pill-custom {{ $riskClass }}">
                                    {{ number_format($score, 1, '.', '') }} — {{ $riskLabel }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($item->weather)
                                    <span class="d-inline-flex align-items-center gap-1 fw-medium text-dark">
                                        <span>{{ $item->weather['icon'] }}</span>
                                        <span>{{ $item->weather['condition'] }}</span>
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->currency)
                                    <span class="badge bg-light text-secondary border px-2.5 py-1.5 font-monospace rounded-1">
                                        {{ explode(',', $item->currency)[0] ?? '-' }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge-pill-custom {{ $item->port_congestion_class }}">
                                    {{ $item->port_congestion }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center justify-content-center gap-1.5">
                                    <span class="favorite-star">
                                        ★ Dipantau
                                    </span>
                                    <form action="{{ route('watchlist.destroy', $item) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link text-danger p-0 border-0 fs-7.5 fw-semibold" style="text-decoration: none; font-size: 0.78rem;" onclick="return confirm('Hapus dari Daftar Negara Favorit?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-star d-block fs-3 mb-2 text-slate-400"></i>
                                Belum ada negara favorit yang dipantau.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($watchlists->hasPages())
            <div class="card-footer bg-white border-top border-slate-100 py-3 d-flex justify-content-center">
                {{ $watchlists->links() }}
            </div>
        @endif
    </div>

</div>
@endsection