@extends('layouts.master')

@section('content')

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                ⭐ Daftar Pantau
            </h2>

            <p class="text-muted mb-0">
                Daftar negara yang sedang dipantau.
            </p>

        </div>

        <div class="text-end">

            <h4 class="fw-bold text-primary">

                {{ $watchlists->total() }}

            </h4>

            <small class="text-muted">

                Negara Dipantau

            </small>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Bendera</th>
                        <th>Negara</th>
                        <th>Ibu Kota</th>
                        <th>Wilayah</th>
                        <th>Mata Uang</th>
                        <th width="180">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($watchlists as $item)

                    <tr>

                        <td>

                            <img
                                src="https://flagcdn.com/32x24/{{ strtolower($item->country_code) }}.png"
                                width="32">

                        </td>

                        <td>

                            <strong>

                                {{ $item->country_name }}

                            </strong>

                        </td>

                        <td>

                            {{ $item->capital }}

                        </td>

                        <td>

                            {{ $item->region }}

                        </td>

                        <td>

                            {{ $item->currency }}

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a
                                    href="{{ route('countries.show',$item->country_code) }}"
                                    class="btn btn-info btn-sm text-white">

                                    Detail

                                </a>

                                <form
                                    action="{{ route('watchlist.destroy',$item) }}"
                                    method="POST">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus dari Daftar Pantau?')">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center py-5">

                            Belum ada negara yang dipantau.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer bg-white">

            {{ $watchlists->links() }}

        </div>

    </div>

</div>

@endsection