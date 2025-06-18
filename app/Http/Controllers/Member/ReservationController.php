<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\SlotTime;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    /**
     * Daftar riwayat reservasi member.
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.member.reservation.index', compact('reservations'));
    }

    /**
     * Halaman form membuat reservasi (step awal).
     */
    public function create()
    {
        // Batas hari: H-1 hingga H-7
        $minDate = now()->addDay()->format('Y-m-d');
        $maxDate = now()->addDays(7)->format('Y-m-d');

        return view('pages.member.reservation.create', compact('minDate', 'maxDate'));
    }

    /**
     * Pilih waktu reservasi (step setelah pilih tanggal).
     */
    public function selectTime(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date|after:today|before_or_equal:' . now()->addDays(7)->format('Y-m-d'),
            'guest_count' => 'required|integer|min:1',
        ]);

        $slotTimes = SlotTime::all();
        $availableTables = Table::all(); // Nanti bisa disesuaikan dengan availability

        return view('pages.member.reservation.select_time', [
            'reservationDate' => $request->reservation_date,
            'guestCount' => $request->guest_count,
            'slotTimes' => $slotTimes,
            'tables' => $availableTables,
        ]);
    }

    /**
     * Konfirmasi reservasi (preview sebelum simpan).
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date',
            'guest_count' => 'required|integer|min:1',
            'slot_time_id' => 'required|exists:slot_times,id',
            'table_ids' => 'required|array|min:1',
            'table_ids.*' => 'exists:tables,id',
        ]);

        $slot = SlotTime::find($request->slot_time_id);
        $tables = Table::whereIn('id', $request->table_ids)->get();
        $dp = count($tables) * 15000;
        $minimal = count($tables) * 50000;

        return view('pages.member.reservation.confirm', [
            'reservationDate' => $request->reservation_date,
            'guestCount' => $request->guest_count,
            'slot' => $slot,
            'tables' => $tables,
            'dp' => $dp,
            'minimalCharge' => $minimal,
        ]);
    }

    /**
     * Simpan reservasi ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date',
            'guest_count' => 'required|integer|min:1',
            'slot_time_id' => 'required|exists:slot_times,id',
            'table_ids' => 'required|array|min:1',
            'table_ids.*' => 'exists:tables,id',
        ]);

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'reservation_date' => $request->reservation_date,
            'slot_time_id' => $request->slot_time_id,
            'guest_count' => $request->guest_count,
            'status' => 'pending', // default
            'dp_amount' => count($request->table_ids) * 15000,
            'minimal_charge' => count($request->table_ids) * 50000,
        ]);

        $reservation->tables()->sync($request->table_ids);

        return redirect()->route('member.reservations.confirmed', $reservation->id)
            ->with('success', 'Reservasi berhasil dibuat.');
    }

    /**
     * Setelah berhasil menyimpan reservasi.
     */
    public function confirmed(Reservation $reservation)
    {
        return view('pages.member.reservation.confirmed', compact('reservation'));
    }

    /**
     * Cek status (untuk dropdown pembayaran dsb).
     */
    public function status(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        return view('pages.member.reservation.status', compact('reservation'));
    }
}
