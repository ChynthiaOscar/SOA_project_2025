@extends('layouts.app')
@section('content')
    <h2>Pilih Slot Waktu</h2>
    <form method="POST" action="{{ route('reservation.confirm') }}">
        @csrf
        @foreach ($slots as $slot => $available)
            @if ($available > 0)
                <label>
                    <input type="checkbox" name="time_slots[]" value="{{ $slot }}">
                    {{ $slot }} (Tersedia {{ $available }} Meja)
                </label><br>
            @endif
        @endforeach

        <label>Catatan Tambahan (Opsional):</label>
        <textarea name="notes"></textarea>

        <button type="submit">Lanjut</button>
    </form>
@endsection
