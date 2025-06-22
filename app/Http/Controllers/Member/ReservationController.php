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

    private function getAuthHeaders()
    {
        $member = session('member');
        if (!$member || !isset($member['token'])) {
            return null;
        }

        return [
            'Authorization' => 'Bearer ' . $member['token'],
            'Content-Type' => 'application/json',
        ];
    }

    private function getMemberData()
    {
        $member = session('member');
        if (!$member) {
            return null;
        }

        return [
            'id' => $member['id'],
            'token' => $member['token'] ?? null,
            'email' => $member['email'] ?? null,
            'nama' => $member['nama'] ?? null,
        ];
    }

    public function index()
    {
        $headers = $this->getAuthHeaders();
        $member = $this->getMemberData();

        if (!$headers || !$member) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to access reservations.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->get($this->reservationServiceUrl . '/reservation/history', [
                    'user_id' => $member['id']
                ]);

            if ($response->ok()) {
                $data = $response->json();
                $reservations = $data['reservations'] ?? [];

                // Transform reservations for view
                $transformedReservations = collect($reservations)->map(function ($reservation) {
                    return (object) [
                        'id' => $reservation['id'],
                        'user_id' => $reservation['user_id'],
                        'reservation_date' => Carbon::parse($reservation['reservation_date']),
                        'guest_count' => $reservation['guest_count'],
                        'table_count' => $reservation['table_count'],
                        'dp_amount' => $reservation['dp_amount'],
                        'minimal_charge' => $reservation['minimal_charge'],
                        'status' => $reservation['status'],
                        'payment_time' => $reservation['payment_time'] ? Carbon::parse($reservation['payment_time']) : null,
                        'payment_method' => $reservation['payment_method'],
                        'note' => $reservation['note'],
                        'created_at' => Carbon::parse($reservation['created_at']),
                        'slotTimes' => collect($reservation['slot_times'] ?? [])->map(function ($slot) {
                            return (object) [
                                'id' => $slot['id'],
                                'start_time' => $slot['start_time'],
                                'end_time' => $slot['end_time'],
                            ];
                        }),
                        'tables' => collect($reservation['tables'] ?? [])->map(function ($table) {
                            return (object) [
                                'id' => $table['id'],
                                'number' => $table['number'],
                                'seat_count' => $table['seat_count'],
                            ];
                        }),
                        'formatted_slot_times' => collect($reservation['slot_times'] ?? [])->map(function ($slot) {
                            return $slot['start_time'] . ' - ' . $slot['end_time'];
                        })->implode(', '),
                        'table_numbers' => collect($reservation['tables'] ?? [])->pluck('number')->toArray(),
                    ];
                });

                return view('pages.member.reservation.index', compact('transformedReservations'));
            } else {
                Log::error('Failed to fetch reservations: ' . $response->body());
                return view('pages.member.reservation.index', ['transformedReservations' => collect()]);
            }
        } catch (\Exception $e) {
            Log::error('Reservation index error: ' . $e->getMessage());
            return view('pages.member.reservation.index', ['transformedReservations' => collect()]);
        }
    }

    public function create()
    {
        $member = $this->getMemberData();
        if (!$member) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to make reservations.']);
        }

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

        $headers = $this->getAuthHeaders();
        $member = $this->getMemberData();

        if (!$headers || !$member) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to continue.']);
        }

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
            $response = Http::withHeaders($headers)
                ->get($this->reservationServiceUrl . '/slots/available', [
                    'date' => $reservationDate,
                    'required_tables' => $tableCount
                ]);

            if ($response->ok()) {
                $data = $response->json();
                $availableSlots = $data['slots'] ?? [];

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

        $headers = $this->getAuthHeaders();
        $member = $this->getMemberData();

        if (!$headers || !$member) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to continue.']);
        }

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
            $response = Http::withHeaders($headers)
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
                    'slotTimes' => collect($calculation['slot_times'])->map(function ($slot) {
                        return (object) $slot;
                    }),
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

        $headers = $this->getAuthHeaders();
        $member = $this->getMemberData();

        if (!$headers || !$member) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->post($this->reservationServiceUrl . '/reservation', [
                    'user_id' => $member['id'],
                    'reservation_date' => $request->reservation_date,
                    'guest_count' => $request->guest_count,
                    'table_count' => $request->table_count,
                    'slot_time_ids' => $request->slot_time_ids,
                    'note' => $request->note,
                ]);

            if ($response->ok()) {
                $data = $response->json();
                $reservation = $data['reservation'];

                // Clear session data after successful creation
                session()->forget(['reservation_step1', 'reservation_step2']);

                return redirect()->route('member.reservations.status', $reservation['id'])
                    ->with('success', 'Reservation created successfully and waiting for admin confirmation.');
            } else {
                $error = $response->json()['error'] ?? 'Failed to create reservation.';
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Store reservation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function status($reservationId)
    {
        $headers = $this->getAuthHeaders();
        $member = $this->getMemberData();

        if (!$headers || !$member) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->get($this->reservationServiceUrl . "/reservation/{$reservationId}", [
                    'user_id' => $member['id']
                ]);

            if ($response->ok()) {
                $data = $response->json();
                $reservationData = $data['reservation'];

                // Check if user owns this reservation
                if ($reservationData['user_id'] != $member['id']) {
                    abort(403);
                }

                // Transform reservation data
                $reservation = (object) [
                    'id' => $reservationData['id'],
                    'user_id' => $reservationData['user_id'],
                    'reservation_date' => Carbon::parse($reservationData['reservation_date']),
                    'guest_count' => $reservationData['guest_count'],
                    'table_count' => $reservationData['table_count'],
                    'dp_amount' => $reservationData['dp_amount'],
                    'minimal_charge' => $reservationData['minimal_charge'],
                    'status' => $reservationData['status'],
                    'payment_time' => $reservationData['payment_time'] ? Carbon::parse($reservationData['payment_time']) : null,
                    'payment_method' => $reservationData['payment_method'],
                    'note' => $reservationData['note'],
                    'created_at' => Carbon::parse($reservationData['created_at']),
                    'slotTimes' => collect($reservationData['slot_times'] ?? [])->map(function ($slot) {
                        return (object) [
                            'id' => $slot['id'],
                            'start_time' => $slot['start_time'],
                            'end_time' => $slot['end_time'],
                        ];
                    }),
                    'tables' => collect($reservationData['tables'] ?? [])->map(function ($table) {
                        return (object) [
                            'id' => $table['id'],
                            'number' => $table['number'],
                            'seat_count' => $table['seat_count'],
                        ];
                    }),
                    'table_numbers' => collect($reservationData['tables'] ?? [])->pluck('number')->toArray(),
                    'user' => (object) [
                        'name' => $member['nama'],
                        'phone' => null // Add phone if available in member data
                    ]
                ];

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

        $headers = $this->getAuthHeaders();
        $member = $this->getMemberData();

        if (!$headers || !$member) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            // First get reservation details to get DP amount
            $reservationResponse = Http::withHeaders($headers)
                ->get($this->reservationServiceUrl . "/reservation/{$reservationId}", [
                    'user_id' => $member['id']
                ]);

            if (!$reservationResponse->ok()) {
                return back()->withErrors(['error' => 'Reservation not found.']);
            }

            $reservationData = $reservationResponse->json()['reservation'];

            // Call payment service to process payment
            $paymentData = [
                'customer_id' => $member['id'],
                'requester_type' => 1, // 1 for reservation
                'requester_id' => $reservationId,
                'secondary_requester_id' => null,
                'payment_method' => $request->payment_method,
                'payment_amount' => $reservationData['dp_amount']
            ];

            $paymentResponse = Http::withHeaders([
                'Authorization' => 'order123',
                'Content-Type' => 'application/json',
            ])->post('http://3.216.16.187:8002/payment', $paymentData);

            if ($paymentResponse->ok() && $paymentResponse->json()['status'] === 'success') {
                $paymentResult = $paymentResponse->json();

                // Update reservation status to paid
                $updateResponse = Http::withHeaders($headers)
                    ->patch($this->reservationServiceUrl . "/reservation/{$reservationId}/payment", [
                        'payment_method' => $request->payment_method,
                        'payment_reference' => $paymentResult['payment_id']
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

    public function cancel($reservationId)
    {
        $headers = $this->getAuthHeaders();
        $member = $this->getMemberData();

        if (!$headers || !$member) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->patch($this->reservationServiceUrl . "/reservation/{$reservationId}/cancel", [
                    'user_id' => $member['id']
                ]);

            if ($response->ok()) {
                return redirect()->route('member.reservations.index')
                    ->with('success', 'Reservation cancelled successfully.');
            } else {
                $error = $response->json()['error'] ?? 'Failed to cancel reservation.';
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Cancel reservation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function confirmed($reservationId)
    {
        $headers = $this->getAuthHeaders();
        $member = $this->getMemberData();

        if (!$headers || !$member) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->get($this->reservationServiceUrl . "/reservation/{$reservationId}", [
                    'user_id' => $member['id']
                ]);

            if ($response->ok()) {
                $data = $response->json();
                $reservationData = $data['reservation'];

                if ($reservationData['user_id'] != $member['id']) {
                    abort(403);
                }

                // Transform reservation data
                $reservation = (object) [
                    'id' => $reservationData['id'],
                    'user_id' => $reservationData['user_id'],
                    'reservation_date' => Carbon::parse($reservationData['reservation_date']),
                    'guest_count' => $reservationData['guest_count'],
                    'table_count' => $reservationData['table_count'],
                    'dp_amount' => $reservationData['dp_amount'],
                    'minimal_charge' => $reservationData['minimal_charge'],
                    'status' => $reservationData['status'],
                    'payment_time' => $reservationData['payment_time'] ? Carbon::parse($reservationData['payment_time']) : null,
                    'payment_method' => $reservationData['payment_method'],
                    'note' => $reservationData['note'],
                    'created_at' => Carbon::parse($reservationData['created_at']),
                    'slotTimes' => collect($reservationData['slot_times'] ?? [])->map(function ($slot) {
                        return (object) [
                            'id' => $slot['id'],
                            'start_time' => $slot['start_time'],
                            'end_time' => $slot['end_time'],
                        ];
                    }),
                    'tables' => collect($reservationData['tables'] ?? [])->map(function ($table) {
                        return (object) [
                            'id' => $table['id'],
                            'number' => $table['number'],
                            'seat_count' => $table['seat_count'],
                        ];
                    }),
                    'table_numbers' => collect($reservationData['tables'] ?? [])->pluck('number')->toArray(),
                    'user' => (object) [
                        'name' => $member['nama'],
                        'phone' => null
                    ]
                ];

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

    public function getMinimalCharge($reservationId)
    {
        // This endpoint will be called by order service to get minimal charge
        try {
            $response = Http::get($this->reservationServiceUrl . "/reservation/{$reservationId}/minimal-charge");

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
