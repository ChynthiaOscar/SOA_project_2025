@extends('layouts.app')
@section('content')
    <h2>Konfirmasi Reservasi</h2>

    <ul>
        <li><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d M Y') }}</li>
        <li><strong>Jumlah Orang:</strong> {{ $people }}</li>
        <li><strong>Jumlah Meja:</strong> {{ $tables }}</li>
        <li><strong>Slot Waktu:</strong>
            <ul>
                @foreach ($slots as $slot)
                    <li>{{ $slot }}</li>
                @endforeach
            </ul>
        </li>
        <li><strong>Biaya DP:</strong> Rp {{ number_format($dp, 0, ',', '.') }}</li>
        <li><strong>Biaya Minimal Makan:</strong> Rp {{ number_format($min_food_price, 0, ',', '.') }}</li>
    </ul>

    <form method="POST" action="{{ route('reservation.store') }}">
        @csrf
        <button type="submit">Konfirmasi</button>
    </form>
@endsection
