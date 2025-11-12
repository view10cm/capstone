@extends('base')

@section('title', 'Caffe Arabica - Dashboard')

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
                            <h1 class="text-black" style="font-family: 'Manrope', sans-serif; font-weight: 600; font-style: normal; font-size: 24px;">Dashboard</h1>
                            <p class="text-sm text-gray-600 mt-1">Inventory and Sales Summary</p>
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

            <!-- Dashboard Cards Section -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Today's Sales Card -->
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col">
                    @php
                        use Illuminate\Support\Facades\DB;
                        $totalSales = DB::table('menu_order_transactions')->sum('unitPrice');
                    @endphp
                    <div class="text-2xl font-bold text-gray-900 mb-2">₱{{ number_format($totalSales, 2) }}</div>
                    <div class="text-sm text-gray-600 mb-4">Today's Sales</div>
                </div>

                <!-- Meals Served Card -->
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col">
                    @php
                        $orderCount = DB::table('order_transactions')->count('OrderID');
                    @endphp
                    <div class="text-2xl font-bold text-gray-900 mb-2">{{ $orderCount }}</div>
                    <div class="text-sm text-gray-600 mb-4">Meals Served</div>
                </div>

                <!-- Active Orders Card -->
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col">
                    @php
                        $completedOrdersCount = DB::table('kitchen_cooking')->where('status', 'Completed')->count();
                    @endphp
                    <div class="text-2xl font-bold text-gray-900 mb-2">{{ $completedOrdersCount }}</div>
                    <div class="text-sm text-gray-600 mb-4">Completed Orders</div>
                </div>

                <!-- Low Stock Items Card -->
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col">
                    @php
                        $lowStockCount = DB::table('ingredients')->where('ingredient_availability', 'Low Stock')->count();
                    @endphp
                    <div class="text-2xl font-bold text-gray-900 mb-2">{{ $lowStockCount }}</div>
                    <div class="text-sm text-gray-600 mb-4">Low Stock Items</div>
                </div>
            </div>

            <!-- Sales Chart Section -->
            <div class="px-6 pb-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Sales Chart -->
                <div class="bg-white rounded-xl shadow-md p-6 lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Sales</h2>
                        <div class="flex space-x-4">
                            <button class="text-sm text-gray-600 hover:text-orange-500">This Month</button>
                            <button class="text-sm text-gray-600 hover:text-orange-500">Previous Month</button>
                            <button class="text-sm text-gray-600 hover:text-orange-500">Monthly</button>
                            <button class="text-sm text-gray-600 hover:text-orange-500">Order History</button>
                        </div>
                    </div>
                    
                    <!-- Chart Container -->
                    <div class="relative h-64 mt-4">
                        <!-- Y-axis labels -->
                        <div class="absolute left-0 top-0 h-full flex flex-col justify-between text-xs text-gray-500">
                            <span>100</span>
                            <span>80</span>
                            <span>60</span>
                            <span>40</span>
                            <span>20</span>
                            <span>0</span>
                        </div>
                        
                        <!-- Chart bars -->
                        <div class="ml-8 h-full flex items-end justify-between">
                            <!-- January -->
                            <div class="flex flex-col items-center w-8">
                                <div class="bg-orange-400 w-6 rounded-t" style="height: 45%"></div>
                                <span class="text-xs text-gray-600 mt-1">Jan</span>
                            </div>
                            
                            <!-- February -->
                            <div class="flex flex-col items-center w-8">
                                <div class="bg-orange-400 w-6 rounded-t" style="height: 65%"></div>
                                <span class="text-xs text-gray-600 mt-1">Feb</span>
                            </div>
                            
                            <!-- March -->
                            <div class="flex flex-col items-center w-8">
                                <div class="bg-orange-400 w-6 rounded-t" style="height: 85%"></div>
                                <span class="text-xs text-gray-600 mt-1">Mar</span>
                            </div>
                            
                            <!-- April -->
                            <div class="flex flex-col items-center w-8">
                                <div class="bg-orange-400 w-6 rounded-t" style="height: 70%"></div>
                                <span class="text-xs text-gray-600 mt-1">Apr</span>
                            </div>
                            
                            <!-- May -->
                            <div class="flex flex-col items-center w-8">
                                <div class="bg-orange-400 w-6 rounded-t" style="height: 55%"></div>
                                <span class="text-xs text-gray-600 mt-1">May</span>
                            </div>
                            
                            <!-- June -->
                            <div class="flex flex-col items-center w-8">
                                <div class="bg-orange-400 w-6 rounded-t" style="height: 90%"></div>
                                <span class="text-xs text-gray-600 mt-1">Jun</span>
                            </div>
                            
                            <!-- July -->
                            <div class="flex flex-col items-center w-8">
                                <div class="bg-orange-400 w-6 rounded-t" style="height: 75%"></div>
                                <span class="text-xs text-gray-600 mt-1">Jul</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Popular Category -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Popular Category</h2>
                    
                    <div class="space-y-4">
                        <!-- Category 1 -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Coffee</span>
                            <span class="text-sm font-semibold text-gray-900">331</span>
                        </div>
                        
                        <!-- Category 2 -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Pastries</span>
                            <span class="text-sm font-semibold text-gray-900">770</span>
                        </div>
                        
                        <!-- Category 3 -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Sandwiches</span>
                            <span class="text-sm font-semibold text-gray-900">858</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Selling Products and Inventory Status Section -->
            <div class="px-6 pb-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Selling Products -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Top Selling Products</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="pb-3 text-left text-sm font-medium text-gray-600">#</th>
                                    <th class="pb-3 text-left text-sm font-medium text-gray-600">Item Name</th>
                                    <th class="pb-3 text-left text-sm font-medium text-gray-600">Category</th>
                                    <th class="pb-3 text-left text-sm font-medium text-gray-600">Items Sold</th>
                                    <th class="pb-3 text-left text-sm font-medium text-gray-600">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Get top 3 most frequently ordered products
                                    $topProducts = DB::table('menu_order_transactions')
                                        ->select('ProductName', DB::raw('COUNT(*) as total_sold'), DB::raw('SUM(unitPrice) as total_revenue'))
                                        ->groupBy('ProductName')
                                        ->orderByDesc('total_sold')
                                        ->limit(3)
                                        ->get();
                                    
                                    $counter = 1;
                                @endphp
                                
                                @foreach($topProducts as $product)
                                    <tr class="border-b border-gray-200">
                                        <td class="py-4 text-sm text-gray-900">{{ $counter++ }}</td>
                                        <td class="py-4 text-sm text-gray-900">{{ $product->ProductName }}</td>
                                        <td class="py-4 text-sm text-gray-600">
                                            @php
                                                // Simple categorization based on product name
                                                $category = 'Other';
                                                if (stripos($product->ProductName, 'coffee') !== false || stripos($product->ProductName, 'caffe') !== false || stripos($product->ProductName, 'latte') !== false) {
                                                    $category = 'Drinks';
                                                } elseif (stripos($product->ProductName, 'beef') !== false || stripos($product->ProductName, 'pork') !== false || stripos($product->ProductName, 'chicken') !== false) {
                                                    $category = 'Main Course';
                                                } elseif (stripos($product->ProductName, 'sandwich') !== false || stripos($product->ProductName, 'pastry') !== false || stripos($product->ProductName, 'cake') !== false) {
                                                    $category = 'Appetizers';
                                                }
                                            @endphp
                                            {{ $category }}
                                        </td>
                                        <td class="py-4 text-sm text-gray-900">{{ $product->total_sold }}</td>
                                        <td class="py-4 text-sm text-gray-900">₱{{ number_format($product->total_revenue, 2) }}</td>
                                    </tr>
                                @endforeach
                                
                                @if($topProducts->isEmpty())
                                    <tr>
                                        <td colspan="5" class="py-4 text-sm text-gray-600 text-center">No products sold yet</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Inventory Status -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Inventory Status</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="pb-3 text-left text-sm font-medium text-gray-600">Product Name</th>
                                    <th class="pb-3 text-left text-sm font-medium text-gray-600">Stock</th>
                                    <th class="pb-3 text-left text-sm font-medium text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Get top 3 ingredients with highest quantity
                                    $topIngredients = DB::table('ingredients')
                                        ->select('ingredient_name', 'ingredient_quantity', 'ingredient_availability')
                                        ->orderByDesc('ingredient_quantity')
                                        ->limit(3)
                                        ->get();
                                @endphp
                                
                                @foreach($topIngredients as $ingredient)
                                    <tr class="border-b border-gray-200">
                                        <td class="py-4 text-sm text-gray-900">{{ $ingredient->ingredient_name }}</td>
                                        <td class="py-4 text-sm text-gray-600">{{ $ingredient->ingredient_quantity }}</td>
                                        <td class="py-4 text-sm font-medium 
                                            @if($ingredient->ingredient_availability === 'In Stock') text-green-600
                                            @elseif($ingredient->ingredient_availability === 'Low Stock') text-yellow-600
                                            @else text-red-600 @endif">
                                            {{ $ingredient->ingredient_availability }}
                                        </td>
                                    </tr>
                                @endforeach
                                
                                @if($topIngredients->isEmpty())
                                    <tr>
                                        <td colspan="3" class="py-4 text-sm text-gray-600 text-center">No ingredients found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the external JavaScript file -->
    <script src="{{ asset('js/inventory.js') }}"></script>
@endsection