@extends('base')

@section('title', 'Caffe Arabica - Order History')

@section('content')
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        @include('admin.adminSidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-lg border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center">
                        <!-- Left side - Title -->
                        <div class="flex-1">
                            <h1 class="text-black" style="font-family: 'Manrope', sans-serif; font-weight: 600; font-style: normal; font-size: 24px;">Order History</h1>
                            <p class="text-sm text-gray-600 mt-1">Manage your order history</p>
                        </div>
                        
                        <!-- Center - Search Bar -->
                        <div class="flex-1 flex justify-center">
                            <div class="relative" style="width: 550px;">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    placeholder="Search..." 
                                    class="block w-full pl-12 pr-4 border border-gray-300 text-sm transition-all duration-200 focus:outline-none focus:ring-0 focus:border-orange-500 focus:bg-white"
                                    style="height: 45px; border-radius: 50px; background-color: #f5f5f5;"
                                    id="searchInput"
                                >
                            </div>
                        </div>

                        <!-- Right side - Date and Time -->
                        <div class="flex-1 flex justify-end">
                            <div class="text-right">
                                <div id="currentDate" class="text-sm font-medium text-gray-900"></div>
                                <div id="currentTime" class="text-xs text-gray-600 mt-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <!-- Back to Dashboard Button -->
                    <div class="mb-6">
                        <a href="{{ route('admin.adminDashboard') }}" class="inline-flex items-center text-orange-500 hover:text-orange-700 font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                    </div>

                    <!-- Order History Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="orderHistoryTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Completed</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    // Check if orders variable exists, otherwise use empty collection
                                    $orders = $orders ?? collect([]);
                                @endphp
                                
                                @forelse($orders as $order)
                                <tr class="order-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->OrderID }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $order->total_items }} items</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">P{{ number_format($order->totalAmount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $order->updated_at->format('Y-m-d H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-orange-600 hover:text-orange-900 view-details" data-order-id="{{ $order->OrderID }}">View Details</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No orders found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($orders->count() > 0)
                    <div class="flex items-center justify-between mt-6">
                        <div class="text-sm text-gray-700">
                            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} results
                        </div>
                        <div class="flex space-x-2">
                            @if($orders->onFirstPage())
                                <span class="px-3 py-1 rounded-md bg-gray-100 text-gray-400 text-sm">Previous</span>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm">Previous</a>
                            @endif

                            <div class="text-sm text-gray-700">
                                Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}
                            </div>

                            @if($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm">Next</a>
                            @else
                                <span class="px-3 py-1 rounded-md bg-gray-100 text-gray-400 text-sm">Next</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-1/2 max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center pb-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">Order Details: <span id="modalOrderId"></span></h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="py-4">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">Order Type</p>
                            <p class="text-sm font-medium" id="modalOrderType"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Order Date</p>
                            <p class="text-sm font-medium" id="modalOrderDate"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Special Request</p>
                            <p class="text-sm font-medium" id="modalSpecialRequest"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="text-sm font-medium" id="modalStatus"></p>
                        </div>
                    </div>
                    
                    <h4 class="text-md font-medium mb-2">Order Items</h4>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody id="modalOrderItems" class="bg-white divide-y divide-gray-200">
                            <!-- Items will be populated by JavaScript -->
                        </tbody>
                    </table>
                    
                    <div class="mt-4 border-t pt-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span>Subtotal:</span>
                            <span id="modalSubtotal"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Tax:</span>
                            <span id="modalTax"></span>
                        </div>
                        <div class="flex justify-between text-sm font-bold mt-2">
                            <span>Total Amount:</span>
                            <span id="modalTotalAmount"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the external JavaScript file -->
    <script src="{{ asset('js/inventory.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Date and time display
            function updateDateTime() {
                const now = new Date();
                const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
                
                document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', dateOptions);
                document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', timeOptions);
            }
            
            updateDateTime();
            setInterval(updateDateTime, 60000);
            
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const orderRows = document.querySelectorAll('.order-row');
            
            if (searchInput && orderRows.length > 0) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    
                    orderRows.forEach(row => {
                        const orderId = row.querySelector('td:first-child').textContent.toLowerCase();
                        const items = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                        const total = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                        const date = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                        
                        if (orderId.includes(searchTerm) || items.includes(searchTerm) || 
                            total.includes(searchTerm) || date.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
            
            // Modal functionality
            const modal = document.getElementById('orderDetailsModal');
            const closeModalBtn = document.getElementById('closeModal');
            const viewDetailsButtons = document.querySelectorAll('.view-details');
            
            if (closeModalBtn && modal) {
                closeModalBtn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                });
                
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            }
            
            if (viewDetailsButtons.length > 0) {
                viewDetailsButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const orderId = this.getAttribute('data-order-id');
                        
                        // Show loading state
                        document.getElementById('modalOrderId').textContent = 'Loading...';
                        
                        // Fetch order details via AJAX
                        fetch(`/admin/orders/${orderId}/details`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                document.getElementById('modalOrderId').textContent = data.OrderID;
                                document.getElementById('modalOrderType').textContent = data.order_type;
                                document.getElementById('modalOrderDate').textContent = new Date(data.order_date).toLocaleString();
                                document.getElementById('modalSpecialRequest').textContent = data.special_request || 'None';
                                document.getElementById('modalStatus').textContent = data.status;
                                document.getElementById('modalSubtotal').textContent = 'P' + parseFloat(data.subtotal).toFixed(2);
                                document.getElementById('modalTax').textContent = 'P' + parseFloat(data.tax).toFixed(2);
                                document.getElementById('modalTotalAmount').textContent = 'P' + parseFloat(data.totalAmount).toFixed(2);
                                
                                // Populate order items
                                const itemsContainer = document.getElementById('modalOrderItems');
                                itemsContainer.innerHTML = '';
                                
                                if (data.menuOrderItems && data.menuOrderItems.length > 0) {
                                    data.menuOrderItems.forEach(item => {
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
                                            <td class="px-4 py-2 text-sm">${item.ProductName}</td>
                                            <td class="px-4 py-2 text-sm">${item.Quantity}</td>
                                            <td class="px-4 py-2 text-sm">P${parseFloat(item.unitPrice).toFixed(2)}</td>
                                            <td class="px-4 py-2 text-sm">P${(item.Quantity * item.unitPrice).toFixed(2)}</td>
                                        `;
                                        itemsContainer.appendChild(row);
                                    });
                                } else {
                                    itemsContainer.innerHTML = '<tr><td colspan="4" class="px-4 py-2 text-sm text-center">No items found</td></tr>';
                                }
                                
                                modal.classList.remove('hidden');
                            })
                            .catch(error => {
                                console.error('Error fetching order details:', error);
                                alert('Error loading order details. Please try again.');
                                modal.classList.add('hidden');
                            });
                    });
                });
            }
        });
    </script>
@endsection