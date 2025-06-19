<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VoucherController extends Controller
{
  private $gateway = 'http://100.24.124.206:8002';

  public function index()
  {
    $response = Http::withHeaders([
      'Accept' => 'application/json',
      'Content-Type' => 'application/json'
    ])
      ->get($this->gateway . '/promo/all');
    $result = $response->json();
    $vouchers = isset($result['vouchers']) ? $result['vouchers'] : [];
    return view('pages.voucher-promo.voucher.index', ['vouchers' => $vouchers]);
  }

  public function create()
  {
    return view('pages.voucher-promo.voucher.createVoucher');
  }

  public function store(Request $request)
  {
    $request->validate([
      'promo_code' => 'required|max:50',
      'description' => 'required|max:100',
      'promo_value' => 'required|integer',
      'status' => 'required'
    ]);

    $data = [
      'promo_code' => $request->input('promo_code'),
      'description' => $request->input('description'),
      'promo_value' => (int)$request->input('promo_value'),
      'status' => filter_var($request->input('status'), FILTER_VALIDATE_BOOLEAN)
    ];

    $response = Http::withHeaders([
      'Accept' => 'application/json',
      'Content-Type' => 'application/json'
    ])
      ->asJson()
      ->post($this->gateway . '/voucher/create', [
        'data' => $data
      ]);
    return redirect('/promo')->with('success', 'Voucher berhasil ditambahkan!');
  }

  public function edit($id)
  {
    $response = Http::withHeaders([
      'Accept' => 'application/json',
      'Content-Type' => 'application/json'
    ])
      ->get($this->gateway . '/promo/all');
    $result = $response->json();
    $vouchers = isset($result['vouchers']) ? $result['vouchers'] : [];
    $voucher = collect($vouchers)->firstWhere('id', $id);

    if (!$voucher) {
      return redirect('/promo')->with('error', 'Voucher tidak ditemukan!');
    }

    return view('pages.voucher-promo.voucher.editVoucher', compact('voucher'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'promo_code' => 'required|max:50',
      'description' => 'required|max:100',
      'promo_value' => 'required|integer',
      'status' => 'required'
    ]);

    $data = [
      'promo_code' => $request->input('promo_code'),
      'description' => $request->input('description'),
      'promo_value' => (int)$request->input('promo_value'),
      'status' => filter_var($request->input('status'), FILTER_VALIDATE_BOOLEAN)
    ];

    $response = Http::withHeaders([
      'Accept' => 'application/json',
      'Content-Type' => 'application/json'
    ])
      ->asJson()
      ->put($this->gateway . '/voucher/update/' . $id, $data);

    return redirect('/promo')->with('success', 'Voucher berhasil diperbarui!');
  }

  public function destroy($id)
  {
    $response = Http::withHeaders([
      'Accept' => 'application/json',
      'Content-Type' => 'application/json'
    ])
      ->delete($this->gateway . '/voucher/delete/' . $id);

    return redirect('/promo')->with('success', 'Voucher berhasil dihapus!');
  }
}
