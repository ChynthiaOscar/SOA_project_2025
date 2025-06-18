@extends('layouts.app')
@section('content')
    <h2>Masukkan Data Reservasi</h2>
    <form method="POST" action="{{ route('reservation.selectTime') }}">
        @csrf
        <label>Jumlah Orang:</label>
        <input type="number" name="number_of_people" min="1" required>

        <label>Pilih Tanggal:</label>
        @foreach ($dates as $date)
            <label>
                <input type="radio" name="reservation_date" value="{{ $date['date'] }}" required>
                {{ $date['day_name'] }}, {{ $date['formatted'] }}
            </label><br>
        @endforeach

        <button type="submit">Lanjut</button>
    </form>
@endsection
