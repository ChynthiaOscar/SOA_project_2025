<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Driver Delivery - SOA Project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text&display=swap" rel="stylesheet" />

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
                        'dm-serif': ['"DM Serif Text"', 'serif'],
                    },
                },
            },
        };
    </script>
    <style>
        .heading-serif {
            font-family: 'DM Serif Text', serif;
        }
    </style>
</head>

<body class="bg-darkbg text-cream min-h-screen">
    <div class="container mx-auto px-4 py-10 max-w-6xl">
        <h1 class="text-gold text-3xl text-center mb-10 heading-serif">DELIVERIES ASSIGNED TO YOU</h1>

        <div id="notification" class="hidden mb-6 rounded p-4"></div>

        <!-- Deliveries Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left border-b border-tan">
                        <th class="p-3 heading-serif text-gold">ID</th>
                        <th class="p-3 heading-serif text-gold">Order ID</th>
                        <th class="p-3 heading-serif text-gold">Delivery Address</th>
                        <th class="p-3 heading-serif text-gold">Distance</th>
                        <th class="p-3 heading-serif text-gold">Price</th>
                        <th class="p-3 heading-serif text-gold">Status</th>
                        <th class="p-3 heading-serif text-gold">Actions</th>
                    </tr>
                </thead>
                <tbody id="deliveries_table">
                    @if(isset($deliveries) && count($deliveries) > 0)
                        @foreach($deliveries as $delivery)
                            <tr class="border-b border-tan/30 hover:bg-black/30">
                                <td class="p-3">{{ $delivery['id'] }}</td>
                                <td class="p-3">{{ $delivery['order_id'] ?? 'N/A' }}</td>
                                <td class="p-3">{{ $delivery['tujuan'] ?? $delivery['destination'] ?? 'N/A' }}</td>
                                <td class="p-3">{{ isset($delivery['jarak']) ? $delivery['jarak'] . ' km' : (isset($delivery['distance']) ? $delivery['distance'] . ' km' : 'N/A') }}</td>
                                <td class="p-3">{{ isset($delivery['harga_delivery']) ? 'Rp ' . number_format($delivery['harga_delivery']) : (isset($delivery['price']) ? 'Rp ' . number_format($delivery['price']) : 'N/A') }}</td>
                                <td class="p-3">
                                    <span class="{{ getStatusClass($delivery['status'] ?? 'pending') }}">
                                        {{ $delivery['status'] ?? 'pending' }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <div class="flex gap-2">
                                        @if(isset($delivery['status']) && $delivery['status'] !== 'delivered' && $delivery['status'] !== 'canceled')
                                            <button
                                                class="bg-gold hover:bg-gold-light text-black px-3 py-1 rounded text-xs"
                                                onclick="updateDeliveryStatus({{ $delivery['id'] }}, 'delivering')"
                                            >
                                                Mark Delivering
                                            </button>
                                            <button
                                                class="bg-green-700 hover:bg-green-600 text-cream px-3 py-1 rounded text-xs"
                                                onclick="updateDeliveryStatus({{ $delivery['id'] }}, 'delivered')"
                                            >
                                                Mark Delivered
                                            </button>
                                        @else
                                            <span class="text-tan text-xs italic">No actions available</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="p-3 text-center text-gray-400">No deliveries assigned to you.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function getStatusClass(status) {
        switch (status) {
            case 'pending':
                return 'bg-orange/20 text-orange px-2 py-1 rounded text-xs';
            case 'assigned':
                return 'bg-blue-800/20 text-blue-300 px-2 py-1 rounded text-xs';
            case 'delivering':
                return 'bg-yellow-600/20 text-yellow-400 px-2 py-1 rounded text-xs';
            case 'delivered':
                return 'bg-green-800/20 text-green-300 px-2 py-1 rounded text-xs';
            case 'canceled':
                return 'bg-red-800/20 text-red-300 px-2 py-1 rounded text-xs';
            default:
                return 'bg-gray-800/20 text-gray-300 px-2 py-1 rounded text-xs';
        }
    }

    function showNotification(message, type = 'success') {
        const notificationElement = document.getElementById('notification');
        notificationElement.innerHTML = message;
        notificationElement.classList.remove('hidden', 'bg-green-800/20', 'bg-red-800/20', 'bg-yellow-600/20');

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

    function updateDeliveryStatus(id, status) {
        fetch(`/api/delivery/${id}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(result => {
            if (result.error) {
                showNotification(result.error, 'error');
            } else {
                showNotification('Delivery status updated successfully', 'success');
                // Reload the page or update the UI accordingly
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error updating delivery status:', error);
            showNotification('Failed to update delivery status', 'error');
        });
    }
</script>
</html>
