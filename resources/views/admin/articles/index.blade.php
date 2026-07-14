@extends('layouts.master')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                📰 Kelola Artikel
            </h2>

            <p class="text-muted mb-0">
                Kelola seluruh artikel analisis sistem.
            </p>

            <small class="text-muted">
                Total Artikel : {{ $articles->count() }}
            </small>

        </div>

        <div>

            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-secondary">

                Dashboard Admin

            </a>

            <a href="{{ route('admin.articles.create') }}"
               class="btn btn-primary">

                Tambah Artikel

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

                        <th>Judul</th>

                        <th>Kategori</th>

                        <th>Penulis</th>

                        <th>Dibuat</th>

                        <th width="170">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($articles as $article)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $article->title }}</td>

                        <td>{{ $article->category }}</td>

                        <td>{{ $article->author }}</td>

                        <td>{{ $article->created_at->format('d M Y') }}</td>

                        <td>

                            <a href="{{ route('admin.articles.edit',$article) }}"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <form
                                action="{{ route('admin.articles.destroy',$article) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus artikel ini?')">

                                    Hapus

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            Belum ada artikel.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection