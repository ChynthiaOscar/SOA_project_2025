<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function ShowOVO(Request $request)
    {
        return view('pages.service_payment.OVO',compact('id', 'user_id', 'dp_amount'));
    }
    
    public function generateOvoQr(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer',
            'requester_type' => 'required|integer',
            'requester_id' => 'required|integer',
            'secondary_requester_id' => 'nullable|integer',
            'payment_method' => 'required|string',
            'payment_amount' => 'required|numeric',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'order123',
            ])->post('http://50.19.17.50:8002/payment', $data);

            if ($response->successful()) {
                $apiData = $response->json();

                return response()->json([
                    'status' => 'success',
                    'qr_url' => $apiData['payment_info'],
                    'payment_id' => $apiData['id'],
                    'payment_status' => $apiData['status'],
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'API gagal: ' . $response->body(),
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function ShowTunai(Request $request)
    {
        return view('pages.service_payment.Tunai');
    }

    public function confirmPaymentTunai(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer',
            'requester_type' => 'required|integer',
            'requester_id' => 'required|integer',
            'secondary_requester_id' => 'nullable|integer',
            'payment_method' => 'required|string',
            'payment_amount' => 'required|numeric',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'order123',
            ])->post('http://50.19.17.50:8002/payment', $data);

            if ($response->successful()) {
                $apiData = $response->json();

                return response()->json([
                    'status' => 'success',
                    'va-number' => $apiData['payment_info'],
                    'payment_id' => $apiData['id'],
                    'payment_status' => $apiData['status'],
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'API gagal: ' . $response->body(),
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function ShowBCA_VA(Request $request)
    {
        return view('pages.service_payment.BCA_VA');
    }

    public function generateBCA_VA(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer',
            'requester_type' => 'required|integer',
            'requester_id' => 'required|integer',
            'secondary_requester_id' => 'nullable|integer',
            'payment_method' => 'required|string',
            'payment_amount' => 'required|numeric',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'order123',
            ])->post('http://50.19.17.50:8002/payment', $data);

            if ($response->successful()) {
                $apiData = $response->json();

                return response()->json([
                    'status' => 'success',
                    'va-number' => $apiData['payment_info'],
                    'payment_id' => $apiData['id'],
                    'payment_status' => $apiData['status'],
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'API gagal: ' . $response->body(),
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function ShowGopay(Request $request)
    {
        return view('pages.service_payment.Gopay');
    }

    public function generateGopayQr(Request $request)
    {
        // Simulasi generate QR (bisa dari API OVO / Midtrans / Xendit dll)
        // $qrImageUrl = asset('images/dummyQrCode.png'); // contoh dari public/images

        return response()->json([
            'status' => 'success',
            'qr_url' => url('assets/dummyQrCode.png')
        ]);
    }

    public function ShowQris(Request $request)
    {
        return view('pages.service_payment.Qris');
    }

    public function generateQrisQr(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer',
            'requester_type' => 'required|integer',
            'requester_id' => 'required|integer',
            'secondary_requester_id' => 'nullable|integer',
            'payment_method' => 'required|string',
            'payment_amount' => 'required|numeric',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'order123',
            ])->post('http://50.19.17.50:8002/payment', $data);

            if ($response->successful()) {
                $apiData = $response->json();

                return response()->json([
                    'status' => 'success',
                    'qr_url' => $apiData['payment_info'],
                    'payment_id' => $apiData['id'],
                    'payment_status' => $apiData['status'],
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'API gagal: ' . $response->body(),
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function ShowSuccess(Request $request)
    {
        return view('pages.service_payment.success');
    }


    public function cancelPayment(Request $request)
    {
        $paymentId = $request->input('payment_id');

        if (!$paymentId) {
            return response()->json(['status' => 'error', 'message' => 'payment_id wajib diisi'], 400);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'order123',
            ])->patch("http://50.19.17.50:8002/payment/{$paymentId}/cancel");

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment berhasil dibatalkan.',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal membatalkan payment: ' . $response->body(),
                ], $response->status());
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getStatustoPayment(Request $request)
    {

        $paymentId = $request->input('payment_id');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'order123',
            ])->get("http://50.19.17.50:8002/payment/{$paymentId}/status");

            if ($response->successful()) {
                $data = $response->json();

                // Tangani status integer
                $status = $data['status'] ?? null;

                if ($status === 2) {
                    // Sukses dibayar
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Pembayaran berhasil.',
                        'data' => $data
                    ]);
                } elseif ($status === 3) {
                    // Dibatalkan
                    return response()->json([
                        'status' => 'cancelled',
                        'message' => 'Pembayaran dibatalkan.',
                        'data' => $data
                    ]);
                } elseif ($status === 1) {
                    // Masih pending
                    return response()->json([
                        'status' => 'pending',
                        'message' => 'Pembayaran masih menunggu.',
                        'data' => $data
                    ]);
                } else {
                    return response()->json([
                        'status' => 'unknown',
                        'message' => 'Status tidak dikenali.',
                        'data' => $data
                    ]);
                }

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menghubungi API: ' . $response->body()
                ], $response->status());
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}