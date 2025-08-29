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

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const ordersPerPage = 4;
    
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
            // Calculate time difference
            const orderDate = new Date(order.order_date);
            const now = new Date();
            const diffMs = now - orderDate;
            const diffMins = Math.floor(diffMs / 60000);
            
            html += `
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 ${getStatusColor(order.status)}">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-gray-800">${order.OrderID}</h2>
                    <span class="text-sm font-semibold ${getStatusTextColor(order.status)}">${order.status}</span>
                </div>
                
                <div class="mb-4">
                    <div class="text-sm text-gray-600 mt-1">${order.order_type}</div>
                </div>
                
                <div class="border-t border-gray-200 pt-3 mb-4">
                    <ul class="space-y-2">
            `;
            
            // Add order items
            if (order.menu_order_items && order.menu_order_items.length > 0) {
                order.menu_order_items.forEach(item => {
                    html += `<li class="text-gray-700">${item.ProductName}</li>`;
                });
            }
            
            html += `
                    </ul>
                </div>
                
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex space-x-2">
                        <button onclick="sendToKitchen('${order.OrderID}')" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded text-sm font-medium">
                            Send to Kitchen
                        </button>
                        <button onclick="cancelOrder('${order.OrderID}')" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded text-sm font-medium">
                            Cancel
                        </button>
                        <button onclick="voidOrder('${order.OrderID}')" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded text-sm font-medium">
                            Void
                        </button>
                    </div>
                </div>
            </div>
            `;
        });
        
        container.innerHTML = html;
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
        
        for (let i = 1; i <= totalPages; i++) {
            html += `
                <button onclick="changePage(${i})" 
                    class="px-3 py-1 rounded border ${i === currentPage ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}">
                    ${i}
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
    };

    // Get status color for border
    function getStatusColor(status) {
        switch(status) {
            case 'New Order': return 'border-blue-500';
            case 'Preparing': return 'border-yellow-500';
            case 'Bumped': return 'border-orange-500';
            case 'Done': return 'border-green-500';
            default: return 'border-gray-500';
        }
    }

    // Get status text color
    function getStatusTextColor(status) {
        switch(status) {
            case 'New Order': return 'text-blue-600';
            case 'Preparing': return 'text-yellow-600';
            case 'Bumped': return 'text-orange-600';
            case 'Done': return 'text-green-600';
            default: return 'text-gray-600';
        }
    }

    // Action functions
    window.sendToKitchen = function(orderId) {
        updateOrderStatus(orderId, 'Preparing');
    };

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
@endsection