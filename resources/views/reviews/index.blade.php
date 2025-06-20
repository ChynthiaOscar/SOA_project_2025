@extends('layouts.main')

@section('content')
<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-utensils"></i> Restaurant Reviews</h1>
        <p>Review and rate your recent dining experiences</p>
    </div>    <div class="flex justify-center gap-4 mb-6">
        <a href="{{ route('reviews.form') }}?member_id={{ $memberId }}" class="btn btn-primary">
            <i class="fas fa-star mr-1"></i> Write a Review
        </a>
        <a href="{{ route('reviews.history') }}?member_id={{ $memberId }}" class="btn btn-secondary">
            <i class="fas fa-history mr-1"></i> My Review History
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6 border border-gold/30 mb-8">
        @if(isset($error) && $error)
            <div class="bg-red-100 text-red-800 p-4 rounded-md mb-4">
                <h4 class="font-bold flex items-center"><i class="fas fa-exclamation-triangle mr-2"></i> Error</h4>
                <p class="my-2">{{ $error }}</p>
                <div class="mt-4">
                    <h5 class="font-semibold">Possible Solutions:</h5>
                    <ol class="list-decimal ml-5 mt-2 space-y-1">
                        <li>Verify Nameko service is running: <code class="bg-gray-100 px-1 py-0.5 rounded">nameko run backend.review_rating_service backend.http_gateway --config config.yaml</code></li>
                        <li>Check that your database connection is working</li>
                        <li>Ensure RabbitMQ is running and accessible</li>
                        <li>Verify NAMEKO_GATEWAY_URL in .env is set to <code class="bg-gray-100 px-1 py-0.5 rounded">http://localhost:8000</code></li>
                    </ol>
                </div>
            </div>        @else
            <!-- Filter Controls -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-maroon">Your Orders</h2>
                
                <div class="flex gap-2">
                    <span href="{{ route('reviews.index', ['filter' => 'unreviewed', 'member_id' => $memberId]) }}" 
                        class="px-4 py-2 rounded-md text-sm font-medium {{ $currentFilter === 'unreviewed' ? 'bg-maroon text-gold' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        <i class="fas fa-clock mr-1"></i> Awaiting Review ({{ count($unreviewedOrders) }})
                    </span>
                    <span href="{{ route('reviews.index', ['filter' => 'reviewed', 'member_id' => $memberId]) }}" 
                        class="px-4 py-2 rounded-md text-sm font-medium {{ $currentFilter === 'reviewed' ? 'bg-maroon text-gold' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        <i class="fas fa-check mr-1"></i> Reviewed ({{ count($reviewedOrders) }})
                    </span>
                </div>
            </div>
            
            @if($currentFilter === 'unreviewed')
                <p class="text-gray-600 mb-4">These orders need your feedback. Share your experiences to help others!</p>
            @else
                <p class="text-gray-600 mb-4">You've already reviewed these orders. Thank you for your feedback!</p>
            @endif
            
            @if(is_array($orders) && count($orders) > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                        @php
                            // Ensure the order belongs to the current member
                            $orderMemberId = $order['Member_member_id'] ?? null;
                            $belongsToCurrentMember = $orderMemberId == $memberId;
                        @endphp
                        
                        @if($belongsToCurrentMember)
                            <div class="order-card p-4 border border-gold/20 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-semibold text-maroon text-lg">Order #{{ $order['order_id'] ?? 'N/A' }}</h3>
                                    <div class="review-date text-sm text-gray-600">{{ \Carbon\Carbon::parse($order['created_at'] ?? now())->diffForHumans() }}</div>
                                </div>
                                
                                @if(isset($order['items']) && count($order['items']) > 0)
                                <div class="mt-3 space-y-2">
                                    @foreach($order['items'] as $item)
                                        <div class="flex justify-between items-center border-b border-gold/10 pb-1">
                                            <div>
                                                <span class="font-medium">{{ $item['menu_name'] ?? 'Unknown Item' }}</span>
                                                <span class="text-sm text-gray-500 ml-2">x{{ $item['quantity'] ?? 1 }}</span>
                                            </div>
                                            <div class="text-maroon">Rp. {{ number_format($item['price'] ?? 0) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                              <div class="mt-3 flex justify-between items-center">
                                <div>
                                    @php
                                        $orderType = isset($order['order_type']) ? (is_numeric($order['order_type']) ? (int)$order['order_type'] : $order['order_type']) : null;
                                        $isDineIn = $orderType === 1 || (is_string($orderType) && strtolower($orderType) === 'dine in');
                                    @endphp
                                    <span class="text-sm bg-{{ $isDineIn ? 'green' : 'blue' }}-100 text-{{ $isDineIn ? 'green' : 'blue' }}-800 py-1 px-2 rounded">
                                        {{ $isDineIn ? 'Dine In' : 'Take Away' }}
                                    </span>
                                </div>
                                <div class="text-lg font-semibold text-maroon">
                                    Total: Rp. {{ number_format($order['order_totalPayment'] ?? 0) }}
                                </div>
                            </div>                              <div class="mt-4 flex justify-end">
                                @if($currentFilter === 'unreviewed')
                                    <a href="{{ route('reviews.form') }}?order_id={{ $order['order_id'] }}&member_id={{ $memberId }}" 
                                       class="px-3 py-1 bg-maroon text-gold rounded text-sm hover:bg-maroon/90 transition-colors">
                                        <i class="fas fa-star mr-1"></i> Review Order
                                    </a>
                                @else
                                    <div class="px-3 py-1 bg-green-600 text-white rounded text-sm">
                                        <i class="fas fa-check mr-1"></i> Already Reviewed
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>            @else                <div class="p-4 bg-gold/10 rounded-lg text-center">
                    @if($currentFilter === 'unreviewed')
                        <p class="mb-2">You don't have any orders waiting for review.</p>
                        <p class="text-sm text-gray-600">All your orders have been reviewed or you haven't placed any orders yet.</p>
                    @else
                        <p class="mb-2">You haven't reviewed any orders yet.</p>
                        <p class="text-sm text-gray-600">Once you submit reviews, they'll appear here.</p>
                    @endif
                </div>
            @endif
        @endif
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6 border border-gold/30 mb-8">            <h2 class="text-xl font-semibold text-maroon mb-4">About Our Review System</h2>
            <div class="mb-4 text-sm">
                <p class="font-medium">Filter Stats:</p>
                <ul class="list-disc ml-5 mt-1">
                    <li>Total Orders: {{ count($allOrders ?? []) }}</li>
                    <li>Orders Awaiting Review: {{ count($unreviewedOrders ?? []) }}</li>
                    <li>Reviewed Orders: {{ count($reviewedOrders ?? []) }}</li>
                </ul>
            </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
            <div class="p-4 bg-gold/10 rounded-lg">
                <i class="fas fa-pencil-alt text-3xl text-maroon mb-2"></i>
                <h3 class="font-medium">Write Reviews</h3>
                <p class="text-sm">Share your dining experience with others</p>
            </div>
            <div class="p-4 bg-gold/10 rounded-lg">
                <i class="fas fa-star text-3xl text-maroon mb-2"></i>
                <h3 class="font-medium">Rate Menu Items</h3>
                <p class="text-sm">Give 1-5 stars to dishes you've tried</p>
            </div>
            <div class="p-4 bg-gold/10 rounded-lg">
                <i class="fas fa-history text-3xl text-maroon mb-2"></i>
                <h3 class="font-medium">Track History</h3>
                <p class="text-sm">Access all your past reviews and ratings</p>
            </div>
            <div class="p-4 bg-gold/10 rounded-lg">
                <i class="fas fa-chart-bar text-3xl text-maroon mb-2"></i>
                <h3 class="font-medium">See Statistics</h3>
                <p class="text-sm">View popular dishes and average ratings</p>
            </div>
        </div>
    </div>
</div>
@endsection