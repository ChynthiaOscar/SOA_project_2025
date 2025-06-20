<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KitchenController extends Controller
{
    public function index(Request $request)
    {
        $token = session('user.accessToken');

        if (!$token) {
            abort(401, 'Unauthorized');
        }

        $response = Http::withToken($token)->get('http://50.19.17.50:8002/employee/me');

        if (!$response->ok()) {
            abort(403, 'Gagal mengakses data user');
        }

        $employee = $response->json()['data'];

        if ($employee['role'] === 'Chef') {
            return redirect()->route('kitchen.show');
        } elseif ($employee['role'] !== 'Cashier') {
            abort(403, 'Akses ditolak');
        }

        $orderDetailsResponse = Http::withToken($token)->get('http://50.19.17.50:8002/order-details');
        $orderDetails = $orderDetailsResponse->ok() ? $orderDetailsResponse->json() : [];

        $chefsResponse = Http::withToken($token)->get('http://50.19.17.50:8002/employee/schedule', [
            'role' => 'Chef',
            'attendance' => true,
            'date' => Carbon::now()->toDateString()
        ]);

        $chefs = $chefsResponse->ok() ? $chefsResponse->json()['data'] : [];

        return view('pages.service-kitchen.index', [
            'orderDetails' => $orderDetails,
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

        $payload = [
            'kitchen_id' => $request->order_detail_id,
            'menu' => $request->menu_id,
            'quantity' => $request->quantity,
            'chef' => $request->chef,
            'notes' => $request->notes,
        ];

        $response = Http::post('http://50.19.17.50:8002/tasks/add', $payload);

        if ($response->successful()) {
            return redirect()->route('kitchen.index')->with('success', 'Chef berhasil di-assign');
        } else {
            return redirect()->route('kitchen.index')->with('error', 'Gagal assign chef: ' . $response->json('error'));
        }
    }


    public function dummy_local()
    {
        $response = Http::get('http://localhost:8000/tasks')->json();
        return view('pages.service-kitchen.dummy', ['dummy' => $response['data']]);
    }
}
