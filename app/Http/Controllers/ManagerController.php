<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ManagerController extends Controller
{
    protected string $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = 'http://50.19.17.50:8002';
    }

    public function index()
    {
        return view('pages.service-employee.manager.dashboard');
    }

    public function showEmployees(Request $request)
    {
        $token = session('user.accessToken');

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/employee", [
            'search' => $request->input('search'),
            'role' => $request->input('role'),
        ]);

        $employees = $response->ok() ? $response->json('data') : [];

        return view('pages.service-employee.manager.employee_data', compact('employees'));
    }

    public function editEmployee($id)
    {
        $token = session('user.accessToken');

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/employee/{$id}");

        if ($response->successful()) {
            $employee = $response->json('data');
            return view('pages.service-employee.manager.edit_employee', compact('employee'));
        }

        return back()->withErrors('Failed to load employee data.');
    }

    public function scheduleView(Request $request)
    {
        $token = session('user.accessToken');

        $query = [
            'date' => $request->input('date', Carbon::now()->format('Y-m-d')),
            'shift' => $request->input('shift'),
            'role' => $request->input('role'),
            'search' => $request->input('search'),
        ];

        $filteredQuery = array_filter($query, fn($v) => $v !== null && $v !== '');

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/employee/schedule", $filteredQuery);

        $schedules = $response->successful() ? $response->json('data') : [];

        return view('pages.service-employee.manager.schedule', compact('schedules'));
    }

    public function createSingleSchedule()
    {
        $token = session('user.accessToken');

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/employee");

        if (!$response->successful()) {
            return back()->withErrors(['msg' => 'Failed to fetch employees']);
        }

        $employees = $response->json('data');

        return view('pages.service-employee.manager.schedule_single', compact('employees'));
    }

    public function createBatchSchedule()
    {
        $token = session('user.accessToken');

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/employee");

        if (!$response->successful()) {
            return back()->withErrors(['msg' => 'Failed to fetch employees']);
        }

        $employees = $response->json('data');

        return view('pages.service-employee.manager.schedule_batch', compact('employees'));
    }

    public function storeSingleSchedule(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|integer',
            'date' => 'required|date',
            'shift_type' => 'required|in:day,night',
        ]);

        $token = session('user.accessToken');

        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/employee/schedule", $validated);

        return $response->successful()
            ? redirect()->route('manager.schedule')->with('success', 'Schedule created.')
            : back()->withErrors(['msg' => 'Failed to create schedule'])->withInput();
    }

    public function storeBatchSchedule(Request $request)
    {
        $validated = $request->validate([
            'employee_ids' => 'required|array|min:1',
            'employee_ids.*' => 'integer',
            'date' => 'required|date',
            'shift_type' => 'required|in:day,night',
        ]);

        $token = session('user.accessToken');

        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/employee/schedule/batch", $validated);

        return $response->successful()
            ? redirect()->route('manager.schedule')->with('success', 'Batch schedule created.')
            : back()->withErrors(['msg' => 'Failed to create batch schedule'])->withInput();
    }
    public function updateSchedule(Request $request, $id)
    {
        $token = session('user.accessToken');

        $data = [
            'attendance' => $request->input('attendance', 0),
            'note' => $request->input('note', ''),
        ];

        $response = Http::withToken($token)->put("{$this->apiBaseUrl}/employee/schedule/{$id}", $data);

        return $response->successful()
            ? back()->with('success', 'Attendance updated.')
            : back()->withErrors(['update' => 'Failed to update attendance.']);
    }
    public function attendanceView(Request $request)
    {
        $token = session('user.accessToken');

        $query = [
            'date' => $request->input('date', Carbon::now()->format('Y-m-d')),
            'shift' => $request->input('shift'),
            'search' => $request->input('search'),
        ];

        $filteredQuery = array_filter($query, fn($v) => $v !== null && $v !== '');

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/employee/schedule", $filteredQuery);

        $schedules = $response->successful() ? $response->json('data') : [];

        return view('pages.service-employee.manager.attendance', compact('schedules'));
    }

}
