<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReservationController extends Controller
{
    private $reservationServiceUrl;

    public function __construct()
    {
        $this->reservationServiceUrl = 'http://52.5.201.24:8002';
    }

    private function getAuthHeaders(Request $request)
    {
        $user = $request->get('auth_user');
        return [
            'Authorization' => 'Bearer ' . $user['token'],
            'Content-Type' => 'application/json',
        ];
    }

    public function index(Request $request)
    {
        $user = $request->get('auth_user');
        
        try {
            $response = Http::withHeaders($this->getAuthHeaders($request))
                ->get($this->reservationServiceUrl . '/reservation/history', [
                    'user_id' => $user['id']
                ]);

            if ($response->ok()) {
                $reservations = $response->json('reservations', []);
                return view('pages.member.reservation.index', compact('reservations'));
            } else {
                Log::error('Failed to fetch reservations: ' . $response->body());
                return view('pages.member.reservation.index', ['reservations' => []]);
            }
        } catch (\Exception $e) {
            Log::error('Reservation index error: ' . $e->getMessage());
            return view('pages.member.reservation.index', ['reservations' => []]);
        }
    }

    public function create()
    {
        // Generate available dates (H-1 to H-7)
        $dates = [];
        for ($i = 1; $i <= 7; $i++) {
            $date = now()->addDays($i);
            $dates[] = [
                'date' => $date->format('Y-m-d'),
                'day_name' => $date->translatedFormat('l'),
                'formatted' => $date->translatedFormat('d M Y')
            ];
        }

        return view('pages.member.reservation.create', compact('dates'));
    }

    public function selectTime(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date|after:today|before_or_equal:' . now()->addDays(7)->format('Y-m-d'),
            'guest_count' => 'required|integer|min:1',
        ]);

        $reservationDate = $request->reservation_date;
        $guestCount = $request->guest_count;
        $tableCount = ceil($guestCount / 4);

        // Store in session for back navigation
        session([
            'reservation_step1' => [
                'reservation_date' => $reservationDate,
                'guest_count' => $guestCount
            ]
        ]);

        try {
            // Get available slots from reservation service
            $response = Http::withHeaders($this->getAuthHeaders($request))
                ->get($this->reservationServiceUrl . '/slots/available', [
                    'date' => $reservationDate,
                    'required_tables' => $tableCount
                ]);

            if ($response->ok()) {
                $availableSlots = $response->json('slots', []);
                
                return view('pages.member.reservation.select_time', [
                    'reservationDate' => $reservationDate,
                    'guestCount' => $guestCount,
                    'tableCount' => $tableCount,
                    'availableSlots' => $availableSlots,
                ]);
            } else {
                return back()->withErrors(['error' => 'Failed to fetch available slots.']);
            }
        } catch (\Exception $e) {
            Log::error('Select time error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date',
            'guest_count' => 'required|integer|min:1',
            'table_count' => 'required|integer|min:1',
            'slot_time_ids' => 'required|array|min:1',
            'slot_time_ids.*' => 'integer',
        ]);

        // Store in session for back navigation
        session([
            'reservation_step2' => [
                'reservation_date' => $request->reservation_date,
                'guest_count' => $request->guest_count,
                'table_count' => $request->table_count,
                'slot_time_ids' => $request->slot_time_ids,
                'note' => $request->note
            ]
        ]);

        try {
            // Get slot details and calculate costs
            $response = Http::withHeaders($this->getAuthHeaders($request))
                ->post($this->reservationServiceUrl . '/reservation/calculate', [
                    'slot_time_ids' => $request->slot_time_ids,
                    'table_count' => $request->table_count
                ]);

            if ($response->ok()) {
                $calculation = $response->json();
                
                return view('pages.member.reservation.confirm', [
                    'reservationDate' => $request->reservation_date,
                    'guestCount' => $request->guest_count,
                    'tableCount' => $request->table_count,
                    'slotTimes' => $calculation['slot_times'],
                    'slotTimeIds' => $request->slot_time_ids,
                    'dpAmount' => $calculation['dp_amount'],
                    'minimalCharge' => $calculation['minimal_charge'],
                ]);
            } else {
                return back()->withErrors(['error' => 'Failed to calculate reservation costs.']);
            }
        } catch (\Exception $e) {
            Log::error('Confirm reservation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date',
            'guest_count' => 'required|integer|min:1',
            'table_count' => 'required|integer|min:1',
            'slot_time_ids' => 'required|array|min:1',
            'slot_time_ids.*' => 'integer',
            'note' => 'nullable|string|max:500',
        ]);

        $user = $request->get('auth_user');

        try {
            $response = Http::withHeaders($this->getAuthHeaders($request))
                ->post($this->reservationServiceUrl . '/reservation', [
                    'user_id' => $user['id'],
                    'reservation_date' => $request->reservation_date,
                    'guest_count' => $request->guest_count,
                    'table_count' => $request->table_count,
                    'slot_time_ids' => $request->slot_time_ids,
                    'note' => $request->note,
                ]);

            if ($response->ok()) {
                $reservation = $response->json('reservation');
                
                // Clear session data after successful creation
                session()->forget(['reservation_step1', 'reservation_step2']);

                return redirect()->route('member.reservations.status', $reservation['id'])
                    ->with('success', 'Reservation created successfully and waiting for admin confirmation.');
            } else {
                $error = $response->json('message', 'Failed to create reservation.');
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Store reservation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function status(Request $request, $reservationId)
    {
        $user = $request->get('auth_user');

        try {
            $response = Http::withHeaders($this->getAuthHeaders($request))
                ->get($this->reservationServiceUrl . "/reservation/{$reservationId}", [
                    'user_id' => $user['id']
                ]);

            if ($response->ok()) {
                $reservation = $response->json('reservation');
                
                // Check if user owns this reservation
                if ($reservation['user_id'] != $user['id']) {
                    abort(403);
                }

                return view('pages.member.reservation.status', compact('reservation'));
            } else {
                return redirect()->route('member.reservations.index')
                    ->withErrors(['error' => 'Reservation not found.']);
            }
        } catch (\Exception $e) {
            Log::error('Reservation status error: ' . $e->getMessage());
            return redirect()->route('member.reservations.index')
                ->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function pay(Request $request, $reservationId)
    {
        $request->validate([
            'payment_method' => 'required|in:bca,gopay,ovo,qris',
        ]);

        $user = $request->get('auth_user');

        try {
            // Call payment service to process payment
            $paymentResponse = Http::withHeaders($this->getAuthHeaders($request))
                ->post(env('PAYMENT_SERVICE_URL') . '/payment/process', [
                    'reservation_id' => $reservationId,
                    'user_id' => $user['id'],
                    'payment_method' => $request->payment_method,
                    'amount_type' => 'dp'
                ]);

            if ($paymentResponse->ok() && $paymentResponse->json('success')) {
                // Update reservation status to paid
                $updateResponse = Http::withHeaders($this->getAuthHeaders($request))
                    ->patch($this->reservationServiceUrl . "/reservation/{$reservationId}/payment", [
                        'payment_method' => $request->payment_method,
                        'payment_reference' => $paymentResponse->json('payment_reference')
                    ]);

                if ($updateResponse->ok()) {
                    return redirect()->route('member.reservations.confirmed', $reservationId)
                        ->with('success', 'Payment successful! Your reservation has been confirmed.');
                }
            }

            return back()->withErrors(['error' => 'Payment failed. Please try again.']);
        } catch (\Exception $e) {
            Log::error('Payment error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Payment service unavailable. Please try again.']);
        }
    }

    public function cancel(Request $request, $reservationId)
    {
        $user = $request->get('auth_user');

        try {
            $response = Http::withHeaders($this->getAuthHeaders($request))
                ->patch($this->reservationServiceUrl . "/reservation/{$reservationId}/cancel", [
                    'user_id' => $user['id']
                ]);

            if ($response->ok()) {
                return redirect()->route('member.reservations.index')
                    ->with('success', 'Reservation cancelled successfully.');
            } else {
                $error = $response->json('message', 'Failed to cancel reservation.');
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Cancel reservation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function confirmed(Request $request, $reservationId)
    {
        $user = $request->get('auth_user');

        try {
            $response = Http::withHeaders($this->getAuthHeaders($request))
                ->get($this->reservationServiceUrl . "/reservation/{$reservationId}", [
                    'user_id' => $user['id']
                ]);

            if ($response->ok()) {
                $reservation = $response->json('reservation');
                
                if ($reservation['user_id'] != $user['id']) {
                    abort(403);
                }

                return view('pages.member.reservation.confirmed', compact('reservation'));
            } else {
                return redirect()->route('member.reservations.index')
                    ->withErrors(['error' => 'Reservation not found.']);
            }
        } catch (\Exception $e) {
            Log::error('Confirmed reservation error: ' . $e->getMessage());
            return redirect()->route('member.reservations.index')
                ->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function getMinimalCharge(Request $request, $reservationId)
    {
        // This endpoint will be called by order service to get minimal charge
        $user = $request->get('auth_user');

        try {
            $response = Http::withHeaders($this->getAuthHeaders($request))
                ->get($this->reservationServiceUrl . "/reservation/{$reservationId}/minimal-charge");

            if ($response->ok()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Reservation not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Get minimal charge error: ' . $e->getMessage());
            return response()->json(['error' => 'Service unavailable'], 500);
        }
    }
}