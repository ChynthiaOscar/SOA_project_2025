<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function ShowOVO(Request $request)
    {
        return view('pages.service_payment.OVO');
    }
    
    public function generateOvoQr(Request $request)
    {
        // Simulasi generate QR (bisa dari API OVO / Midtrans / Xendit dll)
        // $qrImageUrl = asset('images/dummyQrCode.png'); // contoh dari public/images

        return response()->json([
            'status' => 'success',
            'qr_url' => url('assets/dummyQrCode.png')
        ]);
    }

    public function ShowTunai(Request $request)
    {
        return view('pages.service_payment.Tunai');
    }

    public function confirmPaymentTunai(Request $request)
    {
        return view('pages.service_payment.Tunai');
    }


    public function ShowBCA_VA(Request $request)
    {
        return view('pages.service_payment.BCA_VA');
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
        // Simulasi generate QR (bisa dari API OVO / Midtrans / Xendit dll)
        // $qrImageUrl = asset('images/dummyQrCode.png'); // contoh dari public/images

        return response()->json([
            'status' => 'success',
            'qr_url' => url('assets/dummyQrCode.png')
        ]);
    }

    public function ShowSuccess(Request $request)
    {
        return view('pages.service_payment.success');
    }
}
