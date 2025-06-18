@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Permintaan Reservasi</h2>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <form action="{{ route('admin.reservation.index') }}" method="GET">
                <input type="date" name="date" class="form-control w-auto d-inline"
                    value="{{ request('date', date('Y-m-d')) }}">
                <button class="btn btn-primary ms-2">Cari</button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-5">
                @foreach ($reservations as $reservation)
                    <div class="card mb-3">
                        <div class="card-body">
                            <strong>{{ $reservation->table_count }} Meja</strong><br>
                            <small>{{ implode(', ', $reservation->slot_time) }}</small><br>
                            <small>{{ $reservation->user->name }} ({{ $reservation->user->email }})</small>
                            <div class="mt-2">
                                <form action="{{ route('admin.reservation.accept', $reservation->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                </form>
                                <form action="{{ route('admin.reservation.reject', $reservation->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-7">
                <h5>Peta Meja</h5>
                <div class="d-flex flex-wrap">
                    @foreach ($tables as $table)
                        <div
                            class="p-2 m-1 border rounded {{ $table->isOccupied($selectedDate, $table->id) ? 'bg-danger text-white' : 'bg-warning' }}">
                            Meja {{ $table->number }}
                            <br><small>{{ $table->slotsOn($selectedDate) }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
