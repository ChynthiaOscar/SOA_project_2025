@extends('layouts.app')
@section('content')

    @if ($reservation->status === 'pending')
        <h2>Menunggu Konfirmasi...</h2>
        <p>Jika belum direspons dalam 1 jam, hubungi WhatsApp kami.</p>

        <div class="box">
            <p><strong>Pelanggan:</strong> {{ Auth::user()->name }} ({{ substr(Auth::user()->phone, 0, 4) }}-xxxx-xxxx)</p>
            <p><strong>Tanggal:</strong>
                {{ \Carbon\Carbon::parse($reservation->reservation_date)->translatedFormat('l, d M Y') }}</p>
            <p><strong>Jumlah Orang:</strong> {{ $reservation->number_of_people }} Orang
                ({{ $reservation->number_of_tables }} Meja)</p>
            <p><strong>Slot Waktu:</strong>
                @foreach (json_decode($reservation->time_slots, true) as $slot)
                    {{ $slot }}@if (!$loop->last)
                        ;
                    @endif
                @endforeach
            </p>
            <p><strong>Biaya DP:</strong> Rp {{ number_format($reservation->dp_amount, 0, ',', '.') }}</p>
            <p><strong>Waktu Reservasi:</strong> {{ $reservation->created_at->translatedFormat('l, d M Y (H:i)') }}</p>
            <p><strong>Keterangan:</strong> {{ $reservation->notes ?? '-' }}</p>
        </div>

        <form method="POST" action="{{ route('reservation.cancel', $reservation->id) }}">
            @csrf
            <button type="submit">Batalkan Reservasi</button>
        </form>
    @endif

    @if ($reservation->status === 'approved')
        <h2>Proses Pembayaran DP...</h2>
        <p>Pembayaran hanya bisa dilakukan sampai batas waktu di bawah:</p>

        <div class="box">
            <p><strong>Pelanggan:</strong> {{ Auth::user()->name }} ({{ substr(Auth::user()->phone, 0, 4) }}-xxxx-xxxx)
            </p>
            <p><strong>Tanggal:</strong>
                {{ \Carbon\Carbon::parse($reservation->reservation_date)->translatedFormat('l, d M Y') }}</p>
            <p><strong>Jumlah Orang:</strong> {{ $reservation->number_of_people }} Orang
                ({{ $reservation->number_of_tables }} Meja)</p>
            <p><strong>Slot Waktu:</strong>
                @foreach (json_decode($reservation->time_slots, true) as $slot)
                    {{ $slot }}@if (!$loop->last)
                        ;
                    @endif
                @endforeach
            </p>
            <p><strong>Biaya DP:</strong> Rp {{ number_format($reservation->dp_amount, 0, ',', '.') }}</p>
            <p><strong>Waktu Reservasi:</strong> {{ $reservation->created_at->translatedFormat('l, d M Y (H:i)') }}</p>
            <p><strong>Keterangan:</strong> {{ $reservation->notes ?? '-' }}</p>
            <p><strong>Batas Waktu Bayar:</strong>
                {{ $reservation->created_at->addHour()->translatedFormat('l, d M Y (H:i)') }}
            </p>
        </div>

        <form method="POST" action="{{ route('reservation.pay', $reservation->id) }}">
            @csrf
            <label for="payment_method">Pilih Metode Pembayaran:</label>
            <select name="payment_method" required>
                <option value="">-- Pilih --</option>
                <option value="bca">BCA - Virtual Account</option>
                <option value="gopay">GOPAY</option>
                <option value="ovo">OVO</option>
                <option value="qris">QRIS</option>
            </select>
            <button type="submit">Lihat QR / Bayar</button>
        </form>

        <form method="POST" action="{{ route('reservation.cancel', $reservation->id) }}">
            @csrf
            <button type="submit">Batalkan Reservasi</button>
        </form>
    @endif

    @if ($reservation->status === 'paid')
        <h2>Reservasi Telah Dibayar</h2>
        <p>Status: <strong>Sudah Dibayar</strong></p>
        <p>Metode: {{ strtoupper($reservation->payment_method) }}</p>
    @endif

@endsection
