@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Manajemen Slot Waktu</h2>

        <div class="mb-3 d-flex justify-content-between">
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSlotModal">Tambah Slot
                    Waktu</button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSlotModal">Hapus Slot
                    Waktu</button>
            </div>
            <form method="GET" action="{{ route('admin.slots.index') }}">
                <input type="date" name="date" class="form-control" value="{{ request('date', date('Y-m-d')) }}">
            </form>
        </div>

        <div class="d-flex flex-wrap">
            @foreach ($slots as $slot)
                <div class="border p-3 m-2 rounded bg-light text-center">
                    {{ $slot->start_time }} - {{ $slot->end_time }}
                </div>
            @endforeach
        </div>
    </div>

    @include('admin.slots.partials.modal-add')
    @include('admin.slots.partials.modal-delete')
@endsection
