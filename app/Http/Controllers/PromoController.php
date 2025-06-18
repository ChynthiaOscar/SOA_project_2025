<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PromoController extends Controller
{
    private $gateway = 'http://127.0.0.1:8000/api';

    public function index()
    {
        $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->get($this->gateway . '/all');
        $result = $response->json();
        $promos = isset($result['promos']) ? $result['promos'] : [];
        return view('pages.voucher-promo.promo.index', ['promos' => $promos]);
    }

    public function create()
    {
        return view('pages.voucher-promo.promo.createPromo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|max:100',
            'promo_value' => 'required|integer',
            'value_type' => 'required|in:fixed,percentage',
            'minimum_order' => 'required|integer',
            'usage_limit' => 'required|integer',
            'status' => 'required'
        ]);

        $data = [
            'description' => $request->input('description'),
            'promo_value' => (int)$request->input('promo_value'),
            'value_type' => $request->input('value_type'),
            'minimum_order' => (int)$request->input('minimum_order'),
            'usage_limit' => (int)$request->input('usage_limit'),
            'status' => filter_var($request->input('status'), FILTER_VALIDATE_BOOLEAN),
            'usage' => 0
        ];

        $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->asJson()
            ->post($this->gateway . '/create_promo', [
                'data' => $data
            ]);
        return redirect('/promo')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->get($this->gateway . '/all');
        $result = $response->json();
        $promos = isset($result['promos']) ? $result['promos'] : [];
        $promo = collect($promos)->firstWhere('id', $id);

        if (!$promo) {
            return redirect('/promo')->with('error', 'Promo tidak ditemukan!');
        }

        return view('pages.voucher-promo.promo.editPromo', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|max:100',
            'promo_value' => 'required|integer',
            'value_type' => 'required|in:fixed,percentage',
            'minimum_order' => 'required|integer',
            'usage_limit' => 'required|integer',
            'status' => 'required'
        ]);

        $data = [
            'description' => $request->input('description'),
            'promo_value' => (int)$request->input('promo_value'),
            'value_type' => $request->input('value_type'),
            'minimum_order' => (int)$request->input('minimum_order'),
            'usage_limit' => (int)$request->input('usage_limit'),
            'status' => filter_var($request->input('status'), FILTER_VALIDATE_BOOLEAN)
        ];

        $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->asJson()
            ->post($this->gateway . '/update_promo', [
                'promo_id' => $id,
                'data' => $data
            ]);
        return redirect('/promo')->with('success', 'Promo berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->asJson()
            ->post($this->gateway . '/delete_promo', [
                'promo_id' => $id
            ]);
        return redirect('/promo')->with('success', 'Promo berhasil dihapus!');
    }
}