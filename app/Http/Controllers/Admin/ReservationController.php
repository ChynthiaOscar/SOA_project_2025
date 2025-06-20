<?php

namespace App\Http\Controllers\Admin;

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
        $user = session('user');
        if (!$user || !isset($user['accessToken'])) {
            return null;
        }

        return [
            'Authorization' => 'Bearer ' . $user['accessToken'],
            'Content-Type' => 'application/json',
        ];
    }

    public function index(Request $request)
    {
        $selectedDate = $request->get('date', now()->format('Y-m-d'));
        $headers = $this->getAuthHeaders();

        if (!$headers) {
            return redirect()->route('employee.login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            // Get pending reservations from reservation service
            $response = Http::withHeaders($headers)
                ->get($this->reservationServiceUrl . '/admin/reservations', [
                    'date' => $selectedDate
                ]);

            if ($response->ok()) {
                $data = $response->json();
                $reservations = $data['reservations'] ?? [];

                // Transform reservations for view
                $transformedReservations = collect($reservations)->map(function ($reservation) {
                    return [
                        'id' => $reservation['id'],
                        'user_id' => $reservation['user_id'],
                        'reservation_date' => $reservation['reservation_date'],
                        'guest_count' => $reservation['guest_count'],
                        'table_count' => $reservation['table_count'],
                        'dp_amount' => $reservation['dp_amount'],
                        'minimal_charge' => $reservation['minimal_charge'],
                        'status' => $reservation['status'],
                        'note' => $reservation['note'],
                        'slot_times' => $reservation['slot_times'] ?? [],
                        'tables' => $reservation['tables'] ?? [],
                    ];
                })->toArray();
            } else {
                Log::error('Failed to fetch reservations: ' . $response->body());
                $transformedReservations = [];
            }

            // Get all tables from reservation service
            $tablesResponse = Http::withHeaders($headers)
                ->get($this->reservationServiceUrl . '/admin/tables');

            if ($tablesResponse->ok()) {
                $tablesData = $tablesResponse->json();
                $tables = $tablesData['tables'] ?? [];
            } else {
                Log::error('Failed to fetch tables: ' . $tablesResponse->body());
                $tables = [];
            }

            return view('pages.admin.reservation.index', [
                'reservations' => $transformedReservations,
                'tables' => $tables,
                'selectedDate' => $selectedDate
            ]);
        } catch (\Exception $e) {
            Log::error('Reservation index error: ' . $e->getMessage());
            return view('pages.admin.reservation.index', [
                'reservations' => [],
                'tables' => [],
                'selectedDate' => $selectedDate
            ]);
        }
    }

    public function approve(Request $request, $reservationId)
    {
        $request->validate([
            'table_ids' => 'required|array|min:1',
            'table_ids.*' => 'integer',
        ]);

        $headers = $this->getAuthHeaders();

        if (!$headers) {
            return redirect()->route('employee.login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->post($this->reservationServiceUrl . '/admin/reservation/approve', [
                    'reservation_id' => $reservationId,
                    'table_ids' => $request->table_ids
                ]);

            if ($response->ok()) {
                return back()->with('success', 'Reservasi berhasil dikonfirmasi dan meja telah ditetapkan.');
            } else {
                $error = $response->json()['error'] ?? 'Failed to approve reservation.';
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Approve reservation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function reject($reservationId)
    {
        $headers = $this->getAuthHeaders();

        if (!$headers) {
            return redirect()->route('employee.login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->post($this->reservationServiceUrl . '/admin/reservation/reject', [
                    'reservation_id' => $reservationId
                ]);

            if ($response->ok()) {
                return back()->with('success', 'Reservasi berhasil ditolak.');
            } else {
                $error = $response->json()['error'] ?? 'Failed to reject reservation.';
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Reject reservation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }
}
