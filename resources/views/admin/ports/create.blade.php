@extends('layouts.master')

@section('content')

<div class="container py-4">

    <div class="card shadow">

        <div class="card-header">

            <h4>⚓ Tambah Pelabuhan</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.ports.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Nama Pelabuhan</label>

                    <input type="text"
                           name="port_name"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Negara</label>

                    <input type="text"
                           name="country"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Kota</label>

                    <input type="text"
                           name="city"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Latitude</label>

                    <input type="text"
                           name="latitude"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Longitude</label>

                    <input type="text"
                           name="longitude"
                           class="form-control"
                           required>

                </div>

                <button class="btn btn-primary">

                    Simpan

                </button>

                <a href="{{ route('admin.ports.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection