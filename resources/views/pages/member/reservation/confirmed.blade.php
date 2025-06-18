@extends('layouts.app')
@section('content')
    <h2>Permintaan Reservasi Diterima ✅</h2>
    <p>Meja Pelanggan: {{ $reservation->table_numbers ?? 'Belum ditentukan' }}</p>

    <div class="box">
        <p><strong>Pelanggan:</strong> {{ Auth::user()->name }} ({{ substr(Auth::user()->phone, 0, 4) }}-xxxx-xxxx)</p>
        <p><strong>Tanggal:</strong>
            {{ \Carbon\Carbon::parse($reservation->reservation_date)->translatedFormat('l, d M Y') }}</p>
        <p><strong>Jumlah Meja:</strong> {{ $reservation->number_of_tables }} Meja</p>
        <p><strong>Slot Waktu:</strong>
            @foreach (json_decode($reservation->time_slots, true) as $slot)
                {{ $slot }}@if (!$loop->last)
                    ;
                @endif
            @endforeach
        </p>
        <p><strong>Biaya DP:</strong> Rp {{ number_format($reservation->dp_amount, 0, ',', '.') }}</p>
        <p><strong>Waktu Reservasi:</strong> {{ $reservation->created_at->translatedFormat('l, d M Y (H:i)') }}</p>
        <p><strong>Waktu Pembayaran:</strong>
            {{ \Carbon\Carbon::parse($reservation->paid_at)->translatedFormat('l, d M Y (H:i)') }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ strtoupper($reservation->payment_method) }}</p>
    </div>

    <!-- Tombol Batalkan -->
    <button onclick="document.getElementById('cancelModal').style.display='block'">Batalkan Reservasi</button>

    <!-- Modal Batalkan -->
    <div id="cancelModal" style="display:none;">
        <div class="modal">
            @php
                $now = now();
                $reservationDate = \Carbon\Carbon::parse($reservation->reservation_date);
                $diff = $now->diffInDays($reservationDate, false);
            @endphp

            <h3>BATALKAN RESERVASI</h3>
            @if ($diff >= 2 && $diff <= 7)
                <p>Apakah Anda yakin ingin membatalkan reservasi ini?</p>
                <p><strong>Catatan:</strong> Tidak ada potongan Biaya DP (H-2 s/d H-7)</p>
            @elseif($diff == 1)
                <p>Membatalkan reservasi akan memotong 25% pengembalian biaya DP.</p>
            @else
                <p>Waktu pembatalan sudah terlalu dekat. Hubungi admin.</p>
            @endif

            <form method="POST" action="{{ route('reservation.cancelConfirmed', $reservation->id) }}">
                @csrf
                <button type="submit">Batalkan Reservasi</button>
            </form>

            <button onclick="document.getElementById('cancelModal').style.display='none'">Kembali</button>
        </div>
    </div>
@endsection
