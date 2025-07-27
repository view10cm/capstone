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

                    <!-- Products Table -->
                    <div class="overflow-x-auto p-6">
                        @if ($products->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                            Image
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                            Category
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                            Subcategory
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                            Price
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                            Availability
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center">
                                                    @if ($product->productImage)
                                                        <img src="{{ asset('storage/' . $product->productImage) }}"
                                                            alt="{{ $product->productName }}"
                                                            class="h-10 w-10 object-cover" style="border-radius: 10px;">
                                                    @else
                                                        <div class="h-10 w-10 bg-gray-200 flex items-center justify-center"
                                                            style="border-radius: 10px;">
                                                            <svg class="w-5 h-5 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="font-medium text-gray-900"
                                                    style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                                    {{ $product->productName }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="text-gray-900"
                                                    style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                                    {{ $product->category->menuCategoryName ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="text-gray-900"
                                                    style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                                    {{ $product->productSubcategory }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="text-gray-900"
                                                    style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                                    ₱{{ number_format($product->productPrice, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <select
                                                    class="availability-dropdown border border-gray-300 rounded px-2 py-1 text-sm"
                                                    data-product-id="{{ $product->id }}"
                                                    onchange="updateAvailability(this)">
                                                    <option value="Available"
                                                        {{ $product->productAvailability === 'Available' ? 'selected' : '' }}>
                                                        Available</option>
                                                    <option value="Unavailable"
                                                        {{ $product->productAvailability === 'Unavailable' ? 'selected' : '' }}>
                                                        Unavailable</option>
                                                </select>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center font-medium">
                                                <button class="text-orange-600 hover:text-orange-900 mr-4"
                                                    style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                                    Edit
                                                </button>
                                                <button class="text-red-600 hover:text-red-900"
                                                    style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600;">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($products->count() > 0)
                                <div class="px-6 py-4">
                                    {{ $products->links() }}
                                </div>
                            @endif
                        @else
                            <!-- Empty State Section -->
                            <div class="flex flex-col items-center justify-center py-20 px-6">
                                <!-- Empty State Image -->
                                <div class="mb-8">
                                    <img src="{{ asset('images/emptyMenu.svg') }}" alt="No menu items"
                                        class="w-80 h-80 object-contain">
                                </div>

                                <!-- Empty State Text -->
                                <div class="text-center mb-8">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No menu items yet</h3>
                                    <p class="text-gray-600 text-sm max-w-md">
                                        Start building your menu by adding your first product. You can add drinks, food
                                        items, and
                                        more to showcase your offerings.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Create Menu Product Modal -->
    <div id="createMenuModal"
        class="fixed inset-0 bg-transparent bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 opacity-0 invisible transition-all duration-300 ease-in-out">
        <div
            class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 transform scale-95 transition-all duration-300 ease-in-out">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Create Menu Items</h2>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <form id="createMenuForm" class="grid grid-cols-2 gap-6">
                    <!-- Left Column - Product Image -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer"
                                id="imageUploadArea">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-sm text-gray-500 mb-2">Upload your product image here</p>
                                    <button type="button"
                                        class="px-4 py-2 bg-orange-500 text-white text-sm rounded-lg hover:bg-orange-600 transition-colors">
                                        Choose File
                                    </button>
                                </div>
                                <input type="file" id="productImage" class="hidden" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Form Fields -->
                    <div class="space-y-4">
                        <!-- Product Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="productName" placeholder="Enter product name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
                        </div>

                        <!-- Product Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Description</label>
                            <textarea id="productDescription" placeholder="Enter product description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm resize-none"></textarea>
                        </div>

                        <!-- Updated Category Section in the Modal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="productCategory"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm appearance-none bg-white">
                                    <option value="">Select a category</option>
                                    <!-- Categories will be populated dynamically -->
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="#" onclick="openAddCategoryModal()"
                                    class="text-orange-500 text-sm hover:text-orange-600 transition-colors flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Category
                                </a>
                            </div>
                        </div>

                        <!-- Updated Subcategory Section in the Modal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Subcategory <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="productSubcategory"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm appearance-none bg-white"
                                    disabled>
                                    <option value="">Select a subcategory</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="#" onclick="openAddSubcategoryModal()"
                                    class="text-orange-500 text-sm hover:text-orange-600 transition-colors flex items-center"
                                    id="addSubcategoryLink" style="display: none;">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Subcategory
                                </a>
                            </div>
                        </div>

                        <!-- Add Category Modal -->
                        <div id="addCategoryModal"
                            class="fixed inset-0 bg-transparent backdrop-blur-sm bg-opacity-50 flex items-center justify-center z-[60] opacity-0 invisible transition-all duration-300 ease-in-out">
                            <div
                                class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform scale-95 transition-all duration-300 ease-in-out">
                                <!-- Modal Header -->
                                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-semibold text-gray-900">Add New Category</h2>
                                    </div>
                                    <button onclick="closeAddCategoryModal()"
                                        class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Modal Content -->
                                <div class="p-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Category Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="newCategoryName" placeholder="Enter category name"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200">
                                    <button onclick="closeAddCategoryModal()"
                                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                                        Cancel
                                    </button>
                                    <button onclick="createNewCategory()"
                                        class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm font-medium">
                                        Add Category
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Add Subcategory Modal -->
                        <div id="addSubcategoryModal"
                            class="fixed inset-0 bg-transparent backdrop-blur-lg bg-opacity-50 flex items-center justify-center z-[60] opacity-0 invisible transition-all duration-300 ease-in-out">
                            <div
                                class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform scale-95 transition-all duration-300 ease-in-out">
                                <!-- Modal Header -->
                                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-semibold text-gray-900">Add New Subcategory</h2>
                                    </div>
                                    <button onclick="closeAddSubcategoryModal()"
                                        class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Modal Content -->
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Parent
                                                Category</label>
                                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-700"
                                                id="parentCategoryDisplay">
                                                <!-- Will be populated dynamically -->
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Subcategory Name <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="newSubcategoryName"
                                                placeholder="Enter subcategory name"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200">
                                    <button onclick="closeAddSubcategoryModal()"
                                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                                        Cancel
                                    </button>
                                    <button onclick="createNewSubcategory()"
                                        class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm font-medium">
                                        Add Subcategory
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Price <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">₱</span>
                                <input type="number" id="productPrice" placeholder="0.00" step="0.01"
                                    min="0"
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
                            </div>
                        </div>
                        <!-- Availability -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Availability <span class="text-red-500">*</span>
                            </label>
                            <select id="productAvailability"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
                                <option value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200">
                <button onclick="closeModal()"
                    class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                    Cancel
                </button>
                <button onclick="createMenuProduct()"
                    class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Item
                </button>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Include the external JavaScript files -->
    <script src="{{ asset('js/inventory.js') }}"></script>
    <script src="{{ asset('js/menu.js') }}"></script>
@endsection
