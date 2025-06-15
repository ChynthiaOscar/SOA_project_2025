<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class EmployeeController extends Controller
{
    public function login(Request $request)
    {
        Log::info('Login attempt:', $request->only('email', 'password'));
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post('http://13.216.140.177:8000/employee/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->ok()) {
            $data = $response->json();

            Log::info('Login successful. API response:', $data);
            // Store token and user info in session
            Session::put('accessToken', $data['data']['access_token']);
            Session::put('role', $data['data']['role']);

            return redirect('/dashboard'); // or any protected page
        } else {
            return back()->withErrors([
                'login' => $response->json('message') ?? 'Login failed.',
            ])->withInput();
        }
    }
}
