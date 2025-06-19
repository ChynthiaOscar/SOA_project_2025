<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    private $gatewayUrl;

    public function __construct()
    {
        // Set your gateway URL - adjust as needed
        $this->gatewayUrl = 'http://54.160.170.89:8002';
    }

    public function index()
    {
        return view('pages.service-delivery.foradmin.index');
    }

    public function userIndex(Request $request)
    {
        $orderId = $request->input('order_id', null);
        $orderDetails = [];

        // You can fetch actual order details if needed
        if ($orderId) {
            $orderDetails = [
                [
                    'menu_name' => 'Sample Menu Item',
                    'order_detail_quantity' => 2,
                    'menu_price' => 50000,
                    'order_detail_note' => 'Extra spicy'
                ]
            ];
        }

        return view('pages.service-delivery.foruser.index', [
            'orderId' => $orderId,
            'orderDetails' => $orderDetails,
            'order' => ['member_id' => 1]
        ]);
    }

    // API proxy methods to connect to the Gateway
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
            return $response->json();
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
    // Add this method to your DeliveryController class

    public function testConnection()
    {
        try {
            $response = Http::get($this->gatewayUrl . '/delivery');

            return view('pages.service-delivery.test-connection', [
                'status' => $response->successful() ? 'success' : 'error',
                'message' => $response->successful()
                    ? 'Successfully connected to Gateway service'
                    : 'Gateway returned an error response',
                'response' => $response->json(),
                'statusCode' => $response->status()
            ]);
        } catch (\Exception $e) {
            return view('pages.service-delivery.test-connection', [
                'status' => 'error',
                'message' => 'Failed to connect to Gateway service',
                'error' => $e->getMessage()
            ]);
        }
    }
}
