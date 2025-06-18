@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Manajemen Meja</h2>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTableModal">Tambah Meja</button>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTableModal">Edit Meja</button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTableModal">Hapus Meja</button>
            </div>
            <form method="GET" action="{{ route('admin.tables.index') }}">
                <input type="date" name="date" class="form-control" value="{{ request('date', date('Y-m-d')) }}">
            </form>
        </div>

        <div class="row">
            @foreach ($tables as $table)
                <div class="col-md-3 mb-3">
                    <div class="card {{ $table->status ? 'bg-success text-white' : 'bg-warning' }}">
                        <div class="card-body text-center">
                            <h5>Meja Nomor {{ $table->number }}</h5>
                            <p>{{ $table->status ? 'Tersedia' : 'Tidak Tersedia' }}</p>
                            <small>{{ $table->seat_count }} Kursi</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('admin.tables.partials.modal-add')
    @include('admin.tables.partials.modal-edit')
    @include('admin.tables.partials.modal-delete')
@endsection
