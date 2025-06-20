<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Review & Rating Restoran</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Configure Tailwind with custom colors from the design -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: '#721517',
                        gold: '#debb72',
                        cream: '#e8d9ad',
                    }
                },
                fontFamily: {
                    sans: ['Arial', 'sans-serif'],
                }
            }
        }
    </script>
    
    <style type="text/tailwindcss">
        @layer components {
            .btn {
                @apply inline-block px-4 py-2 rounded cursor-pointer border-0;
            }
            .btn-primary {
                @apply bg-maroon text-gold font-semibold hover:bg-maroon/90 transition-colors;
            }
            .btn-secondary {
                @apply bg-gold text-maroon font-semibold hover:bg-gold/90 transition-colors;
            }
            .btn-sm {
                @apply px-3 py-1 text-sm;
            }
            .form-control {
                @apply w-full border border-gold/30 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold/50;
            }
            .form-group {
                @apply mb-4;
            }
            .form-group label {
                @apply block text-maroon font-medium mb-1;
            }
            .form-actions {
                @apply flex justify-center gap-3 mt-6;
            }
            .page-header {
                @apply mb-8 text-center;
            }
            .page-header h1 {
                @apply text-3xl font-bold text-maroon;
            }
            .page-header p {
                @apply text-maroon/80;
            }
            .container {
                @apply max-w-5xl mx-auto px-4 py-6;
            }
            .review-card {
                @apply bg-white border border-gold/50 rounded-lg shadow-md p-5 mb-6;
            }
            .review-header {
                @apply flex justify-between items-center border-b border-gold/30 pb-3 mb-3;
            }
            .review-date {
                @apply text-maroon/70 text-sm;
            }
            .review-text {
                @apply leading-relaxed text-gray-700;
            }
            .alert {
                @apply p-4 mb-4 rounded-lg;
            }
            .alert-info {
                @apply bg-blue-100 text-blue-800;
            }
            .alert-danger {
                @apply bg-red-100 text-red-800;
            }            .star {
                @apply text-2xl cursor-pointer text-gray-300 transition-colors duration-200;
            }
            .star.active {
                @apply text-gold;
            }
            .star:hover {
                @apply text-gold/70;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-cream min-h-screen flex">
    <!-- Sidebar navigation -->
    <nav class="bg-maroon text-gold w-64 min-h-screen fixed hidden md:block">
        <div class="p-4 flex flex-col h-full">
            <!-- Logo -->
            <div class="mb-8 flex justify-center">
                <h1 class="text-xl font-bold">RestaurantReview</h1>
            </div>
              <!-- User info -->
            <div class="mb-8 text-center">
                <div class="w-20 h-20 rounded-full bg-gold/30 mx-auto mb-2 flex items-center justify-center">
                    <i class="fas fa-user text-3xl"></i>
                </div>
                <h3 class="font-medium">John Doe</h3>
                <p class="text-sm text-gold/70">john@example.com</p>
                <div class="mt-2 text-xs bg-gold/20 py-1 px-3 rounded-full inline-block">
                    Member ID: 1
                </div>
            </div>
            
            <!-- Nav links -->            <ul class="space-y-2">
                <li>
                    <a href="/reviews?member_id=1" class="flex items-center px-4 py-2 rounded-md {{ request()->routeIs('reviews.index') ? 'bg-gold text-maroon font-medium' : 'text-gold hover:bg-maroon/80' }}">
                        <i class="fas fa-home w-6"></i>
                        <span>Home</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('reviews.form') }}?member_id=1" class="flex items-center px-4 py-2 rounded-md {{ request()->routeIs('reviews.form') ? 'bg-gold text-maroon font-medium' : 'text-gold hover:bg-maroon/80' }}">
                        <i class="fas fa-star w-6"></i>
                        <span>Beri Review</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('reviews.history') }}?member_id=1" class="flex items-center px-4 py-2 rounded-md {{ request()->routeIs('reviews.history') ? 'bg-gold text-maroon font-medium' : 'text-gold hover:bg-maroon/80' }}">
                        <i class="fas fa-history w-6"></i>
                        <span>Riwayat</span>
                    </a>
                </li>
            </ul>
              <!-- Footer -->
            <div class="mt-auto text-center text-sm text-gold/50 p-4">
                <p>© 2025 RestaurantReview</p>
            </div>
        </div>
    </nav>
    
    <!-- Mobile navigation -->
    <div class="md:hidden bg-maroon text-gold p-4 fixed w-full z-10 flex justify-between items-center">
        <h1 class="font-bold">RestaurantReview</h1>
        <button id="menuToggle" class="text-gold">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
    
    <!-- Mobile menu -->
    <div id="mobileMenu" class="fixed inset-0 bg-maroon z-20 p-4 transform translate-x-full transition-transform duration-300 md:hidden">
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-bold text-gold">RestaurantReview</h1>
            <button id="closeMenu" class="text-gold">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <ul class="space-y-4">
            <li>
                <a href="/reviews" class="block py-2 px-4 rounded-md {{ request()->routeIs('reviews.index') ? 'bg-gold text-maroon font-medium' : 'text-gold' }}">
                    <i class="fas fa-comments mr-2"></i> Home
                </a>
            </li>
            <li>
                <a href="{{ route('reviews.form') }}" class="block py-2 px-4 rounded-md {{ request()->routeIs('reviews.form') ? 'bg-gold text-maroon font-medium' : 'text-gold' }}">
                    <i class="fas fa-star mr-2"></i> Beri Review
                </a>
            </li>
            <li>
                <a href="{{ route('reviews.history') }}" class="block py-2 px-4 rounded-md {{ request()->routeIs('reviews.history') ? 'bg-gold text-maroon font-medium' : 'text-gold' }}">
                    <i class="fas fa-history mr-2"></i> Riwayat
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Main content -->
    <div class="flex-1 md:ml-64 pt-16 md:pt-0 min-h-screen bg-cream">    <main class="p-6">
        @yield('content')
    </main>
