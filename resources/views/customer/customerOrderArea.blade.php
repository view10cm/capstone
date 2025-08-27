@extends('customerBase')

@section('title', 'Caffe Arabica - Order Area')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        .active-category {
            background-color: #f97316;
            /* orange-500 */
            color: white;
        }

        .active-subcategory {
            border-bottom: 2px solid #f97316;
            /* orange-500 */
            color: #f97316;
        }
        
        /* Custom scrollbar for order items */
        .order-items-container {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .order-items-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .order-items-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .order-items-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .order-items-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Loading spinner */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left: 4px solid #f97316;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 10px;
            vertical-align: middle;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush

@section('content')
    <div class="flex min-h-screen bg-gray-50">
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col relative">
            <!-- Brand Header -->
            <div class="">
                <img src="{{ asset('images/Brand Header.svg') }}" alt="Caffe Arabica" class="w-full object-cover"
                    style="height: 120px; max-height: 120px;">
            </div>

            @include('customer.productsGallery')

            <!-- Spacer to push the conversation panel and bottom image down -->
            <div class="flex-1"></div>

            <!-- Bottom Customer Order Area Image with Microphone Button -->
            <div class="mt-auto relative">
                <!-- Conversation Panel - Positioned behind the microphone, full width of main content area -->
                <div class="absolute bottom-0 left-0 right-0 z-10 mb-6">
                    <div class="bg-white shadow-lg border border-gray-200 max-h-48 overflow-hidden"
                        style="font-family: 'Manrope', 'Arial', sans-serif;">
                        <!-- Conversation Messages Area -->
                        <div class="p-6 max-h-40 overflow-y-auto scrollbar-hide"
                            style="scrollbar-width: none; -ms-overflow-style: none;">
                            <style>
                                .scrollbar-hide::-webkit-scrollbar {
                                    display: none;
                                }
                            </style>
                            <!-- Welcome Message -->
                            <div class="mb-4">
                                <div class="flex items-start space-x-3">
                                    <div class="bg-orange-100 rounded-full p-2 flex-shrink-0">
                                        <img src="{{ asset('images/voiceFill.svg') }}" alt="Voice Assistant"
                                            class="w-4 h-4">
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-gray-100 rounded-lg px-4 py-3 max-w-md">
                                            <p class="text-gray-800" style="font-size: 16px;">Hello! Welcome to Caffe
                                                Arabica. What would you like to order today?</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Assistant</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Placeholder for conversation messages -->
                            <div class="text-center text-gray-400 py-8">

                            </div>
                        </div>
                    </div>
                </div>

                <img src="{{ asset('images/orderSpeakOrange.svg') }}" alt="Customer Order Area"
                    class="w-full h-auto relative z-20">

                <!-- Microphone Button Overlay -->
                <div class="absolute inset-0 flex items-center justify-center z-30" style="transform: translateY(-25%)">
                    <button
                        class="bg-white rounded-full p-4 shadow-lg hover:shadow-xl transition-shadow duration-200 hover:bg-gray-50 active:scale-95 transform transition-transform border-2 border-gray-300">
                        <svg class="w-8 h-8 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z" />
                            <path
                                d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Order Summary -->
        <div class="w-80 bg-white shadow-lg border-l border-gray-200 rounded-tl-xl rounded-tr-xl">
            <div class="p-6 h-full flex flex-col">
                <!-- Header -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Order Summary</h2>
                    
                    <!-- Order Type Selection -->
                    <div class="flex mt-4 space-x-2">
                        <button id="dine-in-btn" class="flex-1 py-2 bg-orange-500 text-white rounded-md font-medium text-sm">
                            Dine-in
                        </button>
                        <button id="takeout-btn" class="flex-1 py-2 bg-gray-200 text-gray-700 rounded-md font-medium text-sm">
                            Takeout
                        </button>
                    </div>
                </div>

                <!-- Order Items Container -->
                <div id="order-items-container" class="order-items-container mb-4">
                    <!-- Order items will be dynamically added here -->
                </div>

                <!-- Order Summary Details -->
                <div class="mt-auto border-t border-gray-200 pt-4">
                    <!-- Special Request -->
                    <div class="mb-4">
                        <textarea 
                            id="special-request" 
                            placeholder="Special Request" 
                            class="w-full p-2 border border-gray-300 rounded-md text-sm resize-none"
                            rows="2"
                        ></textarea>
                    </div>
                    
                    <!-- Summary -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Items (<span id="items-count">0</span>)</span>
                            <span>₱<span id="subtotal">0.00</span></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax</span>
                            <span>₱<span id="tax">0.00</span></span>
                        </div>
                        <div class="flex justify-between font-semibold text-lg mt-2">
                            <span>Total Amount</span>
                            <span>₱<span id="total-amount">0.00</span></span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-3 mt-6">
                        <button id="cancel-order" class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-md font-medium">
                            Cancel
                        </button>
                        <button id="checkout-btn" class="flex-1 py-3 bg-orange-500 text-white rounded-md font-medium" disabled style="cursor: not-allowed; opacity: 0.6;">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Order management
        window.orderItems = [];
        window.orderType = 'dine-in';

        // Set default category to Drinks
        window.currentCategory = 'drinks';
        window.currentSubcategory = 'hot';

        window.addToOrder = function(product) {
            // Check if product already exists in order
            const existingItemIndex = orderItems.findIndex(item => item.id === product.id);
            if (existingItemIndex !== -1) {
                orderItems[existingItemIndex].quantity += 1;
            } else {
                orderItems.push({
                    id: product.id,
                    name: product.productName,
                    price: parseFloat(product.productPrice),
                    quantity: 1,
                    image: product.productImage || null
                });
            }
            updateOrderDisplay();
        }

        window.updateOrderDisplay = function() {
            const orderContainer = document.getElementById('order-items-container');
            const itemsCount = document.getElementById('items-count');
            const subtotalEl = document.getElementById('subtotal');
            const taxEl = document.getElementById('tax');
            const totalAmountEl = document.getElementById('total-amount');
            const checkoutBtn = document.getElementById('checkout-btn');
            orderContainer.innerHTML = '';
            if (orderItems.length === 0) {
                orderContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center text-center py-10">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z" />
                            <path d="M9 8V17H11V8H9ZM13 8V17H15V8H13Z" />
                        </svg>
                        <p class="text-gray-400 text-sm font-medium">Your order is still empty</p>
                    </div>
                `;
                itemsCount.textContent = '0';
                subtotalEl.textContent = '0.00';
                taxEl.textContent = '0.00';
                totalAmountEl.textContent = '0.00';
                checkoutBtn.disabled = true;
                checkoutBtn.style.cursor = 'not-allowed';
                checkoutBtn.style.opacity = '0.6';
                return;
            } else {
                checkoutBtn.disabled = false;
                checkoutBtn.style.cursor = 'pointer';
                checkoutBtn.style.opacity = '1';
            }
            let itemsTotal = 0;
            let itemsCountValue = 0;
            orderItems.forEach((item, index) => {
                itemsTotal += item.price * item.quantity;
                itemsCountValue += item.quantity;
                const itemElement = document.createElement('div');
                itemElement.className = 'flex items-center bg-white rounded-lg shadow p-2 mb-2';
                itemElement.innerHTML = `
                    <div class="w-16 h-16 bg-gray-200 rounded mr-3 flex-shrink-0 flex items-center justify-center overflow-hidden">
                        ${item.image ? `<img src="/storage/${item.image}" alt="${item.name}" class="w-full h-full object-cover rounded" />` : ''}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-sm text-gray-800">${item.name}</span>
                            <span class="font-bold text-orange-500 text-base">₱${item.price.toFixed(2)}</span>
                        </div>
                        <div class="flex items-center mt-2">
                            <button onclick="decreaseQuantity(${index})" class="w-6 h-6 bg-orange-200 rounded-full flex items-center justify-center text-orange-700 font-bold">-</button>
                            <span class="mx-2 text-base font-semibold">${item.quantity}</span>
                            <button onclick="increaseQuantity(${index})" class="w-6 h-6 bg-orange-200 rounded-full flex items-center justify-center text-orange-700 font-bold">+</button>
                            <button onclick="removeItem(${index})" class="ml-3 w-6 h-6 bg-red-200 rounded-full flex items-center justify-center text-red-700 hover:bg-red-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                orderContainer.appendChild(itemElement);
            });
            const tax = itemsTotal * 0.00;
            const totalAmount = itemsTotal + tax;
            itemsCount.textContent = itemsCountValue;
            subtotalEl.textContent = itemsTotal.toFixed(2);
            taxEl.textContent = tax.toFixed(2);
            totalAmountEl.textContent = totalAmount.toFixed(2);
        }

        window.increaseQuantity = function(index) {
            orderItems[index].quantity += 1;
            updateOrderDisplay();
        }

        window.decreaseQuantity = function(index) {
            if (orderItems[index].quantity > 1) {
                orderItems[index].quantity -= 1;
            } else {
                orderItems.splice(index, 1);
            }
            updateOrderDisplay();
        }

        window.removeItem = function(index) {
            orderItems.splice(index, 1);
            updateOrderDisplay();
        }

        // Function to handle checkout
        window.processCheckout = function() {
            const checkoutBtn = document.getElementById('checkout-btn');
            const originalText = checkoutBtn.innerHTML;
            
            // Show loading spinner
            checkoutBtn.innerHTML = '<div class="spinner"></div> Processing...';
            checkoutBtn.disabled = true;
            
            // Prepare order data
            const orderData = {
                order_type: orderType,
                order_date: new Date().toISOString(),
                special_request: document.getElementById('special-request').value,
                total_items: parseInt(document.getElementById('items-count').textContent),
                subtotal: parseFloat(document.getElementById('subtotal').textContent),
                tax: parseFloat(document.getElementById('tax').textContent),
                totalAmount: parseFloat(document.getElementById('total-amount').textContent),
                status: 'New Order',
                order_items: orderItems.map(item => ({
                    product_name: item.name,
                    quantity: item.quantity,
                    unit_price: item.price
                }))
            };
            
            // Send AJAX request to save order
            fetch('{{ route("order.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order placed successfully! Your order ID is: ' + data.order_id);
                    orderItems = [];
                    updateOrderDisplay();
                    document.getElementById('special-request').value = '';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing your order. Please try again.');
            })
            .finally(() => {
                // Restore button text
                checkoutBtn.innerHTML = originalText;
                checkoutBtn.disabled = orderItems.length === 0;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('drinks-btn').classList.add('active-category');
            document.querySelector('#drinks-subcategories button').classList.add('active-subcategory');
            document.getElementById('dine-in-btn').addEventListener('click', function() {
                this.classList.add('bg-orange-500', 'text-white');
                this.classList.remove('bg-gray-200', 'text-gray-700');
                document.getElementById('takeout-btn').classList.add('bg-gray-200', 'text-gray-700');
                document.getElementById('takeout-btn').classList.remove('bg-orange-500', 'text-white');
                orderType = 'dine-in';
            });
            document.getElementById('takeout-btn').addEventListener('click', function() {
                this.classList.add('bg-orange-500', 'text-white');
                this.classList.remove('bg-gray-200', 'text-gray-700');
                document.getElementById('dine-in-btn').classList.add('bg-gray-200', 'text-gray-700');
                document.getElementById('dine-in-btn').classList.remove('bg-orange-500', 'text-white');
                orderType = 'takeout';
            });
            document.getElementById('cancel-order').addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel this order?')) {
                    orderItems = [];
                    updateOrderDisplay();
                }
            });
            document.getElementById('checkout-btn').addEventListener('click', processCheckout);
            updateOrderDisplay();
        });
    </script>
@endsection