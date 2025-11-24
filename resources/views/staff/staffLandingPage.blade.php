@extends('staff.staffBase')

@section('title', 'Caffe Arabica - Order Tracker')
@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Order Tracker</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="orders-container">
        <!-- Orders will be loaded here via JavaScript -->
    </div>

    <!-- Pagination Controls -->
    <div class="mt-8 flex justify-center" id="pagination-controls">
        <!-- Pagination will be loaded here -->
    </div>
</div>

<!-- Confirmation Modal -->
<div id="kitchenModal" class="fixed inset-0 bg-transparent backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Confirm Action</h3>
            <p class="text-gray-600 mb-6" id="modalMessage">Do you wish to send the Order to the Kitchen?</p>
            <div class="flex justify-end space-x-3">
                <button id="modalCancel" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">
                    Cancel
                </button>
                <button id="modalConfirm" class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700 transition-colors">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const ordersPerPage = 4;
    let selectedOrderId = null;
    let selectedOrderData = null;
    
    // Get modal elements
    const kitchenModal = document.getElementById('kitchenModal');
    const modalMessage = document.getElementById('modalMessage');
    const modalCancel = document.getElementById('modalCancel');
    const modalConfirm = document.getElementById('modalConfirm');
    
    // Setup modal event listeners
    modalCancel.addEventListener('click', function() {
        kitchenModal.classList.add('hidden');
    });
    
    modalConfirm.addEventListener('click', function() {
        if (selectedOrderId && selectedOrderData) {
            updateOrderStatus(selectedOrderId, 'Preparing');
            sendToKitchen(selectedOrderData);
            kitchenModal.classList.add('hidden');
        }
    });
    
    // Close modal when clicking outside
    kitchenModal.addEventListener('click', function(e) {
        if (e.target === kitchenModal) {
            kitchenModal.classList.add('hidden');
        }
    });

    // Fetch orders from the server
    function fetchOrders(page = 1) {
        fetch(`/staff/orders/data?page=${page}&per_page=${ordersPerPage}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displayOrders(data.orders);
                setupPagination(data.total, data.per_page, data.current_page);
            })
            .catch(error => {
                console.error('Error fetching orders:', error);
                document.getElementById('orders-container').innerHTML = 
                    '<p class="text-red-500 col-span-4 text-center">Error loading orders. Please try again.</p>';
            });
    }

    // Display orders in the UI
    function displayOrders(orders) {
        const container = document.getElementById('orders-container');
        
        if (orders.length === 0) {
            container.innerHTML = '<p class="text-gray-500 col-span-4 text-center">No orders found.</p>';
            return;
        }
        
        let html = '';
        
        orders.forEach(order => {
            // Create a safe version of the order data for JavaScript
            const safeOrderData = JSON.stringify(order)
                .replace(/"/g, '&quot;')
                .replace(/'/g, "\\'");
                
            html += `
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 ${getStatusColor(order.status)} order-card">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">${order.OrderID}</h2>
                    </div>
                    <span class="text-sm font-semibold ${getStatusTextColor(order.status)} px-2 py-1 rounded ${getStatusBackgroundColor(order.status)}">${order.status}</span>
                </div>
                
                <div class="mb-3">
                    <div class="text-sm text-gray-600 flex items-center">
                        <span class="inline-flex items-center">
                            ${getOrderTypeIcon(order.order_type)}
                            ${order.order_type}
                        </span>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-3 mb-4">
                    <ul class="space-y-2">
            `;
            
            // Add order items with quantities
            if (order.menu_order_items && order.menu_order_items.length > 0) {
                order.menu_order_items.forEach(item => {
                    html += `
                    <li class="text-gray-700 flex justify-between items-center">
                        <span class="flex items-center">
                            <span class="bg-gray-200 text-gray-700 text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center mr-2">${item.Quantity || 1}</span>
                            ${item.ProductName}
                        </span>
                        ${item.Price ? `<span class="text-sm text-gray-600">P${item.Price}</span>` : ''}
                    </li>`;
                });
            }
            
            // Display subtotal price
            html += `
                    </ul>
                    <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between">
                        <p class="text-sm font-medium text-gray-700">Subtotal:</p>
                        <p class="text-sm font-semibold text-gray-800">P${order.subtotal || '0.00'}</p>
                    </div>
                </div>
            `;
            
            // Display special requests if available
            if (order.special_request) {
                html += `
                <div class="border-t border-gray-200 pt-3 mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-1">Special Request:</p>
                    <p class="text-sm text-gray-600 bg-yellow-50 p-2 rounded">${order.special_request}</p>
                </div>
                `;
            }
            
            html += `
                <div class="border-t border-gray-200 pt-3">
                    <div class="grid grid-cols-3 gap-2">
                        <button data-order-id="${order.OrderID}" data-order-data="${safeOrderData}" class="to-kitchen-btn bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded text-sm font-medium transition-colors">
                            To Kitchen
                        </button>
                        <button onclick="cancelOrder('${order.OrderID}')" class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded text-sm font-medium transition-colors">
                            Cancel
                        </button>
                        <button onclick="voidOrder('${order.OrderID}')" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-3 rounded text-sm font-medium transition-colors">
                            Void
                        </button>
                    </div>
                </div>
            </div>
            `;
        });
        
        container.innerHTML = html;
        
        // Add event listeners to all "To Kitchen" buttons
        document.querySelectorAll('.to-kitchen-btn').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                const orderData = JSON.parse(this.getAttribute('data-order-data'));
                showKitchenConfirmation(orderId, orderData);
            });
        });
    }

    // Show kitchen confirmation modal
    window.showKitchenConfirmation = function(orderId, orderData) {
        selectedOrderId = orderId;
        selectedOrderData = orderData;
        modalMessage.textContent = `Do you wish to send Order #${orderId} to the Kitchen?`;
        kitchenModal.classList.remove('hidden');
    };

    // Send order data to kitchen
    function sendToKitchen(orderData) {
        fetch('/staff/orders/send-to-kitchen', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                order_id: orderData.OrderID,
                order_name: orderData.OrderID,
                order_type: orderData.order_type,
                special_request: orderData.special_request,
                subtotal: orderData.subtotal,
                items: orderData.menu_order_items || []
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error sending to kitchen:', data.message);
                alert('Error sending order to kitchen: ' + data.message);
            } else {
                console.log('Order successfully sent to kitchen');
            }
        })
        .catch(error => {
            console.error('Error sending to kitchen:', error);
            alert('Error sending order to kitchen. Please try again.');
        });
    }

    // Set up pagination controls
    function setupPagination(total, perPage, currentPage) {
        const totalPages = Math.ceil(total / perPage);
        const paginationContainer = document.getElementById('pagination-controls');
        
        if (totalPages <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }
        
        let html = `
            <nav class="flex items-center space-x-2">
                <button onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} 
                    class="px-3 py-1 rounded border ${currentPage === 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50'}">
                    Previous
                </button>
        `;
        
        // Show limited page numbers with ellipsis for many pages
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        if (startPage > 1) {
            html += `
                <button onclick="changePage(1)" class="px-3 py-1 rounded border bg-white text-gray-700 hover:bg-gray-50">
                    1
                </button>
            `;
            if (startPage > 2) {
                html += `<span class="px-2 text-gray-500">...</span>`;
            }
        }
        
        for (let i = startPage; i <= endPage; i++) {
            html += `
                <button onclick="changePage(${i})" 
                    class="px-3 py-1 rounded border ${i === currentPage ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}">
                    ${i}
                </button>
            `;
        }
        
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                html += `<span class="px-2 text-gray-500">...</span>`;
            }
            html += `
                <button onclick="changePage(${totalPages})" class="px-3 py-1 rounded border bg-white text-gray-700 hover:bg-gray-50">
                    ${totalPages}
                </button>
            `;
        }
        
        html += `
                <button onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''} 
                    class="px-3 py-1 rounded border ${currentPage === totalPages ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-50'}">
                    Next
                </button>
            </nav>
        `;
        
        paginationContainer.innerHTML = html;
    }

    // Change page function
    window.changePage = function(page) {
        currentPage = page;
        fetchOrders(page);
        window.scrollTo(0, 0);
    };

    // Get status color for border
    function getStatusColor(status) {
        switch(status) {
            case 'New Order': return 'border-blue-500';
            case 'Preparing': return 'border-yellow-500';
            case 'Bumped': return 'border-orange-500';
            case 'Done': return 'border-green-500';
            case 'Completed': return 'border-green-500';
            case 'Cancelled': return 'border-red-500';
            case 'Voided': return 'border-gray-500';
            default: return 'border-gray-500';
        }
    }

    // Get status text color
    function getStatusTextColor(status) {
        switch(status) {
            case 'New Order': return 'text-blue-700';
            case 'Preparing': return 'text-yellow-700';
            case 'Bumped': return 'text-orange-700';
            case 'Done': return 'text-green-700';
            case 'Completed': return 'text-green-700';
            case 'Cancelled': return 'text-red-700';
            case 'Voided': return 'text-gray-700';
            default: return 'text-gray-700';
        }
    }

    // Get status background color
    function getStatusBackgroundColor(status) {
        switch(status) {
            case 'New Order': return 'bg-blue-100';
            case 'Preparing': return 'bg-yellow-100';
            case 'Bumped': return 'bg-orange-100';
            case 'Done': return 'bg-green-100';
            case 'Completed': return 'bg-green-100';
            case 'Cancelled': return 'bg-red-100';
            case 'Voided': return 'bg-gray-100';
            default: return 'bg-gray-100';
        }
    }

    // Get order type icon
    function getOrderTypeIcon(orderType) {
        switch(orderType.toLowerCase()) {
            case 'dine-in': return '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M2.5 5a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V5zm1 .5v9h13v-9h-13z"/><path d="M5.5 7a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5H6a.5.5 0 0 1-.5-.5V7z"/></svg>';
            case 'takeaway': return '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5zm10 11H5v-1h10v1z"/><path d="M7 4V2a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2H7z"/></svg>';
            case 'delivery': return '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M2.5 11.5a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5v-1z"/><path d="M5.5 6a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-9z"/><path d="M8.5 9a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1z"/></svg>';
            default: return '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M2.5 5a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V5zm1 .5v9h13v-9h-13z"/></svg>';
        }
    }

    // Action functions
    window.cancelOrder = function(orderId) {
        if (confirm('Are you sure you want to cancel this order?')) {
            updateOrderStatus(orderId, 'Cancelled');
        }
    };

    window.voidOrder = function(orderId) {
        if (confirm('Are you sure you want to void this order?')) {
            updateOrderStatus(orderId, 'Voided');
        }
    };

    function updateOrderStatus(orderId, status) {
        fetch('/staff/orders/update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                order_id: orderId,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Refresh the orders
                fetchOrders(currentPage);
            } else {
                alert('Error updating order: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating order.');
        });
    }

    // Initial fetch
    fetchOrders(currentPage);
    
    // Optional: Set up auto-refresh every 30 seconds
    setInterval(() => {
        fetchOrders(currentPage);
    }, 30000);
});
</script>

<style>
    .order-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    #kitchenModal {
        transition: opacity 0.3s ease;
    }
    
    #kitchenModal .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
    
    .to-kitchen-btn {
        cursor: pointer;
    }
</style>
@endsection