</div>

<!-- Loading Indicator -->
<div id="loadingIndicator" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-gold border-t-maroon mx-auto"></div>
        <p class="mt-2 text-maroon font-medium">Memuat...</p>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 mb-4 mr-4 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-y-full opacity-0 z-50"></div>

<!-- Modal Backdrop -->
<div id="modal-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden" style="display: none;"></div>

<!-- Delete Confirmation Dialog -->
<div id="confirmationDialog" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="h-full w-full flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm mx-auto">
            <h3 class="text-lg font-medium text-maroon mb-3">Konfirmasi</h3>
            <p id="confirmationMessage" class="text-gray-700 mb-6">Apakah Anda yakin?</p>
            <div class="flex justify-end gap-3">
                <button id="cancelConfirmation" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Batal</button>
                <button id="confirmAction" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@if(app()->environment('production'))
    <!-- The Vite build already includes axios and app.js -->
@else
    <script src="{{ asset('js/app.js') }}"></script>
@endif

<script>
    // Mobile menu functionality
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menuToggle');
        const closeMenu = document.getElementById('closeMenu');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                mobileMenu.classList.remove('translate-x-full');
            });
        }
        
        if (closeMenu) {
            closeMenu.addEventListener('click', function() {
                mobileMenu.classList.add('translate-x-full');
            });
        }
          // Toast functionality
        const toast = document.getElementById('toast');
        if (toast) {
            // This will be used by existing code
            toast.showToast = function(message, type = 'success') {
                console.log('Showing toast:', message, 'Type:', type);
                
                this.textContent = message;
                
                // Clear any previous classes and set new ones
                this.className = 'fixed bottom-4 right-4 mb-4 mr-4 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 z-50';
                
                // Add color based on type
                if (type === 'success') {
                    this.classList.add('bg-green-600', 'text-white');
                } else {
                    this.classList.add('bg-red-600', 'text-white');
                }
                
                // Make visible
                this.style.opacity = '1';
                this.style.transform = 'translateY(0)';
                
                // Hide after delay
                setTimeout(() => {
                    this.style.opacity = '0';
                    this.style.transform = 'translateY(100%)';
                }, 3000);
            };
            
            console.log('Toast functionality initialized');
        } else {
            console.error('Toast element not found');
        }// Global confirmation dialog functionality
        window.showConfirmDialog = function(message, callback) {
            console.log('Showing confirmation dialog with message:', message);
            
            const dialog = document.getElementById('confirmationDialog');
            const messageEl = document.getElementById('confirmationMessage');
            const cancelBtn = document.getElementById('cancelConfirmation');
            const confirmBtn = document.getElementById('confirmAction');
            
            if (dialog && messageEl && cancelBtn && confirmBtn) {
                // Set the message
                messageEl.textContent = message;
                
                // Clear any existing event listeners to prevent duplication
                const newCancelBtn = cancelBtn.cloneNode(true);
                const newConfirmBtn = confirmBtn.cloneNode(true);
                cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
                confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
                
                // Show the dialog
                console.log('Displaying confirmation dialog');
                dialog.classList.remove('hidden');
                dialog.style.display = 'block';
                
                // Handle confirm
                const confirmHandler = function() {
                    console.log('Confirm button clicked');
                    dialog.classList.add('hidden');
                    dialog.style.display = 'none';
                    callback(true);
                };
                
                // Handle cancel
                const cancelHandler = function() {
                    console.log('Cancel button clicked');
                    dialog.classList.add('hidden');
                    dialog.style.display = 'none';
                    callback(false);
                };
                
                // Add event listeners
                console.log('Adding event listeners to confirmation buttons');
                newConfirmBtn.addEventListener('click', confirmHandler);
                newCancelBtn.addEventListener('click', cancelHandler);
                
                // Handle outside click
                const outsideClickHandler = function(e) {
                    if (e.target === dialog) {
                        console.log('Outside dialog clicked');
                        cancelHandler();
                    }
                };
                
                // Remove any existing click listener to prevent duplicates
                dialog.removeEventListener('click', outsideClickHandler);
                dialog.addEventListener('click', outsideClickHandler);
            } else {
                console.error('Confirmation dialog elements not found');
                if (!dialog) console.error('Dialog element missing');
                if (!messageEl) console.error('Message element missing');
                if (!cancelBtn) console.error('Cancel button missing');
                if (!confirmBtn) console.error('Confirm button missing');
                
                // Fallback to browser confirm
                const result = confirm(message);
                callback(result);
            }
        };
    });
</script>

@stack('scripts')
</body>
</html>
