@extends('layouts.app')
@section('content')
    <h2>Riwayat Reservasi Anda</h2>

    <div class="grid">
        @foreach ($reservations as $reservation)
            <div class="card">
                <h3>Reservasi {{ $loop->iteration }}</h3>

                @switch($reservation->status)
                    @case('pending')
                        <p>Menunggu Konfirmasi... dari Restoran</p>
                    @break

                    @case('approved')
                        <p>Proses Pembayaran DP...<br>{{ $reservation->updated_at->translatedFormat('d M Y H:i') }}</p>
                    @break

                    @case('paid')
                        <p>Permintaan Reservasi Diterima<br>
                            Meja {{ $reservation->table_numbers ?? '-' }}</p>
                    @break

                    @case('cancelled')
                        <p style="color: red;">Reservasi Dibatalkan</p>
                    @break

                    @default
                        <p>Status tidak diketahui</p>
                @endswitch

                <a href="{{ route('reservation.show', $reservation->id) }}">
                    <button>MASUK</button>
                </a>
            </div>
        @endforeach
    </div>
@endsection
