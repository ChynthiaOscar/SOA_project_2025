<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index(Request $request)
    {
        // Ambil token dari session (atau dari bearer jika pakai API)
        $token = $request->session()->get('token');
        if (!$token) {
            abort(401, 'Unauthorized');
        }

        // Ambil data user yang login
        $response = Http::withToken($token)->get('http://gateway-service/employee/me');

        // Jika gagal ambil user
        if (!$response->ok()) {
            abort(403, 'Gagal mengakses data user');
        }

        $employee = $response->json()['data'];

        // Akses berdasarkan role
        if ($employee['role'] === 'Chef') {
            return redirect()->route('kitchen.show'); // arahkan ke halaman chef
        } elseif ($employee['role'] !== 'Cashier') {
            abort(403, 'Akses ditolak');
        }

        // Jika Cashier, tampilkan halaman index
        $orders = Http::get('http://gateway-service/orders')->json();
        $chefs = Http::get('http://gateway-service/chefs')->json();

        return view('pages.service-kitchen.index', [
            'orders' => $orders,
            'chefs' => $chefs
        ]);
    }


    public function assignChef(Request $request)
    {
        $request->validate([
            'order_detail_id' => 'required',
            'order_id' => 'required',
            'menu_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'chef' => 'required',
            'notes' => 'nullable|string',
        ]);
        $payload = $request->only([
            'order_detail_id',
            'order_id',
            'menu_id',
            'quantity',
            'chef',
            'notes'
        ]);
        $payload['status'] = 'cooking';

        Http::post('http://gateway-service/assign', $payload);

        return redirect()->route('kitchen.index')->with('success', 'Chef berhasil di-assign');
    }
}
