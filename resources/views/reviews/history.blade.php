@extends('layouts.main')

@section('content')
<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-history"></i> Riwayat Review & Rating</h1>
        <p>Kelola semua review dan rating yang pernah Anda buat</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 border border-gold/30">
        <!-- Header Member -->
        <div class="member-header mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-maroon">
                        <i class="fas fa-user-circle mr-1"></i>
                        {{ $member['member_name'] ?? 'Member #'.$memberId }}
                    </h3>
                    @if(isset($member['member_email']))
                        <p class="text-sm text-gray-600">{{ $member['member_email'] }}</p>
                    @endif
                </div>
                <div class="flex gap-2">
                    {{-- <a href="{{ route('reviews.form') }}?member_id={{ $memberId }}" class="px-4 py-2 bg-maroon text-gold rounded hover:bg-maroon/90 transition-colors">
                        <i class="fas fa-plus-circle mr-1"></i> Review Baru
                    </a> --}}
                    <a href=/ class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors">
                        <i class="fas fa-home mr-1"></i> Beranda
                    </a>
                </div>
            </div>
        </div>

        <!-- Bagian Tab -->
        <div class="mt-6">
            <div class="flex space-x-2 border-b border-gold/30">
                <button type="button" class="px-4 py-2 font-medium text-maroon border-b-2 border-maroon" data-tab="reviews">Review</button>
                <button type="button" class="px-4 py-2 text-maroon/70 hover:text-maroon" data-tab="ratings">Rating</button>
                <button type="button" class="px-4 py-2 text-maroon/70 hover:text-maroon" data-tab="orders">Pesanan</button>
            </div>
        </div>

        <div id="historyContent" class="mt-6">
            <!-- Reviews Tab -->
            <div class="history-section" id="reviews-tab" style="display: block;">
                <h3 class="text-xl font-semibold text-maroon mb-4 flex items-center"><i class="fas fa-comments mr-2"></i> Review Saya</h3>
                @if(is_array($reviewHistory) && count($reviewHistory) > 0)
                    <div class="space-y-6">
                        @foreach($reviewHistory as $review)
                            <div class="review-card p-4 border border-gold/20 rounded-lg" data-review-id="{{ $review['review_id'] }}">
                                <div class="review-header flex justify-between">
                                    <h4 class="font-medium text-maroon">Order #{{ $review['Order_order_id'] ?? 'N/A' }}</h4>
                                    <div class="review-date">{{ \Carbon\Carbon::parse($review['created_at'])->diffForHumans() }}</div>
                                </div>
                                <div class="review-text mt-3 mb-4">{{ $review['review_text'] }}</div>
                                
                                @if(isset($review['order_info']))
                                    <div class="bg-cream/20 p-2 rounded-md mb-3">
                                        <p class="text-sm">Total: Rp. {{ number_format($review['order_info']['order_totalPayment']) }}</p>
                                        <p class="text-sm">Tanggal: {{ \Carbon\Carbon::parse($review['order_info']['created_at'])->format('d M Y H:i') }}</p>
                                    </div>
                                @endif
                                
                                <div class="flex justify-end gap-2">
                                    <button class="bg-maroon text-gold px-3 py-1 rounded text-sm font-medium hover:bg-maroon/90 edit-review-btn" 
                                        data-review-id="{{ $review['review_id'] }}" 
                                        data-review-text="{{ $review['review_text'] }}">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                    <button class="bg-red-600 text-white px-3 py-1 rounded text-sm font-medium hover:bg-red-700 delete-review-btn" 
                                        data-review-id="{{ $review['review_id'] }}">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-blue-100 text-blue-800 p-4 rounded-md">Tidak ada review yang ditemukan.</div>
                @endif
            </div>

            <!-- Ratings Tab -->
            <div class="history-section" id="ratings-tab" style="display: none;">
                <h3 class="text-xl font-semibold text-maroon mb-4 flex items-center"><i class="fas fa-star mr-2"></i> Rating Saya</h3>
                
                @if(is_array($ratings) && count($ratings) > 0)
                    <!-- Debug: Output ratings data structure -->
                    <div class="mb-4 p-4 bg-gray-100 rounded" style="display: none;">
                        <button class="bg-blue-500 text-white px-3 py-1 rounded mb-2" onclick="document.querySelector('.debug-info').style.display = document.querySelector('.debug-info').style.display === 'none' ? 'block' : 'none'">Toggle Debug Info</button>
                        <pre class="debug-info text-xs overflow-auto" style="display: none;">{{ print_r($ratings, true) }}</pre>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">                        @foreach($ratings as $rating)
                            <div class="bg-white border border-gold/30 rounded-lg shadow-sm p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium">
                                        @php
                                            $menuName = $rating['Menu_menu_name'] ?? $rating['menu_name'] ?? null;
                                            $orderId = $rating['Order_order_id'] ?? null;
                                            
                                            // If we need to look up the menu name from orders
                                            if (!$menuName && isset($rating['Menu_menu_id']) && isset($orders)) {
                                                foreach ($orders as $order) {
                                                    if (isset($order['items']) && is_array($order['items'])) {
                                                        foreach ($order['items'] as $item) {
                                                            if (isset($item['menu_id']) && $item['menu_id'] == $rating['Menu_menu_id']) {
                                                                $menuName = $item['menu_name'] ?? null;
                                                                break 2;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        {{ $menuName ?? 'Menu #'.$rating['Menu_menu_id'] }}
                                    </h4>
                                    <span class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($rating['created_at'])->format('d M Y') }}
                                    </span>
                                </div>                                <div class="mb-2 text-xs text-gray-600">
                                    <span class="px-2 py-1 bg-gray-100 rounded-md" title="Order yang berisi makanan ini">
                                        Order #{{ $orderId ?? 'N/A' }}
                                        @php
                                            // Find order date if available
                                            $orderDate = null;
                                            if ($orderId && isset($orders)) {
                                                foreach ($orders as $order) {
                                                    if (isset($order['order_id']) && $order['order_id'] == $orderId) {
                                                        $orderDate = isset($order['created_at']) ? 
                                                            \Carbon\Carbon::parse($order['created_at'])->format('d M Y') : null;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if($orderDate)
                                            <span class="ml-1">({{ $orderDate }})</span>
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="stars-container mr-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="star-rating {{ $i <= $rating['rating'] ? 'active' : '' }}">★</span>
                                        @endfor
                                    </div>
                                    <span class="rating-value font-medium text-maroon">
                                        {{ $rating['rating'] }}.0
                                    </span>
                                </div>
                                  <div class="mt-3 flex justify-end">
                                    <button class="bg-red-600 text-white px-2 py-1 rounded text-xs font-medium hover:bg-red-700 delete-rating-btn"
                                        data-rating-id="{{ $rating['rating_id'] }}">
                                        <i class="fas fa-trash mr-1"></i> Hapus Rating
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-blue-100 text-blue-800 p-4 rounded-md">Tidak ada rating yang ditemukan.</div>
                @endif
            </div>

            <!-- Orders Tab -->
            <div class="history-section" id="orders-tab" style="display: none;">
                <h3 class="text-xl font-semibold text-maroon mb-4 flex items-center"><i class="fas fa-shopping-bag mr-2"></i> Pesanan Saya</h3>
                
                @if(is_array($orders) && count($orders) > 0)
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            @php
                                // Ensure the order belongs to the current member
                                $orderMemberId = $order['Member_member_id'] ?? null;
                                $belongsToCurrentMember = $orderMemberId == $memberId;
                                
                                // Check if this order has been reviewed
                                $hasReview = is_array($reviewHistory) && count(array_filter($reviewHistory, function($review) use ($order) {
                                    return isset($review['Order_order_id']) && $review['Order_order_id'] == $order['order_id'];
                                })) > 0;
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
                                </div>
                                
                                <div class="mt-4 flex justify-end">
                                    @if($hasReview)
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded text-sm">
                                            <i class="fas fa-check mr-1"></i> Sudah Direview
                                        </span>
                                    @else
                                        <a href="{{ route('reviews.form') }}?order_id={{ $order['order_id'] }}&member_id={{ $memberId }}" class="px-3 py-1 bg-maroon text-gold rounded text-sm hover:bg-maroon/90 transition-colors">
                                            <i class="fas fa-star mr-1"></i> Beri Review
                                        </a>
                                    @endif
                                </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="bg-blue-100 text-blue-800 p-4 rounded-md">Tidak ada pesanan yang ditemukan.</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="editReviewModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-medium mb-4">Edit Review</h3>
        <form id="editReviewForm">
            <input type="hidden" name="review_id" id="edit_review_id">
            <div class="mb-4">
                <label for="edit_review_text" class="block mb-2 text-sm font-medium">Review Text:</label>
                <textarea id="edit_review_text" name="review_text" rows="4" class="border border-gray-300 rounded p-2 w-full"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded" id="closeEditModal">Batal</button>
                <button type="submit" class="px-4 py-2 bg-maroon text-gold rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="confirmDeleteModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
        <h3 class="text-lg font-medium mb-4">Konfirmasi Hapus</h3>
        <p class="mb-6">Apakah Anda yakin ingin menghapus item ini?</p>
        <div class="flex justify-end gap-2">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded" id="cancelDelete">Batal</button>
            <button type="button" class="px-4 py-2 bg-red-600 text-white rounded" id="confirmDelete">Hapus</button>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stars-container {
        display: flex;
        gap: 2px;
    }
    
    .star-rating {
        font-size: 1.2rem;
        color: #ccc;
    }
    
    .star-rating.active {
        color: #8B0000; /* Maroon */
    }
    
    .history-section {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Tab styling */
    [data-tab].active {
        border-bottom: 2px solid #8B0000;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabs = document.querySelectorAll('[data-tab]');
        const sections = document.querySelectorAll('.history-section');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');
                
                // Update tab styling
                tabs.forEach(t => t.classList.remove('border-b-2', 'border-maroon', 'font-medium'));
                this.classList.add('border-b-2', 'border-maroon', 'font-medium');
                
                // Show selected section, hide others
                sections.forEach(section => {
                    if (section.id === tabName + '-tab') {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            });
        });
        
        // Edit review functionality
        const editReviewModal = document.getElementById('editReviewModal');
        const editReviewForm = document.getElementById('editReviewForm');
        const editReviewId = document.getElementById('edit_review_id');
        const editReviewText = document.getElementById('edit_review_text');
        const closeEditModal = document.getElementById('closeEditModal');
        
        document.querySelectorAll('.edit-review-btn').forEach(button => {
            button.addEventListener('click', function() {
                const reviewId = this.getAttribute('data-review-id');
                const reviewText = this.getAttribute('data-review-text');
                
                editReviewId.value = reviewId;
                editReviewText.value = reviewText;
                
                editReviewModal.classList.remove('hidden');
                editReviewModal.classList.add('flex');
            });
        });
        
        closeEditModal.addEventListener('click', function() {
            editReviewModal.classList.add('hidden');
            editReviewModal.classList.remove('flex');
        });
        
        editReviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const reviewId = editReviewId.value;
            const reviewText = editReviewText.value;
            
            // Show loading
            const toast = document.getElementById('toast');
            toast.showToast('Menyimpan perubahan...', 'info');
            
            fetch(`/api/reviews/${reviewId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ review_text: reviewText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the review text in the DOM
                    const reviewCard = document.querySelector(`.review-card[data-review-id="${reviewId}"]`);
                    if (reviewCard) {
                        reviewCard.querySelector('.review-text').textContent = reviewText;
                    }
                    
                    // Close modal
                    editReviewModal.classList.add('hidden');
                    editReviewModal.classList.remove('flex');
                    
                    // Show success toast
                    toast.showToast('Review berhasil diperbarui', 'success');
                } else {
                    toast.showToast(data.message || 'Gagal memperbarui review', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toast.showToast('Terjadi kesalahan saat memperbarui review', 'error');
            });
        });
        
        // Delete functionality
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        let deleteType = null;
        let deleteId = null;
        
        document.querySelectorAll('.delete-review-btn').forEach(button => {
            button.addEventListener('click', function() {
                deleteType = 'review';
                deleteId = this.getAttribute('data-review-id');
                showDeleteConfirmation();
            });
        });
        
        document.querySelectorAll('.delete-rating-btn').forEach(button => {
            button.addEventListener('click', function() {
                deleteType = 'rating';
                deleteId = this.getAttribute('data-rating-id');
                showDeleteConfirmation();
            });
        });
        
        function showDeleteConfirmation() {
            confirmDeleteModal.classList.remove('hidden');
            confirmDeleteModal.classList.add('flex');
        }
        
        cancelDelete.addEventListener('click', function() {
            confirmDeleteModal.classList.add('hidden');
            confirmDeleteModal.classList.remove('flex');
            deleteType = null;
            deleteId = null;
        });
        
        confirmDelete.addEventListener('click', function() {
            const toast = document.getElementById('toast');
            toast.showToast('Menghapus...', 'info');
            
            let endpoint = '';
            if (deleteType === 'review') {
                endpoint = `/api/reviews/${deleteId}`;
            } else if (deleteType === 'rating') {
                endpoint = `/api/ratings/${deleteId}`;
            }
            
            fetch(endpoint, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the item from DOM
                    if (deleteType === 'review') {
                        const reviewCard = document.querySelector(`.review-card[data-review-id="${deleteId}"]`);
                        if (reviewCard) reviewCard.remove();
                    } else if (deleteType === 'rating') {
                        const ratingCard = document.querySelector(`.delete-rating-btn[data-rating-id="${deleteId}"]`).closest('.bg-white');
                        if (ratingCard) ratingCard.remove();
                    }
                    
                    // Close modal
                    confirmDeleteModal.classList.add('hidden');
                    confirmDeleteModal.classList.remove('flex');
                    
                    // Show success toast
                    toast.showToast(`${deleteType === 'review' ? 'Review' : 'Rating'} berhasil dihapus`, 'success');
                } else {
                    toast.showToast(data.message || `Gagal menghapus ${deleteType}`, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toast.showToast(`Terjadi kesalahan saat menghapus ${deleteType}`, 'error');
            })
            .finally(() => {
                deleteType = null;
                deleteId = null;
            });
        });
    });
</script>
@endpush
@endsection
