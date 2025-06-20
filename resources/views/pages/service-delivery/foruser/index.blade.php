<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Delivery Request - SOA Project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            dark: '#8B0000',
                            DEFAULT: '#A52A2A',
                        },
                        cream: '#F5F5DC',
                        gold: {
                            light: '#FFD700',
                            DEFAULT: '#DAA520',
                        },
                        tan: '#D2B48C',
                        orange: '#FFA500',
                        offwhite: '#FFFDD0',
                        darkbg: '#131313',
                    },
                    fontFamily: {
                        'dm-serif': ['"DM Serif Text"', 'serif']
                    }
                }
            }
        }
    </script>
    <style>
        .heading-serif {
            font-family: 'DM Serif Text', serif;
        }
    </style>
</head>

<body class="bg-darkbg text-cream min-h-screen">
    <div class="container mx-auto px-4 py-10 max-w-3xl">
        <h1 class="text-gold text-3xl font-bold text-center mb-10">Delivery Information</h1>

        <div id="notification" class="hidden mb-6 rounded p-4"></div>

        @if (!isset($orderId))
            <div class="bg-orange/20 text-orange p-4 mb-6 rounded">
                <p>No order was selected. Please select an order first.</p>
                <a href="/" class="underline">Go back to orders</a>
            </div>
        @else
            <!-- Order Details -->
            <div class="mb-8 bg-black/30 p-6 rounded-lg border border-tan/20">
                <h3 class="text-gold text-xl mb-4">Order Details</h3>
                <div class="border border-tan rounded p-4">
                    @if (count($orderDetails) > 0)
                        @foreach ($orderDetails as $detail)
                            <div class="flex justify-between mb-2">
                                <span>{{ $detail['menu_name'] ?? 'Menu Item' }}
                                    x{{ $detail['order_detail_quantity'] }}</span>
                                <span>Rp
                                    {{ number_format($detail['menu_price'] * $detail['order_detail_quantity']) }}</span>
                            </div>
                            @if (!empty($detail['order_detail_note']))
                                <div class="text-sm text-tan mb-2 ml-4">Note: {{ $detail['order_detail_note'] }}</div>
                            @endif
                        @endforeach
                        <div class="h-px bg-tan my-4"></div>
                        <div class="flex justify-between font-bold text-gold-light">
                            <span>Total Order</span>
                            <span>Rp
                                {{ number_format(array_sum(array_map(fn($detail) => $detail['menu_price'] * $detail['order_detail_quantity'], $orderDetails))) }}</span>
                        </div>
                    @else
                        <div class="text-center text-tan p-4">
                            No order details available
                        </div>
                    @endif
                </div>
            </div>

            <!-- Delivery Form -->
            <form id="deliveryForm" class="mb-8 bg-black/30 p-6 rounded-lg border border-tan/20" method="POST" href="api/delivery/create">
                <input type="hidden" id="order_id" name="order_id" key="order_id" value="{{ $orderId }}">
                <input type="hidden" id="member_id" name="member_id" key="member_id" value="{{ $order['member_id'] ?? 1 }}">

                <h3 class="text-gold text-xl mb-4">Search Location</h3>
                <div class="flex mb-4">
                    <input type="text" id="location_search"
                        class="flex-1 bg-transparent border border-tan rounded-l p-3 text-cream focus:border-gold focus:outline-none"
                        placeholder="Search your location...">
                    <button type="button" id="search_button"
                        class="bg-gold hover:bg-gold-light text-black px-4 rounded-r">
                        Search
                    </button>
                </div>

                <div id="search_results" class="mb-4 hidden">
                    <h4 class="text-gold mb-2">Search Results:</h4>
                    <div id="results_list" class="border border-tan rounded max-h-48 overflow-y-auto">
                        <!-- Results will be inserted here -->
                    </div>
                </div>

                <h3 class="text-gold text-xl mb-4">Delivery Address</h3>
                <textarea id="tujuan" name="destination" key="desination"
                    class="w-full bg-transparent border border-tan rounded p-3 text-cream focus:border-gold focus:outline-none mb-4"
                    placeholder="Enter delivery address" required rows="3"></textarea>

                <input type="hidden" id="lat" name="lat" key="lat" value="">
                <input type="hidden" id="lon" name="lon" key="lon" value="">

                <div id="distance_info" class="hidden border border-tan rounded p-4 mb-6">
                    <div class="flex justify-between mb-2">
                        <span>Distance:</span>
                        <span id="distance_value">0 km</span>
                    </div>
                    <div class="flex justify-between font-bold text-gold-light">
                        <span>Delivery Fee:</span>
                        <span id="price_value">Rp 0</span>
                    </div>
                    <input type="hidden" id="distance" name="distance" key="distance" value="">
                    <input type="hidden" id="price" name="price" value="">
                </div>

                <div class="text-center mt-6">
                    <button type="submit" id="submit_button"
                        class="bg-maroon hover:bg-maroon-dark text-cream font-bold py-3 px-8 rounded transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Confirm Delivery
                    </button>
                </div>
            </form>

            <!-- Success Message (Hidden initially) -->
            <div id="success_message" class="hidden text-center py-10">
                <div class="inline-block p-4 bg-green-800/30 text-green-300 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-gold text-2xl mb-4">Delivery Request Successful!</h2>
                <p class="text-cream mb-6">Your order is being prepared and will be delivered soon.</p>
                <a href="/"
                    class="bg-maroon hover:bg-maroon-dark text-cream font-bold py-2 px-6 rounded transition duration-300">
                    Return Home
                </a>
            </div>
        @endif
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get elements
        const searchInput = document.getElementById('location_search');
        const searchButton = document.getElementById('search_button');
        const searchResults = document.getElementById('search_results');
        const resultsList = document.getElementById('results_list');
        const deliveryForm = document.getElementById('deliveryForm');
        const destinationInput = document.getElementById('tujuan');
        const latInput = document.getElementById('lat');
        const lonInput = document.getElementById('lon');
        const distanceInfo = document.getElementById('distance_info');
        const distanceValue = document.getElementById('distance_value');
        const priceValue = document.getElementById('price_value');
        const distanceInput = document.getElementById('distance');
        const priceInput = document.getElementById('price');
        const submitButton = document.getElementById('submit_button');
        const successMessage = document.getElementById('success_message');
        const notificationElement = document.getElementById('notification');

        // Event listeners
        if (searchButton) {
            searchButton.addEventListener('click', function() {
                const query = searchInput.value.trim();
                if (query) {
                    searchLocation(query);
                } else {
                    showNotification('Please enter a location to search', 'warning');
                }
            });
        }

        if (deliveryForm) {
            deliveryForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = {
                    order_id: document.getElementById('order_id').value,
                    member_id: document.getElementById('member_id').value,
                    destination: destinationInput.value,
                    lat: latInput.value,
                    lon: lonInput.value,
                    distance: distanceInput.value,
                    notes: "Kirim cepat brok!",
                };

                // if (!formData.destination || !formData.lat || !formData.lon || !formData.distance) {
                //     showNotification('Please select a valid location first', 'error');
                //     return;
                // }

                createDelivery(formData);
            });
        }

        // Functions
        function searchLocation(query) {
            fetch('/api/delivery/search', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        q: query
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.error) {
                        showNotification(result.error, 'error');
                        return;
                    }

                    renderSearchResults(result);
                })
                .catch(error => {
                    console.error('Error searching location:', error);
                    showNotification('Failed to search location', 'error');
                });
        }

        function numberWithCommas(x) {
            if (x == null || isNaN(x)) return '0';
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function renderSearchResults(results) {
            if (!results || !results.length) {
                resultsList.innerHTML = '<div class="p-3 text-center text-gray-400">No results found</div>';
                searchResults.classList.remove('hidden');
                return;
            }

            let html = '';
            results.forEach(place => {
                html += `
        <div class="p-3 hover:bg-black/30 cursor-pointer border-b border-tan/20" 
             onclick="selectLocation('${place.label.replace(/'/g, "\\'")}', ${place.latitude}, ${place.longitude})">
            <div class="font-bold">${place.label}</div>
            <div class="text-xs text-tan">${place.name}: ${place.latitude}, ${place.longitude}</div>
        </div>`;
            });

            resultsList.innerHTML = html;
            searchResults.classList.remove('hidden');
        }


        function getDistance(lat, lon, attempt = 1) {
            fetch('/api/delivery/distance', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        lat,
                        lon
                    })
                })
                .then(response => response.text())
                .then(text => {
                    let result;
                    try {
                        result = JSON.parse(text);
                    } catch (e) {
                        if (attempt < 3) {
                            console.warn(`Retrying due to invalid JSON (attempt ${attempt + 1})`);
                            getDistance(lat, lon, attempt + 1); // Instant retry
                            return;
                        } else {
                            showNotification('Invalid response from server after multiple attempts',
                                'error');
                            console.error('Raw response:', text);
                            return;
                        }
                    }

                    if (result.error) {
                        if (attempt < 3) {
                            console.warn(`Retrying due to error: ${result.error} (attempt ${attempt + 1})`);
                            getDistance(lat, lon, attempt + 1); // Instant retry
                            return;
                        } else {
                            showNotification(result.error, 'error');
                            return;
                        }
                    }

                    const distance = typeof result.distance === 'number' ? result.distance :
                        typeof result.distance_km === 'number' ? result.distance_km : null;

                    const price = typeof result.price === 'number' ? result.price :
                        distance !== null ? calculateDeliveryFee(distance) : null;

                    if (distance === null || price === null) {
                        showNotification('Invalid distance or price received from server', 'error');
                        return;
                    }

                    distanceValue.textContent = distance.toFixed(2) + ' km';
                    priceValue.textContent = 'Rp ' + numberWithCommas(price);

                    distanceInput.value = distance;
                    priceInput.value = price;

                    distanceInfo.classList.remove('hidden');
                    submitButton.disabled = false;
                })
                .catch(error => {
                    console.error('Fetch error calculating distance:', error);
                    if (attempt < 3) {
                        console.warn(`Retrying due to fetch error (attempt ${attempt + 1})`);
                        getDistance(lat, lon, attempt + 1); // Instant retry
                    } else {
                        showNotification('Failed to calculate distance after multiple attempts', 'error');
                    }
                });
        }



        // Tambahkan fungsi ini jika belum ada
        function calculateDeliveryFee(distance) {
            const feePerKm = 500; // contoh
            return Math.round(distance * feePerKm);
        }



        function createDelivery(formData) {
            fetch('/api/delivery/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.error) {
                        showNotification(result.error, 'error');
                        return;
                    }

                    // Show success message and hide form
                    deliveryForm.classList.add('hidden');
                    successMessage.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error creating delivery:', error);
                    showNotification('Failed to create delivery request', 'error');
                });
        }

        function showNotification(message, type = 'success') {
            notificationElement.innerHTML = message;
            notificationElement.classList.remove('hidden', 'bg-green-800/20', 'bg-red-800/20',
                'bg-yellow-600/20');

            switch (type) {
                case 'success':
                    notificationElement.classList.add('bg-green-800/20', 'text-green-300');
                    break;
                case 'error':
                    notificationElement.classList.add('bg-red-800/20', 'text-red-300');
                    break;
                case 'warning':
                    notificationElement.classList.add('bg-yellow-600/20', 'text-yellow-400');
                    break;
            }

            notificationElement.classList.remove('hidden');

            // Hide after 5 seconds
            setTimeout(() => {
                notificationElement.classList.add('hidden');
            }, 5000);
        }

        // Make these functions available globally
        window.selectLocation = function(name, lat, lon) {
            if (!lat || !lon || !name) {
                showNotification('Invalid location selected', 'error');
                return;
            }

            destinationInput.value = name;
            latInput.value = lat;
            lonInput.value = lon;

            searchResults.classList.add('hidden');
            getDistance(lat, lon);
        };
    });
</script>

</html>
