<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NamekoClient;

class ReviewRatingController extends Controller
{
    protected $namekoClient;

    /**
     * Create a new controller instance.
     *
     * @param NamekoClient $namekoClient
     * @return void
     */
    public function __construct(NamekoClient $namekoClient)
    {
        $this->namekoClient = $namekoClient;
    }

    /**
     * Get all reviews with pagination.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 50);
        $offset = $request->input('offset', 0);
        
        $result = $this->namekoClient->get('api/reviews', [
            'limit' => $limit,
            'offset' => $offset
        ]);
        
        return response()->json($result);
    }

    /**
     * Create a new review and rating.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $result = $this->namekoClient->post('api/reviews/create', $data);
        
        return response()->json($result);
    }

    /**
     * Update an existing review.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateReview(Request $request, $id)
    {
        $data = $request->all();
        $result = $this->namekoClient->put("api/reviews/{$id}", $data);
        
        return response()->json($result);
    }

    /**
     * Delete a review.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteReview($id)
    {
        $result = $this->namekoClient->delete("api/reviews/{$id}");
        
        return response()->json($result);
    }

    /**
     * Update an existing rating.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRating(Request $request, $id)
    {
        $data = $request->all();
        $result = $this->namekoClient->put("api/ratings/{$id}", $data);
        
        return response()->json($result);
    }    /**
     * Delete a rating.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRating($id)
    {
        $result = $this->namekoClient->delete("api/ratings/{$id}");
        
        return response()->json($result);
    }

    /**
     * Get reviews and ratings for a specific order.
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderReviews($orderId)
    {
        $result = $this->namekoClient->get("api/orders/{$orderId}/reviews");
        
        return response()->json($result);
    }

    /**
     * Get all reviews and ratings for a member.
     *
     * @param int $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberReviews($memberId)
    {
        $result = $this->namekoClient->get("api/members/{$memberId}/reviews");
        
        return response()->json($result);
    }

    /**
     * Get rating statistics for a menu.
     *
     * @param int $menuId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenuRatingStats($menuId)
    {
        $result = $this->namekoClient->get("api/menus/{$menuId}/rating-stats");
        
        return response()->json($result);
    }

    /**
     * Get member orders (mock endpoint for testing).
     *
     * @param int $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberOrders($memberId)
    {
        // First try to get orders via the API
        $result = $this->namekoClient->get("api/mock/orders/{$memberId}");
        
        if (!isset($result['success']) || !$result['success']) {
            // If API fails, we'll create mock data based on member ID
            $orders = [];
            
            // For member_id = 1, we'll return orders 1, 2, and a new order 4
            if ($memberId == 1) {                $orders = [
                    [
                        'order_id' => 1,
                        'order_totalPayment' => 150000,
                        'order_type' => 1, // Dine In
                        'created_at' => now()->subDays(2)->toISOString(),
                        'Member_member_id' => 1,
                        'items' => [
                            ['menu_id' => 1, 'menu_name' => 'Nasi Goreng Spesial', 'quantity' => 2, 'price' => 25000],
                            ['menu_id' => 2, 'menu_name' => 'Ayam Bakar', 'quantity' => 1, 'price' => 45000],
                            ['menu_id' => 3, 'menu_name' => 'Es Teh Manis', 'quantity' => 2, 'price' => 5000]
                        ]
                    ],
                    [
                        'order_id' => 2,
                        'order_totalPayment' => 75000,
                        'order_type' => 2, // Take Away
                        'created_at' => now()->subDays(1)->toISOString(),
                        'Member_member_id' => 1,
                        'items' => [
                            ['menu_id' => 5, 'menu_name' => 'Sate Ayam', 'quantity' => 1, 'price' => 35000],
                            ['menu_id' => 6, 'menu_name' => 'Soto Ayam', 'quantity' => 1, 'price' => 30000],
                            ['menu_id' => 7, 'menu_name' => 'Es Jeruk', 'quantity' => 2, 'price' => 5000]
                        ]
                    ],
                    [
                        'order_id' => 4, // New order that hasn't been reviewed yet
                        'order_totalPayment' => 120000,
                        'order_type' => 1, // Dine In
                        'created_at' => now()->subHours(3)->toISOString(), // Very recent order
                        'Member_member_id' => 1,
                        'items' => [
                            ['menu_id' => 9, 'menu_name' => 'Steak Tenderloin', 'quantity' => 1, 'price' => 95000],
                            ['menu_id' => 10, 'menu_name' => 'French Fries', 'quantity' => 1, 'price' => 20000],
                            ['menu_id' => 7, 'menu_name' => 'Es Jeruk', 'quantity' => 1, 'price' => 5000]
                        ]
                    ],                    [
                        'order_id' => 5, // Another new order that hasn't been reviewed yet
                        'order_totalPayment' => 85000,
                        'order_type' => 2, // Take Away
                        'created_at' => now()->subHours(6)->toISOString(),
                        'Member_member_id' => 1,
                        'items' => [
                            ['menu_id' => 2, 'menu_name' => 'Ayam Bakar', 'quantity' => 1, 'price' => 45000],
                            ['menu_id' => 6, 'menu_name' => 'Soto Ayam', 'quantity' => 1, 'price' => 30000],
                            ['menu_id' => 3, 'menu_name' => 'Es Teh Manis', 'quantity' => 2, 'price' => 5000]
                        ]
                    ]
                ];
            } 
            // For member_id = 2, we'll return only order 3
            else if ($memberId == 2) {
                $orders = [
                    [
                        'order_id' => 3,
                        'order_totalPayment' => 95000,
                        'order_type' => 1, // Dine In
                        'created_at' => now()->subDays(3)->toISOString(),
                        'Member_member_id' => 2,
                        'items' => [
                            ['menu_id' => 8, 'menu_name' => 'Seafood Platter', 'quantity' => 1, 'price' => 85000],
                            ['menu_id' => 3, 'menu_name' => 'Es Teh Manis', 'quantity' => 2, 'price' => 5000]
                        ]
                    ]
                ];
            }
            // For any other member ID, return an empty array
            
            $result = ['success' => true, 'data' => $orders];
        }
        
        // Filter to ensure orders only belong to the requested member
        if (isset($result['success']) && $result['success'] && isset($result['data']) && is_array($result['data'])) {
            $result['data'] = array_filter($result['data'], function($order) use ($memberId) {
                return isset($order['Member_member_id']) && $order['Member_member_id'] == $memberId;
            });
            // Reindex array after filtering
            $result['data'] = array_values($result['data']);
        }
        
        return response()->json($result);
    }
    
    /**
     * Get member reviews directly (not through orders).
     *
     * @param int $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberReviewsDirect($memberId)
    {
        $result = $this->namekoClient->get("api/members/{$memberId}/reviews/direct");
        
        return response()->json($result);
    }
    
    /**
     * Get member ratings directly (not through orders).
     *
     * @param int $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberRatingsDirect($memberId)
    {
        $result = $this->namekoClient->get("api/members/{$memberId}/ratings/direct");
        
        return response()->json($result);
    }
    
    /**
     * Get member details.
     *
     * @param int $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberDetails($memberId)
    {
        $result = $this->namekoClient->get("api/members/{$memberId}");
        
        return response()->json($result);
    }
    
    /**
     * Get all menus.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllMenus()
    {
        $result = $this->namekoClient->get("api/menus");
        
        if (!isset($result['success']) || !$result['success']) {
            // Provide mock menu data if API fails
            $result = [
                'success' => true,
                'data' => [
                    ['menu_id' => 1, 'menu_name' => 'Nasi Goreng Spesial', 'price' => 25000],
                    ['menu_id' => 2, 'menu_name' => 'Ayam Bakar', 'price' => 45000],
                    ['menu_id' => 3, 'menu_name' => 'Es Teh Manis', 'price' => 5000],
                    ['menu_id' => 5, 'menu_name' => 'Sate Ayam', 'price' => 35000],
                    ['menu_id' => 6, 'menu_name' => 'Soto Ayam', 'price' => 30000],
                    ['menu_id' => 7, 'menu_name' => 'Es Jeruk', 'price' => 5000],
                    ['menu_id' => 8, 'menu_name' => 'Seafood Platter', 'price' => 85000],
                    ['menu_id' => 9, 'menu_name' => 'Steak Tenderloin', 'price' => 95000],
                    ['menu_id' => 10, 'menu_name' => 'French Fries', 'price' => 20000]
                ]
            ];
        }
        
        return response()->json($result);
    }
}
