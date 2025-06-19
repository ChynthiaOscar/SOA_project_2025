<?php

// app/Http/Controllers/EmployeeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->apiBaseUrl = config('api.api_base_url');
    }
    public function showForm()
    {
        return view('/pages/service-employee/employee/register');
    }

    public function dashboard(Request $request)
    {
        $user = session('user');
        $month = $request->input('month', now()->format('Y-m'));
        $today = now()->toDateString();
        $salaryPerShift = $user['salary_per_shift'] ?? 0;

        // 1. Fetch all shifts for this employee in the current month
        $monthlyShiftsResponse = Http::withToken($user['accessToken'])
            ->get($this->apiBaseUrl . "/employee/schedule", [
                'month' => $month,
                'employee_id' => $user['id'],
            ]);

        // 2. Fetch upcoming shifts from today onward
        $upcomingShiftsResponse = Http::withToken($user['accessToken'])
            ->get($this->apiBaseUrl . "/employee/schedule", [
                'from_date' => $today,
                'employee_id' => $user['id'],
            ]);

        // Process results
        $monthlyShifts = $monthlyShiftsResponse->ok() ? $monthlyShiftsResponse->json('data') : [];
        $upcomingShifts = $upcomingShiftsResponse->ok() ? $upcomingShiftsResponse->json('data') : [];

        $shiftCount = count($monthlyShifts);
        $hoursWorked = $shiftCount * 8;
        $salary = $shiftCount * $salaryPerShift;

        return view('pages.service-employee.employee.dashboard', [
            'currentMonthName' => Carbon::parse($month)->format('F Y'),
            'summary' => [
                'shifts' => $shiftCount,
                'hours' => $hoursWorked,
                'salary' => $salary,
            ],
            'upcomingShifts' => $upcomingShifts,
        ]);
    }
    public function store(Request $request)
    {
        // Validasi hanya field yang diisi user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employee_data,email',
            'password' => 'required|string|min:6',
        ]);

        // Simpan ke database dengan nilai default untuk role dan salary
        Employee::create([
            'name' => $validated['name'],
            'role' => 'unassign', // default value
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'salary_per_shift' => 0, // default value
        ]);

        return redirect('/register')->with('success', 'Employee registered successfully!');
    }
}
