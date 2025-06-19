<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class EmployeeController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('api.api_base_url');
    }
    public function login(Request $request)
    {
        Log::info('Login attempt:', $request->only('email', 'password'));
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post($this->apiBaseUrl.'/employee/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->ok()) {
            $data = $response->json();

            Session::put('user', [
                'id' => $data['data']['id'],
                'name' => $data['data']['name'],
                'email' => $data['data']['email'],
                'salaryPerShift' => $data['data']['salary_per_shift'],
                'accessToken' => $data['data']['access_token'],
                'role' => $data['data']['role'],
                // add more if you want
            ]);

            return redirect('/dashboard'); // or any protected page
        } else {
            return back()->withErrors([
                'login' => $response->json('message') ?? 'Login failed.',
            ])->withInput();
        }
    }
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $response = Http::post($this->apiBaseUrl.'/employee', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            Log::info('Register successful. API response:', $data);
            // Store token and user info in session

            return redirect('/login');
        } else {
            return back()->withErrors([
                'register' => $response->json('message') ?? 'Registration failed.',
            ])->withInput();

        }
    }
}
