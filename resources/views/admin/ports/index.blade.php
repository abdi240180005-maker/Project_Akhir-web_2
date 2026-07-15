@extends('layouts.master')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                ⚓ Kelola Pelabuhan
            </h2>
            <p class="text-muted mb-0">
                Kelola data pelabuhan untuk monitoring supply chain.
            </p>
            <small class="text-muted">
                Total Pelabuhan : {{ $ports->count() }}
            </small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                Dashboard Admin
            </a>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                📥 Import Dataset
            </button>
            <a href="{{ route('admin.ports.create') }}" class="btn btn-primary">
                ➕ Tambah Pelabuhan
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Pelabuhan</th>
                        <th>Negara</th>
                        <th>Kota</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ports as $port)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $port->port_name }}</td>
                            <td>{{ $port->country }}</td>
                            <td>{{ $port->city }}</td>
                            <td>{{ $port->latitude }}</td>
                            <td>{{ $port->longitude }}</td>
                            <td>
                                <a href="{{ route('admin.ports.edit', $port) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.ports.destroy', $port) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pelabuhan ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada data pelabuhan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.ports.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        Import World Port Index Dataset
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">
                        Pilih File CSV
                    </label>
                    <input type="file" name="file" class="form-control" accept=".csv" required>
                    <small class="text-muted d-block mt-2">
                        Format: port_name, country, city, latitude, longitude
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection