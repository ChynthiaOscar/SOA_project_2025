@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3 class="mb-3">Terima Reservasi</h3>

        <div class="card p-3">
            <h5>{{ $reservation->table_count }} Meja</h5>
            <p>
                Slot waktu:<br>
                @foreach ($reservation->slot_time as $slot)
                    - {{ $slot }}<br>
                @endforeach
            </p>
            <form action="{{ route('admin.reservation.accept', $reservation->id) }}" method="POST">
                @csrf
                <label for="table_numbers">Pilih Nomor Meja:</label>
                <div class="row">
                    @foreach ($tables as $table)
                        <div class="col-2 form-check">
                            <input type="checkbox" name="table_numbers[]" value="{{ $table->number }}"
                                class="form-check-input" id="table_{{ $table->number }}">
                            <label class="form-check-label" for="table_{{ $table->number }}">Meja
                                {{ $table->number }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Terima</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
