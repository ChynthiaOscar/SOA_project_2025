<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\NamekoClient;

class ReviewController extends Controller
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
    }    /**
     * Show the main review listing page.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */     public function index(Request $request)
        {
            try {
                // Get member_id from request or use default value 1
                $memberId = $request->input('member_id', 1);
                
                Log::info('ReviewController@index: Fetching member orders and reviews', ['member_id' => $memberId]);
                
                // Get all orders for this member (sorted by newest)
                $ordersResult = $this->namekoClient->get("api/mock/orders/{$memberId}");
                $orders = [];
                if (isset($ordersResult['success']) && $ordersResult['success'] && isset($ordersResult['data'])) {
                    $orders = $ordersResult['data'];
                    // Sort by newest (created_at desc)
                    usort($orders, function($a, $b) {
                        return strtotime($b['created_at'] ?? 0) - strtotime($a['created_at'] ?? 0);
                    });
                }
                
                // Get all reviews by this member using the direct endpoint
                $reviewsResult = $this->namekoClient->get("api/members/{$memberId}/reviews/direct");
                $reviews = [];
                if (isset($reviewsResult['success']) && $reviewsResult['success'] && isset($reviewsResult['data'])) {
                    $reviews = $reviewsResult['data'];
                }
                
                // Get all ratings by this member
                $ratingsResult = $this->namekoClient->get("api/members/{$memberId}/ratings/direct");
                $ratings = [];
                if (isset($ratingsResult['success']) && $ratingsResult['success'] && isset($ratingsResult['data'])) {
                    $ratings = $ratingsResult['data'];
                }                // Buat daftar ID pesanan yang telah direview
                $reviewedOrderIds = [];
                foreach ($reviews as $review) {
                    if (isset($review['Order_order_id'])) {
                        $reviewedOrderIds[] = $review['Order_order_id'];
                    }
                }
                
                // Pisahkan pesanan menjadi yang sudah direview dan belum direview
                $reviewedOrders = [];
                $unreviewedOrders = [];
                
                foreach ($orders as $order) {
                    if (isset($order['order_id'])) {
                        $orderId = $order['order_id'];
                        if (in_array($orderId, $reviewedOrderIds)) {
                            $reviewedOrders[] = $order;
                        } else {
                            $unreviewedOrders[] = $order;
                        }
                    } else {
                        // Jika tidak ada order_id, anggap belum direview
                        $unreviewedOrders[] = $order;
                    }
                }
                
                // Debug logging untuk membantu debugging
                Log::debug('ReviewController@index: Order and review data', [
                    'all_order_count' => count($orders),
                    'reviewed_order_count' => count($reviewedOrders),
                    'unreviewed_order_count' => count($unreviewedOrders),
                    'reviewed_order_ids' => $reviewedOrderIds
                ]);
                
                // Konversi nilai decimal ke string untuk keamanan
                if (!empty($orders)) {
                    array_walk_recursive($orders, function(&$value) {
                        if (is_object($value) && method_exists($value, '__toString')) {
                            $value = (string)$value;
                        }
                    });
                }
                
                // Ambil filter dari query string, default ke "unreviewed"
                $filter = $request->query('filter', 'unreviewed');
                
                Log::info('ReviewController@index: Processing completed', [
                    'filter' => $filter,
                    'total_order_count' => count($orders),
                    'reviewed_count' => count($reviewedOrders),
                    'unreviewed_count' => count($unreviewedOrders)
                ]);
                
                return view('reviews.index', [
                    'memberId' => $memberId,
                    'orders' => $filter === 'reviewed' ? $reviewedOrders : $unreviewedOrders,
                    'allOrders' => $orders,
                    'reviewedOrders' => $reviewedOrders,
                    'unreviewedOrders' => $unreviewedOrders,
                    'reviews' => $reviews,
                    'ratings' => $ratings,
                    'reviewedOrderIds' => $reviewedOrderIds,
                    'currentFilter' => $filter,
                    'error' => null
                ]);
                
                // --- PERUBAHAN SELESAI DI SINI ---
                
            } catch (\Exception $e) {
                Log::error('ReviewController@index: Exception', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                $error = 'An error occurred: ' . $e->getMessage();
                // Inisialisasi variabel agar tidak error di view
                $orders = [];
                $reviews = [];
                $ratings = [];
                $reviewedOrderIds = [];
                
                return view('reviews.index', compact('orders', 'reviews', 'ratings', 'reviewedOrderIds', 'error', 'memberId'));
            }
        }   /**
     * Show the review form page.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */    public function showReviewForm(Request $request)
    {
        $orderId = $request->input('order_id');
        $memberId = $request->input('member_id', 1); // Default to member ID 1
        $orderData = null;
        $menuItems = [];
        $orders = []; // Initialize orders array to avoid undefined variable error
          if ($orderId) {
            // First try to get order details from the same mock API used on the index page
            $mockOrdersResult = $this->namekoClient->get("api/mock/orders/{$memberId}");
            $mockOrders = [];
            
            if (isset($mockOrdersResult['success']) && $mockOrdersResult['success'] && isset($mockOrdersResult['data'])) {
                $mockOrders = $mockOrdersResult['data'];
                
                // Find the specific order by order_id
                foreach ($mockOrders as $order) {
                    if (isset($order['order_id']) && $order['order_id'] == $orderId) {                        // Just use the order data directly with its items
                        $orderData = $order;
                        
                        Log::debug('Found order in mock data', ['orderId' => $orderId, 'order' => $orderData]);
                        break;
                    }
                }
            }
            
            // If order wasn't found in mock data, use the original endpoint as fallback
            if (!$orderData) {
                Log::debug('Order not found in mock data, trying original endpoint', ['orderId' => $orderId]);
                
                $result = $this->namekoClient->get("orders/{$orderId}/reviews");
                $orderData = $result['success'] ? ($result['data'] ?? null) : null;
                
                // If we don't have member_id from request, try to get it from the order
                if ($request->input('member_id') === null && $orderData && isset($orderData['order']) && isset($orderData['order']['Member_member_id'])) {
                    $memberId = $orderData['order']['Member_member_id'];
                }
            }
        } else {
            // If no order_id provided, get all orders for this member
            $ordersResult = $this->namekoClient->get("api/mock/orders/{$memberId}");
            if (isset($ordersResult['success']) && $ordersResult['success'] && isset($ordersResult['data'])) {
                $orders = $ordersResult['data'];
                // Sort by newest
                usort($orders, function($a, $b) {
                    return strtotime($b['created_at'] ?? 0) - strtotime($a['created_at'] ?? 0);
                });
            }
            
            // Get menu items for ratings
            $menuItemsResult = $this->namekoClient->get("api/menus");
            if (isset($menuItemsResult['success']) && $menuItemsResult['success'] && isset($menuItemsResult['data'])) {
                $menuItems = $menuItemsResult['data'];
            }
        }
        
        // Add debugging to help identify issues
        Log::debug('ReviewController@showReviewForm: Data for view', [
            'orderId' => $orderId,
            'memberId' => $memberId,
            'hasOrderData' => !empty($orderData),
            'ordersCount' => count($orders),
            'menuItemsCount' => count($menuItems)
        ]);
        
        return view('reviews.form', compact('orderId', 'orderData', 'memberId', 'orders', 'menuItems'));
    }    /**
     * Show the review history page for a member.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */    public function showReviewHistory(Request $request)
    {
        $memberId = $request->input('member_id', 1); // Default to member ID 1
        $reviewHistory = null;
        $orders = null;
          // Get reviews directly by member_id (updated endpoint)
        $reviewResult = $this->namekoClient->get("api/members/{$memberId}/reviews/direct");
        $reviewHistory = $reviewResult['success'] ? ($reviewResult['data'] ?? []) : [];
          // Get ratings directly by member_id (new endpoint)
        $ratingsResult = $this->namekoClient->get("api/members/{$memberId}/ratings/direct");
        Log::debug('Ratings result from API', ['result' => $ratingsResult]);
        $ratings = $ratingsResult['success'] ? ($ratingsResult['data'] ?? []) : [];
        
        // Get menus to map menu names
        $menusResult = $this->namekoClient->get("api/menus");
        $menus = $menusResult['success'] ? ($menusResult['data'] ?? []) : [];
        
        // Add menu names to ratings if needed
        if (!empty($ratings) && !empty($menus)) {
            $menuMap = [];
            foreach ($menus as $menu) {
                if (isset($menu['menu_id']) && isset($menu['menu_name'])) {
                    $menuMap[$menu['menu_id']] = $menu['menu_name'];
                }
            }
            
            foreach ($ratings as &$rating) {
                if (isset($rating['Menu_menu_id']) && !isset($rating['Menu_menu_name']) && isset($menuMap[$rating['Menu_menu_id']])) {
                    $rating['Menu_menu_name'] = $menuMap[$rating['Menu_menu_id']];
                }
            }
            unset($rating); // Break the reference
        }
        
        // Get orders for this member
        $ordersResult = $this->namekoClient->get("api/mock/orders/{$memberId}");
        $orders = $ordersResult['success'] ? ($ordersResult['data'] ?? []) : [];
        
        // Sort orders by newest
        usort($orders, function($a, $b) {
            return strtotime($b['created_at'] ?? 0) - strtotime($a['created_at'] ?? 0);
        });
        
        // Get member details
        $memberResult = $this->namekoClient->get("api/members/{$memberId}");
        $member = $memberResult['success'] ? ($memberResult['data'] ?? null) : null;
        
        return view('reviews.history', compact('memberId', 'reviewHistory', 'ratings', 'orders', 'member'));
    }
    
    /**
     * Create review and rating.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */    public function storeReviewAndRating(Request $request)
    {
        try {
            // Log incoming request data to help with debugging
            Log::debug('ReviewController@storeReviewAndRating: Request data', [
                'data' => $request->all()
            ]);
            
            // Validate the incoming request
            $validated = $request->validate([
                'review_text' => 'nullable|string|max:1000',
                'Order_order_id' => 'required|integer',
                'Member_member_id' => 'required|integer',
                'ratings' => 'nullable|array',
                'ratings.*.rating' => 'required|integer|between:1,5',
                'ratings.*.Menu_menu_id' => 'required|integer',
                'ratings.*.Order_order_id' => 'required|integer',
                // Member_member_id will be added to each rating before sending to API
            ]);
            
            // Make sure Member_member_id is added to each rating
            if (isset($validated['ratings']) && is_array($validated['ratings'])) {
                foreach ($validated['ratings'] as &$rating) {
                    $rating['Member_member_id'] = $validated['Member_member_id'];
                }
            }
            
            // Log the validated data that will be sent to the API
            Log::debug('ReviewController@storeReviewAndRating: Validated data for API', [
                'data' => $validated
            ]);
              $result = $this->namekoClient->post('reviews/create', $validated);
            
            // Log API response
            Log::debug('ReviewController@storeReviewAndRating: API response', [
                'response' => $result
            ]);
            
            // Special handling for "already exists" message but with successful data insert
            // This handles a quirk in the backend API where it may return an "already exists" message
            // even though the data was successfully saved
            $messageContainsAlreadyExists = isset($result['message']) && 
                is_string($result['message']) && 
                stripos($result['message'], 'already exists') !== false;
                
            // If the API says "success" or if it contains "already exists" (backend quirk)
            if ((isset($result['success']) && $result['success']) || $messageContainsAlreadyExists) {
                return response()->json([
                    'success' => true,
                    'message' => 'Review and ratings submitted successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Failed to submit review'
                ], 400);
            }        } catch (\Exception $e) {
            Log::error('ReviewController@storeReviewAndRating: Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Check if the error message contains "already exists"
            if (stripos($e->getMessage(), 'already exists') !== false) {
                // This is likely a duplicate submission that was actually successful
                return response()->json([
                    'success' => true,
                    'message' => 'Review has been submitted successfully'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
