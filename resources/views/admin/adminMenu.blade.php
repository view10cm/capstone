@extends('base')

@section('title', 'Caffe Arabica - Menu')

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
                            <h1 class="text-black"
                                style="font-family: 'Manrope', sans-serif; font-weight: 600; font-style: normal; font-size: 24px;">
                                Menu</h1>
                            <p class="text-sm text-gray-600 mt-1">Manage your products here</p>
                        </div>

                        <!-- Center - Search Bar -->
                        <div class="flex-1 flex justify-center">
                            <div class="relative" style="width: 550px;">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" placeholder="Search..."
                                    class="block w-full pl-12 pr-4 border border-gray-300 text-sm transition-all duration-200 focus:outline-none focus:ring-0 focus:border-orange-500 focus:bg-white"
                                    style="height: 45px; border-radius: 50px; background-color: #f5f5f5;" id="searchInput">
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

            <!-- Main Content Section -->
            <main class="flex-1 p-6">
                <div class="bg-white rounded-lg shadow-sm min-h-195">
                    <!-- Content Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <!-- Left side - Products title with icon -->
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded mr-3 flex items-center justify-center">
                                <img src="{{ asset('images/inventoryIcon.svg') }}" alt="Menu Icon" class="w-4 h-4">
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Menu Items</h2>
                        </div>

                        <!-- Right side - Search and buttons -->
                        <div class="flex items-center space-x-4">
                            <!-- Search Input -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" placeholder="Search for ingredient..."
                                    class="pl-10 pr-4 border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                    style="width: 350px; height: 35px; border-radius: 10px; background-color: #f5f5f5;">
                            </div>

                            <!-- Export Button -->
                            <div class="relative">
                                <button
                                    class="flex items-center px-4 py-2 bg-orange-200 text-orange-800 rounded-md hover:bg-orange-300 transition-colors">
                                    <span class="text-sm font-medium">Category</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Add Ingredient Button -->
                            <button onclick="openModal()"
                                class="flex items-center px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors cursor-pointer">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="text-sm font-medium">Add New Product</span>
                            </button>
                        </div>
                    </div>

                    <!-- Empty State Section -->
                    <div class="flex flex-col items-center justify-center py-20 px-6">
                        <!-- Empty State Image -->
                        <div class="mb-8">
                            <img src="{{ asset('images/emptyMenu.svg') }}" alt="No menu items" class="w-80 h-80 object-contain">
                        </div>
                        
                        <!-- Empty State Text -->
                        <div class="text-center mb-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No menu items yet</h3>
                            <p class="text-gray-600 text-sm max-w-md">
                                No tasty treats yet! Let's cook up some products. You can add drinks, food items, and more to showcase your offerings.
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Include the external JavaScript file -->
    <script src="{{ asset('js/inventory.js') }}"></script>
@endsection