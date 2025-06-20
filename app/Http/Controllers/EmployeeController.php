<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    protected string $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = 'http://50.19.17.50:8002';
    }

    public function dashboard(Request $request)
    {
        $user = session('user');

        $month = $request->input('month', now()->format('Y-m'));
        $today = now()->toDateString();
        $salaryPerShift = $user['salaryPerShift'] ?? 0;

        $monthlyShifts = Http::withToken($user['accessToken'])
            ->get("{$this->apiBaseUrl}/employee/schedule", [
                'month' => $month,
                'employee_id' => $user['id'],
            ])
            ->json('data') ?? [];

        $upcomingShifts = Http::withToken($user['accessToken'])
            ->get("{$this->apiBaseUrl}/employee/schedule", [
                'from_date' => $today,
                'employee_id' => $user['id'],
            ])
            ->json('data') ?? [];

        $shiftCount = count($monthlyShifts);
        $summary = [
            'shifts' => $shiftCount,
            'hours' => $shiftCount * 8,
            'salary' => $shiftCount * $salaryPerShift,
        ];

        return view('pages.service-employee.employee.dashboard', [
            'currentMonthName' => Carbon::parse($month)->format('F Y'),
            'summary' => $summary,
            'upcomingShifts' => $upcomingShifts,
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post("{$this->apiBaseUrl}/employee/login", $request->only('email', 'password'));

        if ($response->ok()) {
            $data = $response->json('data');

            session(['user' => [
                'id' => $data['id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'salaryPerShift' => $data['salary_per_shift'],
                'accessToken' => $data['access_token'],
                'role' => $data['role'],
            ]]);

            return $data['role'] === 'manager'
                ? redirect()->to('/employee/manager/dashboard')
                : redirect()->route('employee.dashboard');
        }

        return back()->withErrors([
            'login' => $response->json('message') ?? 'Login failed.',
        ])->withInput();
    }
    public function logout()
    {
        $token = session('user.accessToken');

        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/employee/logout");

        if ($response->successful()) {
            session()->forget('user');
            return redirect()->route('employee.login')->with('success', 'Logged out successfully.');
        }

        return back()->withErrors(['logout' => 'Failed to log out.']);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $response = Http::post("{$this->apiBaseUrl}/employee", $request->only('name', 'email', 'password'));

        return $response->successful()
            ? redirect()->route('employee.login')->with('success', 'Registered successfully.')
            : back()->withErrors([
                'register' => $response->json('message') ?? 'Registration failed.',
            ])->withInput();
    }
    public function edit()
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('employee.login')->withErrors('Please log in first.');
        }

        return view('pages.service-employee.both.editprofile', compact('user'));
    }
    public function updateProfile(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'password']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $token = session('user.accessToken');

        $response = Http::withToken($token)->put("{$this->apiBaseUrl}/employee/{$id}", $data);

        if ($response->successful()) {
            $updatedUser = $response->json('data');

            session()->put('user.name', $updatedUser['name']);
            session()->put('user.email', $updatedUser['email']);

            return redirect()->route('employee.profile')->with('success', 'Profile updated successfully.');
        }

        return back()->withErrors([
            'update' => $response->json('message') ?? 'Failed to update profile.',
        ])->withInput();
    }
    public function updateByManager(Request $request, $id)
    {
        $data = $request->only(['name', 'role', 'salary_per_shift']);

        $token = session('user.accessToken');

        $response = Http::withToken($token)->put("{$this->apiBaseUrl}/employee/{$id}", $data);

        return $response->successful()
            ? redirect()->route('manager.employee_data')->with('success', 'Employee updated successfully.')
            : back()->withErrors(['update' => 'Failed to update employee'])->withInput();
    }
}
