@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 fw-bold text-uppercase">Reservation</h1>

        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('admin.reservation.index') }}" class="btn btn-dark w-100 p-4">
                    PERMINTAAN RESERVASI
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.tables.index') }}" class="btn btn-dark w-100 p-4">
                    MANAJEMEN MEJA
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.slots.index') }}" class="btn btn-dark w-100 p-4">
                    MANAJEMEN SLOT WAKTU
                </a>
            </div>
        </div>
    </div>
@endsection
