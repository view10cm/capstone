@extends('base')

@section('title', 'Caffe Arabica - Inventory')

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
                                Inventory</h1>
                            <p class="text-sm text-gray-600 mt-1">Manage your inventory items</p>
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
                                <img src="{{ asset('images/inventoryIcon.svg') }}" alt="Products Icon" class="w-4 h-4">
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Ingredients</h2>
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
                                    <span class="text-sm font-medium">Export</span>
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
                                <span class="text-sm font-medium">Add Ingredient</span>
                            </button>
                        </div>
                    </div>

                    <!-- Empty State Content -->
                    <div class="flex flex-col items-center justify-center mt-33 py-16 px-16">
                        <div class="mb-8">
                            <img src="{{ asset('images/emptyInventory.svg') }}" alt="Empty Kitchen Illustration"
                                class="w-80 h-50">
                        </div>
                        <p class="text-gray-600 text-center max-w-md">
                            Looks like your storage room's on a diet - no ingredients in sight! Add an Ingredient.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Ingredient Modal -->
    <div id="addIngredientModal"
        class="fixed inset-0 z-50 hidden bg-transparent bg-opacity-50 backdrop-blur-sm overflow-y-auto flex items-center justify-center">
        <div class="bg-white w-full max-w-3xl rounded-lg shadow-lg">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Add an Ingredient</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
            </div>

            <div class="grid grid-cols-2 gap-6 px-6 py-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" class="w-full border border-gray-300 rounded px-3 py-2 mb-4"
                        placeholder="Enter product name">

                    <label class="block text-sm font-medium mb-1">Quantity (Each) <span
                            class="text-red-500">*</span></label>
                    <input type="number" id="quantityInput" class="w-full border border-gray-300 rounded px-3 py-2"
                        placeholder="Enter quantity" oninput="updateAvailability()">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-sm font-medium">Category <span class="text-red-500">*</span></label>
                        <button onclick="openCategoryModal()" class="text-orange-600 text-sm hover:underline">+ Add
                            Category</button>
                    </div>
                    <select id="categorySelect" class="w-full border border-gray-300 rounded px-3 py-2 mb-4">
                        <option value="">Select a category</option>
                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $category)
                                <option value="{{ $category->categoryID }}">{{ $category->categoryName }}</option>
                            @endforeach
                        @endif
                    </select>

                    <label class="block text-sm font-medium mb-1">Availability</label>
                    <input type="text" id="availabilityInput"
                        class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
                        placeholder="Availability status" disabled>
                </div>
            </div>

            <div class="flex justify-end px-6 py-4 border-t space-x-4">
                <button onclick="closeModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                <button class="px-4 py-2 rounded bg-orange-500 text-white hover:bg-orange-600">+ Add Product</button>
            </div>
        </div>
    </div>

    <!-- Create Ingredient Category Modal -->
    <div id="createCategoryModal"
        class="fixed inset-0 z-60 hidden bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Create Ingredient Category</h3>
                <button onclick="closeCategoryModal()" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
            </div>

            <div class="px-6 py-4">
                <label class="block text-sm font-medium mb-2">Category Name <span class="text-red-500">*</span></label>
                <input type="text" id="categoryNameInput" class="w-full border border-gray-300 rounded px-3 py-2"
                    placeholder="Enter category name">
            </div>

            <div class="flex justify-end px-6 py-4 border-t space-x-4">
                <button onclick="closeCategoryModal()"
                    class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                <button onclick="addCategory()" class="px-4 py-2 rounded bg-orange-500 text-white hover:bg-orange-600">Add
                    Category</button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal"
        class="fixed inset-0 z-70 hidden bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white w-full max-w-sm rounded-lg shadow-lg p-6 text-center">
            <div class="mb-4">
                <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Category Created</h3>
            <p class="text-gray-600">Your category has been successfully created!</p>
        </div>
    </div>

    <!-- Add CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Include the external JavaScript file -->
    <script src="{{ asset('js/inventory.js') }}"></script>
@endsection