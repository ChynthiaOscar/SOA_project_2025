<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SlotTimeController extends Controller
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
            $response = Http::withHeaders($headers)
                ->get($this->reservationServiceUrl . '/admin/slots', [
                    'date' => $selectedDate
                ]);

            if ($response->ok()) {
                $data = $response->json();
                $slots = $data['slots'] ?? [];
            } else {
                Log::error('Failed to fetch slots: ' . $response->body());
                $slots = [];
            }

            return view('pages.admin.slots.index', compact('slots', 'selectedDate'));
        } catch (\Exception $e) {
            Log::error('Slots index error: ' . $e->getMessage());
            return view('pages.admin.slots.index', [
                'slots' => [],
                'selectedDate' => $selectedDate
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'date' => 'required|date',
        ]);

        $headers = $this->getAuthHeaders();

        if (!$headers) {
            return redirect()->route('employee.login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->post($this->reservationServiceUrl . '/admin/slot', [
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'date' => $request->date
                ]);

            if ($response->ok()) {
                return back()->with('success', 'Slot waktu berhasil ditambahkan.');
            } else {
                $error = $response->json()['error'] ?? 'Failed to create slot.';
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Create slot error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function destroy($slotId)
    {
        $headers = $this->getAuthHeaders();

        if (!$headers) {
            return redirect()->route('employee.login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->delete($this->reservationServiceUrl . '/admin/slot/' . $slotId);

            if ($response->ok()) {
                return back()->with('success', 'Slot waktu berhasil dihapus.');
            } else {
                $error = $response->json()['error'] ?? 'Failed to delete slot.';
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Delete slot error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }
}
