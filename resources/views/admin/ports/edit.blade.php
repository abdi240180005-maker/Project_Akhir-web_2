@extends('layouts.master')

@section('content')

<div class="container py-4">

    <div class="card shadow">

        <div class="card-header">

            <h4>✏️ Edit Pelabuhan</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.ports.update',$port) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Nama Pelabuhan</label>

                    <input type="text"
                           name="port_name"
                           value="{{ $port->port_name }}"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Negara</label>

                    <input type="text"
                           name="country"
                           value="{{ $port->country }}"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Kota</label>

                    <input type="text"
                           name="city"
                           value="{{ $port->city }}"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Latitude</label>

                    <input type="text"
                           name="latitude"
                           value="{{ $port->latitude }}"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Longitude</label>

                    <input type="text"
                           name="longitude"
                           value="{{ $port->longitude }}"
                           class="form-control"
                           required>

                </div>

                <button class="btn btn-primary">

                    Simpan Perubahan

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