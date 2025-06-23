<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Delivery Admin - SOA Project</title>
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
        <h1 class="text-gold text-3xl text-center mb-10 heading-serif">DELIVERY MANAGEMENT</h1>

        <div id="notification" class="hidden mb-6 rounded p-4"></div>

        <!-- Search and filters -->
        <div class="mb-8 flex flex-col md:flex-row justify-between gap-4">
            <div class="flex-1">
                <input
                    type="text"
                    id="delivery_search"
                    class="w-full bg-transparent border border-tan rounded p-3 text-cream focus:border-gold focus:outline-none"
                    placeholder="Search by order ID, customer name, or address..."
                />
            </div>
            <div class="flex gap-2">
                <select
                    id="status_filter"
                    class="bg-black text-cream border border-tan rounded p-3 focus:border-gold focus:outline-none"
                >
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="assigned">Assigned</option>
                    <option value="delivering">Delivering</option>
                    <option value="delivered">Delivered</option>
                    <option value="canceled">Canceled</option>
                </select>
                <button
                    id="filter_button"
                    class="bg-gold hover:bg-gold-light text-black px-4 py-2 rounded"
                >
                    Filter
                </button>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left border-b border-tan">
                        <th class="p-3 heading-serif text-gold">ID</th>
                        <th class="p-3 heading-serif text-gold">Order ID</th>
                        <th class="p-3 heading-serif text-gold">Member ID</th>
                        <th class="p-3 heading-serif text-gold">Delivery Address</th>
                        <th class="p-3 heading-serif text-gold">Distance</th>
                        <th class="p-3 heading-serif text-gold">Price</th>
                        <th class="p-3 heading-serif text-gold">Status</th>
                        <th class="p-3 heading-serif text-gold">Actions</th>
                        <th class="p-3 heading-serif text-gold">Assigned Driver</th>
                    </tr>
                </thead>
                <tbody id="deliveries_table">
                    <tr>
                        <td colspan="9" class="p-3 text-center text-gray-400">
                            Loading deliveries...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get elements
        const deliveriesTable = document.getElementById('deliveries_table');
        const statusFilter = document.getElementById('status_filter');
        const filterButton = document.getElementById('filter_button');
        const notificationElement = document.getElementById('notification');

        // Fetch all deliveries on page load
        fetchDeliveries();

        // Event listeners
        if (filterButton) {
            filterButton.addEventListener('click', function () {
                const status = statusFilter.value;
                if (status) {
                    fetchDeliveriesByStatus(status);
                } else {
                    fetchDeliveries();
                }
            });
        }

        function fetchDeliveries() {
            fetch('/api/delivery')
                .then((response) => response.json())
                .then((result) => {
                    let deliveries = [];
                    if (Array.isArray(result.data)) {
                        deliveries = result.data;
                    } else if (result.data && result.data.data) {
                        deliveries = result.data.data;
                    }
                    if (deliveries.length) {
                        renderDeliveries(deliveries);
                    } else {
                        showNotification('No deliveries found', 'warning');
                        deliveriesTable.innerHTML =
                            '<tr><td colspan="9" class="p-3 text-center text-gray-400">No deliveries found</td></tr>';
                    }
                })
                .catch((error) => {
                    console.error('Error fetching deliveries:', error);
                    showNotification('Failed to fetch deliveries', 'error');
                });
        }

        function fetchDeliveriesByStatus(status) {
            fetch(`/api/delivery/status/${status}`)
                .then((response) => response.json())
                .then((result) => {
                    let deliveries = [];
                    if (Array.isArray(result.data)) {
                        deliveries = result.data;
                    } else if (result.data && result.data.data) {
                        deliveries = result.data.data;
                    }
                    if (deliveries.length) {
                        renderDeliveries(deliveries);
                    } else {
                        showNotification(
                            `No deliveries with status: ${status}`,
                            'warning'
                        );
                        deliveriesTable.innerHTML =
                            `<tr><td colspan="9" class="p-3 text-center text-gray-400">No deliveries found with status: ${status}</td></tr>`;
                    }
                })
                .catch((error) => {
                    console.error('Error fetching deliveries by status:', error);
                    showNotification('Failed to filter deliveries', 'error');
                });
        }

        function renderDeliveries(deliveries) {
            if (!deliveries.length) {
                deliveriesTable.innerHTML =
                    '<tr><td colspan="9" class="p-3 text-center text-gray-400">No deliveries found</td></tr>';
                return;
            }

            window.deliveriesData = deliveries; // Add this line to store deliveries globally

            let html = '';
            deliveries.forEach((delivery) => {
                html += `
                    <tr class="border-b border-tan/30 hover:bg-black/30">
                        <td class="p-3">${delivery.id}</td>
                        <td class="p-3">${delivery.order_id || 'N/A'}</td>
                        <td class="p-3">${delivery.member_id || 'N/A'}</td>
                        <td class="p-3">${delivery.tujuan || delivery.destination || 'N/A'}</td>
                        <td class="p-3">${
                            delivery.jarak || delivery.distance
                                ? (delivery.jarak || delivery.distance) + ' km'
                                : 'N/A'
                        }</td>
                        <td class="p-3">${
                            delivery.harga_delivery || delivery.price
                                ? 'Rp ' +
                                  numberWithCommas(
                                      delivery.harga_delivery || delivery.price
                                  )
                                : 'N/A'
                        }</td>
                        <td class="p-3">
                            <span class="${getStatusClass(delivery.status)}">${
    delivery.status || 'pending'
}</span>
                        </td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <button
                                    class="bg-gold hover:bg-gold-light text-black px-3 py-1 rounded text-xs"
                                    onclick="updateDeliveryStatus(${delivery.id})"
                                >
                                    Update
                                </button>
                                <button
                                    class="bg-maroon hover:bg-maroon-dark text-cream px-3 py-1 rounded text-xs"
                                    onclick="deleteDelivery(${delivery.id})"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                        <td class="p-3">
                            <select
                                id="driver-select-${delivery.id}"
                                class="driver-select bg-black text-cream border border-tan rounded p-1 text-sm"
                                data-delivery-id="${delivery.id}"
                            >
                                <option value="">Unassigned</option>
                            </select>
                            <button
                                id="assign-driver-btn-${delivery.id}"
                                class="ml-2 bg-gold hover:bg-gold-light text-black px-2 py-1 rounded text-xs"
                                disabled
                            >
                                Assign Driver
                            </button>
                        </td>
                    </tr>`;
            });
            deliveriesTable.innerHTML = html;

            // After rendering deliveries, fetch employees and populate driver dropdowns
            fetchEmployees();

            // Add event listeners for assign driver buttons and enable buttons on selection
            deliveries.forEach((delivery) => {
                const select = document.getElementById(`driver-select-${delivery.id}`);
                const button = document.getElementById(`assign-driver-btn-${delivery.id}`);

                if (select && button) {
                    // Enable button only when a driver is selected
                    select.addEventListener('change', () => {
                        button.disabled = select.value === '';
                    });

                    // Handle assign driver button click
                    button.addEventListener('click', () => {
                        const selectedDriverId = select.value;
                        if (!selectedDriverId) {
                            showNotification('Please select a driver before assigning.', 'error');
                            return;
                        }

                        // Use the append employee API to assign driver
                        fetch('/api/delivery/append', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                delivery_id: delivery.id,
                                employee_id: selectedDriverId,
                            }),
                        })
                            .then((response) => response.json())
                            .then((result) => {
                                if (result.error) {
                                    showNotification(result.error, 'error');
                                } else {
                                    // After successful assignment, update status to 'assigned'
                                    fetch(`/api/delivery/${delivery.id}/status`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        },
                                        body: JSON.stringify({
                                            status: 'assigned',
                                        }),
                                    })
                                        .then((resp) => resp.json())
                                        .then((res) => {
                                            if (res.error) {
                                                showNotification(res.error, 'error');
                                            } else {
                                                showNotification('Driver assigned and status updated successfully.', 'success');
                                                fetchDeliveries();
                                            }
                                        })
                                        .catch((err) => {
                                            console.error('Error updating status:', err);
                                            showNotification('Failed to update status.', 'error');
                                        });
                                }
                            })
                            .catch((error) => {
                                console.error('Error assigning driver:', error);
                                showNotification('Failed to assign driver.', 'error');
                            });
                    });
                }
            });
        }

        function fetchEmployees() {
            fetch('/api/employees?role=manager')
                .then((response) => response.json())
                .then((result) => {
                    let employees = [];
                    if (result.data && Array.isArray(result.data)) {
                        employees = result.data;
                    } else if (
                        result.data &&
                        result.data.data &&
                        Array.isArray(result.data.data)
                    ) {
                        employees = result.data.data;
                    } else if (result && Array.isArray(result)) {
                        employees = result;
                    }
                    populateDriverDropdowns(employees);
                })
                .catch((error) => {
                    console.error('Error fetching employees:', error);
                    showNotification(
                        'Failed to fetch employees for driver assignment',
                        'error'
                    );
                });
        }

        function populateDriverDropdowns(employees) {
            const selects = document.querySelectorAll('.driver-select');
            selects.forEach((select) => {
                // Clear existing options except the first
                while (select.options.length > 1) {
                    select.remove(1);
                }

                employees.forEach((employee) => {
                    const option = document.createElement('option');
                    option.value = employee.id;
                    option.textContent =
                        employee.name ||
                        employee.username ||
                        `Employee ${employee.id}`;
                    select.appendChild(option);
                });

                // Set selected value if delivery has assigned employee_id
                const deliveryId = select.getAttribute('data-delivery-id');
                const delivery = window.deliveriesData.find(
                    (d) => d.id == deliveryId
                );
                if (delivery && delivery.employee_id) {
                    // Check if assigned employee is in the options
                    let assignedOption = Array.from(select.options).find(
                        (opt) => opt.value == delivery.employee_id
                    );
                    if (!assignedOption) {
                        // Add assigned employee as option if missing
                        const assignedEmployeeOption = document.createElement('option');
                        assignedEmployeeOption.value = delivery.employee_id;
                        assignedEmployeeOption.textContent = `Employee ${delivery.employee_id}`;
                        select.appendChild(assignedEmployeeOption);
                    }
                    select.value = delivery.employee_id;
                }

                // Add change event listener to update driver assignment
                // Temporarily disabled to prevent fetch on dropdown change
                // select.addEventListener('change', function () {
                //     const newEmployeeId = this.value;
                //     updateDriverAssignment(deliveryId, newEmployeeId);
                // });
            });
        }

        function updateDriverAssignment(deliveryId, employeeId) {
            // Fetch the entire delivery row data first
            fetch(`/api/delivery/${deliveryId}`)
                .then((response) => response.json())
                .then((deliveryData) => {
                    if (deliveryData.error) {
                        showNotification(deliveryData.error, 'error');
                        return;
                    }
                    // Update the employee_id in the delivery data
                    const updatedDelivery = Object.assign(
                        {},
                        deliveryData.data || deliveryData,
                        {
                            employee_id: employeeId,
                        }
                    );

                    // Send the entire updated delivery object
                    fetch(`/api/delivery/${deliveryId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                        },
                        body: JSON.stringify(updatedDelivery),
                    })
                        .then((response) => response.json())
                        .then((result) => {
                            if (result.error) {
                                showNotification(result.error, 'error');
                            } else {
                                // Removed success notification to prevent showing on dropdown change
                                // Update window.deliveriesData locally to reflect change
                                if (window.deliveriesData) {
                                    const index = window.deliveriesData.findIndex(d => d.id === deliveryId);
                                    if (index !== -1) {
                                        window.deliveriesData[index].employee_id = employeeId;
                                    }
                                }
                                // Removed fetchDeliveries to prevent dropdown reset
                                // fetchDeliveries();
                            }
                        })
                        .catch((error) => {
                            console.error(
                                'Error updating driver assignment:',
                                error
                            );
                            showNotification(
                                'Failed to update driver assignment',
                                'error'
                            );
                        });
                })
                .catch((error) => {
                    console.error('Error fetching delivery data:', error);
                    showNotification(
                        'Failed to fetch delivery data for update',
                        'error'
                    );
                });
        }

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
            notificationElement.innerHTML = message;
            notificationElement.classList.remove(
                'hidden',
                'bg-green-800/20',
                'bg-red-800/20',
                'bg-yellow-600/20'
            );

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

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        // Make these functions available globally
        window.updateDeliveryStatus = function (id) {
            // Get selected driver id from dropdown
            const driverSelect = document.querySelector(`.driver-select[data-delivery-id="${id}"]`);
            const selectedDriverId = driverSelect ? driverSelect.value : null;

            if (!selectedDriverId) {
                showNotification('Please select a driver before updating.', 'error');
                return;
            }

            // Use the append employee API to assign driver
            fetch('/api/delivery/append', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    delivery_id: id,
                    employee_id: selectedDriverId,
                }),
            })
                .then((response) => response.json())
                .then((result) => {
                    if (result.error) {
                        showNotification(result.error, 'error');
                    } else {
                        // After successful assignment, update status to 'assigned'
                        fetch(`/api/delivery/${id}/status`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                status: 'assigned',
                            }),
                        })
                            .then((resp) => resp.json())
                            .then((res) => {
                                if (res.error) {
                                    showNotification(res.error, 'error');
                                } else {
                                    // Removed notification to prevent showing without pressing update button
                                    fetchDeliveries();
                                }
                            })
                            .catch((err) => {
                                console.error('Error updating status:', err);
                                showNotification('Failed to update status.', 'error');
                            });
                    }
                })
                .catch((error) => {
                    console.error('Error assigning driver:', error);
                    showNotification('Failed to assign driver.', 'error');
                });
        };

        window.deleteDelivery = function (id) {
            if (!confirm('Are you sure you want to cancel this delivery?')) return;

            // Update status to 'canceled'
            fetch(`/api/delivery/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    status: 'canceled',
                }),
            })
                .then((response) => response.json())
                .then((result) => {
                    if (result.error) {
                        showNotification(result.error, 'error');
                    } else {
                        showNotification('Delivery canceled successfully.', 'success');
                        // Redirect to driver page with employee_id if available
                        const driverSelect = document.querySelector(`.driver-select[data-delivery-id="${id}"]`);
                        const selectedDriverId = driverSelect ? driverSelect.value : null;
                        if (selectedDriverId) {
                            window.location.href = `/delivery/employee/${selectedDriverId}`;
                        } else {
                            fetchDeliveries();
                        }
                    }
                })
                .catch((error) => {
                    console.error('Error canceling delivery:', error);
                    showNotification('Failed to cancel delivery.', 'error');
                });
        };

        window.deleteDelivery = function (id) {
            if (!confirm('Are you sure you want to delete this delivery?')) return;

            fetch(`/api/delivery/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            })
                .then((response) => response.json())
                .then((result) => {
                    if (result.error) {
                        showNotification(result.error, 'error');
                    } else {
                        showNotification('Delivery deleted successfully', 'success');
                        fetchDeliveries();
                    }
                })
                .catch((error) => {
                    console.error('Error deleting delivery:', error);
                    showNotification('Failed to delete delivery', 'error');
                });
        };
    });
</script>

</html>
