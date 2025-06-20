<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
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

    public function index()
    {
        $headers = $this->getAuthHeaders();

        if (!$headers) {
            return redirect()->route('employee.login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->get($this->reservationServiceUrl . '/admin/tables');

            if ($response->ok()) {
                $data = $response->json();
                $tables = $data['tables'] ?? [];
            } else {
                Log::error('Failed to fetch tables: ' . $response->body());
                $tables = [];
            }

            return view('pages.admin.tables.index', compact('tables'));
        } catch (\Exception $e) {
            Log::error('Tables index error: ' . $e->getMessage());
            return view('pages.admin.tables.index', ['tables' => []]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|integer|min:1',
            'seat_count' => 'required|integer|min:1',
        ]);

        $headers = $this->getAuthHeaders();

        if (!$headers) {
            return redirect()->route('employee.login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->post($this->reservationServiceUrl . '/admin/table', [
                    'number' => $request->number,
                    'seat_count' => $request->seat_count,
                    'is_available' => true
                ]);

            if ($response->ok()) {
                return back()->with('success', 'Meja berhasil ditambahkan.');
            } else {
                $error = $response->json()['error'] ?? 'Failed to create table.';
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Create table error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function update(Request $request, $tableId)
    {
        $request->validate([
            'seat_count' => 'required|integer|min:1',
            'is_available' => 'required|boolean',
        ]);

        $headers = $this->getAuthHeaders();

        if (!$headers) {
            return redirect()->route('employee.login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->put($this->reservationServiceUrl . '/admin/table/' . $tableId, [
                    'seat_count' => $request->seat_count,
                    'is_available' => $request->is_available
                ]);

            if ($response->ok()) {
                return back()->with('success', 'Meja berhasil diperbarui.');
            } else {
                $error = $response->json()['error'] ?? 'Failed to update table.';
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Update table error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }

    public function destroy($tableId)
    {
        $headers = $this->getAuthHeaders();

        if (!$headers) {
            return redirect()->route('employee.login')->withErrors(['error' => 'Please login to continue.']);
        }

        try {
            $response = Http::withHeaders($headers)
                ->delete($this->reservationServiceUrl . '/admin/table/' . $tableId);

            if ($response->ok()) {
                return back()->with('success', 'Meja berhasil dihapus.');
            } else {
                $error = $response->json()['error'] ?? 'Failed to delete table.';
                return back()->withErrors(['error' => $error]);
            }
        } catch (\Exception $e) {
            Log::error('Delete table error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Service unavailable. Please try again.']);
        }
    }
}
