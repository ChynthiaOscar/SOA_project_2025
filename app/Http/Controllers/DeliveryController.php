<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class DeliveryController extends Controller
{
    private $gatewayUrl;

    public function __construct()
    {
        // Set your gateway URL - adjust as needed
        $this->gatewayUrl = 'http://localhost:8000';
    }

    public function index()
    {
        try {
            $response = Http::get($this->gatewayUrl . '/delivery');
            $data = $response->json();

            // Ambil array deliveries dari response
            $deliveries = $data['data']['data'] ?? [];

            return view('pages.service-delivery.foradmin.index', [
                'deliveries' => $deliveries
            ]);
        } catch (\Exception $e) {
            return view('pages.service-delivery.foradmin.index', [
                'deliveries' => [],
                'error' => $e->getMessage()
            ]);
        }
    }

    // public function userIndex(Request $request)
    // {
    //     $orderId = $request->input('order_id', null);
    //     $orderDetails = [];

    //     if ($orderId) {
    //         $orderDetails = [
    //             [
    //                 'menu_name' => 'Sample Menu Item',
    //                 'order_detail_quantity' => 2,
    //                 'menu_price' => 50000,
    //                 'order_detail_note' => 'Extra spicy'
    //             ]
    //         ];
    //     }

    //     return view('pages.service-delivery.foruser.index', [
    //         'orderId' => $orderId,
    //         'orderDetails' => $orderDetails,
    //         'order' => ['member_id' => 1]
    //     ]);
    // }

    public function userIndex(Request $request)
    {
        $orderId = $request->input('orderId', 1);
        $orderDetails = [
            [
                'menu_name' => 'Nasi Goreng',
                'order_detail_quantity' => 2,
                'menu_price' => 20000,
                'order_detail_note' => 'Pedas'
            ]
        ];
        $order = ['member_id' => 123];
        return view('pages.service-delivery.foruser.index', compact('orderId', 'orderDetails', 'order'));
    }
    public function getAllDeliveries()
    {
        try {
            $response = Http::get($this->gatewayUrl . '/delivery');
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDeliveryByStatus($status)
    {
        try {
            $response = Http::get($this->gatewayUrl . '/delivery/' . $status);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDeliveryById($id)
    {
        try {
            $response = Http::get($this->gatewayUrl . '/delivery/' . $id);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createDelivery(Request $request)
    {
        try {
            $response = Http::post($this->gatewayUrl . '/delivery', $request->all());
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchLocation(Request $request)
    {
        try {
            $response = Http::post($this->gatewayUrl . '/search', $request->all());
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDistance(Request $request)
    {
        try {
            $response = Http::post($this->gatewayUrl . '/distance', $request->all());
            $data = $response->json();

            if (isset($data['distance_km'])) {
                $data['distance'] = $data['distance_km'];
                $data['price'] = round($data['distance_km'] * 500); // contoh per km
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus($id, Request $request)
    {
        try {
            $response = Http::put($this->gatewayUrl . '/delivery/' . $id . '/status', $request->all());
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateDelivery($id, Request $request)
    {
        try {
            $response = Http::put($this->gatewayUrl . '/delivery/' . $id, $request->all());
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteDelivery($id)
    {
        try {
            $response = Http::delete($this->gatewayUrl . '/delivery/' . $id);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
