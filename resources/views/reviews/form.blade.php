@extends('layouts.main')

@section('content')
<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-star"></i> Beri Review & Rating</h1>
        <p>Bagikan pengalaman makan Anda dengan memberikan review dan rating</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 border border-gold/30">        @if (!$orderId)
            <form id="orderSelectForm" class="mb-4">
                <input type="hidden" name="member_id" value="{{ $memberId }}">
                <div class="form-group">
                    <label for="order_id">Pilih Pesanan:</label>
                    <select class="form-control" id="order_id" name="order_id" required>
                        <option value="">-- Pilih Pesanan --</option>                        @if(isset($orders) && is_array($orders) && count($orders) > 0)
                            @foreach($orders as $order)
                                @php
                                    // Ensure the order belongs to the current member
                                    $orderMemberId = $order['Member_member_id'] ?? null;
                                    $belongsToCurrentMember = $orderMemberId == $memberId;
                                @endphp
                                
                                @if($belongsToCurrentMember)
                                    <option value="{{ $order['order_id'] }}">
                                        Order #{{ $order['order_id'] }} - {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }} - Rp. {{ number_format($order['order_totalPayment']) }}
                                    </option>
                                @endif
                            @endforeach
                        @else
                            <option value="1">Order #1 - Rp. 150,000</option>
                            <option value="2">Order #2 - Rp. 75,000</option>
                        @endif
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Lanjutkan
                    </button>
                </div>
            </form>
        @else            <form id="reviewForm">
                <input type="hidden" name="Order_order_id" value="{{ $orderId }}">
                <input type="hidden" name="Member_member_id" value="{{ $memberId ?? 1 }}">
                  <div id="orderDetails" class="bg-cream/30 rounded-lg p-4 mb-6">
                    <h3 class="text-xl font-semibold text-maroon mb-3">Detail Pesanan #{{ $orderId }}</h3>
                    
                    @if ($orderData)
                        <div id="orderItemsList" class="space-y-3">
                            @if (isset($orderData['order_items']))
                                <!-- Format from original API -->
                                @foreach($orderData['order_items'] as $item)
                                    <div class="flex justify-between items-center border-b border-gold/20 pb-2">
                                        <div class="flex-1">
                                            <h4 class="font-medium">{{ $item['menu_name'] }}</h4>
                                            <p class="text-sm text-gray-600">{{ $item['quantity'] }}x @Rp. {{ number_format($item['price']) }}</p>
                                        </div>
                                        <div class="text-maroon font-medium">
                                            Rp. {{ number_format($item['quantity'] * $item['price']) }}
                                        </div>
                                    </div>
                                @endforeach
                            @elseif (isset($orderData['items']))
                                <!-- Format from mock API -->
                                @foreach($orderData['items'] as $item)
                                    <div class="flex justify-between items-center border-b border-gold/20 pb-2">
                                        <div class="flex-1">
                                            <h4 class="font-medium">{{ $item['menu_name'] }}</h4>
                                            <p class="text-sm text-gray-600">{{ $item['quantity'] }}x @Rp. {{ number_format($item['price']) }}</p>
                                        </div>
                                        <div class="text-maroon font-medium">
                                            Rp. {{ number_format($item['quantity'] * $item['price']) }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @else
                        <!-- Mock menu items for testing -->
                        <div id="orderItemsList" class="space-y-3">
                            <div class="flex justify-between items-center border-b border-gold/20 pb-2">
                                <div class="flex-1">
                                    <h4 class="font-medium">Nasi Goreng Spesial</h4>
                                    <p class="text-sm text-gray-600">2x @Rp. 25,000</p>
                                </div>
                                <div class="text-maroon font-medium">
                                    Rp. 50,000
                                </div>
                            </div>
                            <div class="flex justify-between items-center border-b border-gold/20 pb-2">
                                <div class="flex-1">
                                    <h4 class="font-medium">Ayam Bakar</h4>
                                    <p class="text-sm text-gray-600">1x @Rp. 45,000</p>
                                </div>
                                <div class="text-maroon font-medium">
                                    Rp. 45,000
                                </div>
                            </div>
                            <div class="flex justify-between items-center border-b border-gold/20 pb-2">
                                <div class="flex-1">
                                    <h4 class="font-medium">Es Teh Manis</h4>
                                    <p class="text-sm text-gray-600">2x @Rp. 5,000</p>
                                </div>
                                <div class="text-maroon font-medium">
                                    Rp. 10,000
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="review_text">Review (Opsional):</label>
                    <textarea id="review_text" name="review_text" rows="5" 
                            class="form-control"
                            placeholder="Bagikan pengalaman Anda... (contoh: Servicenya bagus, restorannya bersih)"></textarea>
                </div>
                  <div id="ratingsSection" class="mt-6">
                    <h3 class="text-lg font-semibold text-maroon mb-3">Berikan Rating untuk Menu</h3>
                    <div id="menuRatings" class="space-y-4">
                        @if ($orderData)
                            @php
                                // Determine which property to use based on available data
                                $menuItems = [];
                                if (isset($orderData['order_items'])) {
                                    $menuItems = $orderData['order_items'];
                                } elseif (isset($orderData['items'])) {
                                    $menuItems = $orderData['items'];
                                }
                            @endphp
                            
                            @foreach($menuItems as $index => $item)
                                <div class="bg-cream/20 p-3 rounded-md">
                                    <h4 class="font-medium mb-2">{{ $item['menu_name'] }}</h4>
                                    <input type="hidden" name="ratings[{{ $index }}][Menu_menu_id]" value="{{ $item['menu_id'] }}">
                                    <input type="hidden" name="ratings[{{ $index }}][Order_order_id]" value="{{ $orderId }}">
                                    <input type="hidden" name="ratings[{{ $index }}][Member_member_id]" value="{{ $memberId }}">
                                    
                                    <div class="flex gap-1">
                                        <span class="star" data-rating="1" data-index="{{ $loop->index }}">★</span>
                                        <span class="star" data-rating="2" data-index="{{ $loop->index }}">★</span>
                                        <span class="star" data-rating="3" data-index="{{ $loop->index }}">★</span>
                                        <span class="star" data-rating="4" data-index="{{ $loop->index }}">★</span>
                                        <span class="star" data-rating="5" data-index="{{ $loop->index }}">★</span>
                                        <input type="hidden" name="ratings[{{ $loop->index }}][rating]" id="rating-input-{{ $loop->index }}" value="0">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Mock items for testing -->
                            @php
                            $mockItems = [
                                ['menu_id' => 1, 'menu_name' => 'Nasi Goreng Spesial'],
                                ['menu_id' => 2, 'menu_name' => 'Ayam Bakar'],
                                ['menu_id' => 3, 'menu_name' => 'Es Teh Manis']
                            ];
                            @endphp
                              @foreach($mockItems as $index => $item)
                                <div class="bg-cream/20 p-3 rounded-md">
                                    <h4 class="font-medium mb-2">{{ $item['menu_name'] }}</h4>
                                    <input type="hidden" name="ratings[{{ $index }}][Menu_menu_id]" value="{{ $item['menu_id'] }}">
                                    <input type="hidden" name="ratings[{{ $index }}][Order_order_id]" value="{{ $orderId }}">
                                    <input type="hidden" name="ratings[{{ $index }}][Member_member_id]" value="{{ $memberId }}">
                                    
                                    <div class="flex gap-1">
                                        <span class="star" data-rating="1" data-index="{{ $index }}">★</span>
                                        <span class="star" data-rating="2" data-index="{{ $index }}">★</span>
                                        <span class="star" data-rating="3" data-index="{{ $index }}">★</span>
                                        <span class="star" data-rating="4" data-index="{{ $index }}">★</span>
                                        <span class="star" data-rating="5" data-index="{{ $index }}">★</span>
                                        <input type="hidden" name="ratings[{{ $index }}][rating]" id="rating-input-{{ $index }}" value="0">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Review
                    </button>
                    <a href="/reviews/form" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Batal
                    </a>
                </div>
            </form>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle order selection form
        const orderSelectForm = document.getElementById('orderSelectForm');
        if (orderSelectForm) {
            orderSelectForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const orderId = document.getElementById('order_id').value;
                if (orderId) {
                    window.location.href = "{{ route('reviews.form') }}?order_id=" + orderId;
                }
            });
        }
        
        // Handle star ratings
        const stars = document.querySelectorAll('.star');
        if (stars.length > 0) {
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    const index = this.getAttribute('data-index');
                    const inputField = document.querySelector(`input[name="ratings[${index}][rating]"]`);
                    
                    // Update the hidden input value
                    inputField.value = rating;
                    
                    // Update the star display
                    const starsInGroup = document.querySelectorAll(`.star[data-index="${index}"]`);
                    starsInGroup.forEach(s => {
                        if (s.getAttribute('data-rating') <= rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });
        }
        
        // Handle review submission
        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading indicator
                document.getElementById('loadingIndicator').style.display = 'flex';
                
                const formData = new FormData(reviewForm);
                const data = {};
                const ratings = [];
                  // Convert form data to JSON structure
                for (const [key, value] of formData.entries()) {
                    if (key.startsWith('ratings[')) {
                        // Extract index and property name from key like ratings[0][rating]
                        const matches = key.match(/ratings\[(\d+)\]\[([^\]]+)\]/);
                        if (matches) {
                            const index = parseInt(matches[1]);
                            const prop = matches[2];
                            
                            if (!ratings[index]) {
                                ratings[index] = {};
                            }
                            
                            if (prop === 'rating' || prop === 'Menu_menu_id' || prop === 'Order_order_id') {
                                ratings[index][prop] = parseInt(value);
                            } else {
                                ratings[index][prop] = value;
                            }
                        }
                    } else {
                        // Handle numeric fields
                        if (key === 'Order_order_id' || key === 'Member_member_id') {
                            data[key] = parseInt(value);
                        } else {
                            data[key] = value;
                        }
                    }
                }
                
                // Filter out ratings with value 0 (not rated)
                data.ratings = ratings.filter(r => r && r.rating > 0);
                
                // Submit to API                // Check if all ratings are valid
                if (data.ratings.length === 0) {
                    // No valid ratings found, add at least one default rating with value 5
                    const menuId = document.querySelector('input[name="ratings[0][Menu_menu_id]"]').value;
                    const orderId = document.querySelector('input[name="ratings[0][Order_order_id]"]').value;
                    const memberId = document.querySelector('input[name="Member_member_id"]').value;
                    
                    data.ratings = [{
                        Menu_menu_id: parseInt(menuId),
                        Order_order_id: parseInt(orderId),
                        Member_member_id: parseInt(memberId),
                        rating: 5
                    }];
                }
                
                fetch('/api/reviews', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    // Check if there's a loading indicator
                    const loadingIndicator = document.getElementById('loadingIndicator');
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none';
                    }
                
                if (result.success) {
                    // Show success message
                    const toast = document.getElementById('toast');
                    toast.showToast('Review berhasil dikirim!', 'success');
                    
                    // Hide toast after 3 seconds
                    setTimeout(() => {
                        window.location.href = "/";
                    }, 3000);
                } else {
                    // Show error toast
                    const toast = document.getElementById('toast');
                    toast.showToast(result.message || 'Gagal mengirim review', 'error');
                }
                })                .catch(error => {
                    // Hide loading indicator
                    document.getElementById('loadingIndicator').style.display = 'none';
                    
                    // Show error toast
                    const toast = document.getElementById('toast');
                    toast.showToast('Terjadi kesalahan saat mengirim review', 'error');
                    console.error('Error:', error);
                });
            });
        }
    });
</script>
@endpush
@endsection
