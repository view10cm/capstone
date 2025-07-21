@extends('base')

@section('content')
<div class="flex min-h-screen">
    @include('admin.adminSidebar')
    <div class="flex-1 px-10 py-10">
        <div class="max-w-5xl mx-auto">
            <!-- Inventory Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="m-0 font-semibold text-2xl">Inventory</h2>
                    <span class="text-gray-500">Manage your inventory items</span>
                </div>
                <div class="flex-1 flex justify-center">
                    <div class="relative w-[350px]">
                        <input type="text" placeholder="Search..."
                            class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-200 bg-gray-100 focus:outline-none"
                        >
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <!-- Search Icon -->
                            <svg fill="none" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 20l-5.197-5.197A7.92 7.92 0 0018 10a8 8 0 10-8 8 7.92 7.92 0 004.803-1.803L20 21zM4 10a6 6 0 1112 0 6 6 0 01-12 0z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Products Table Card -->
            <div class="bg-white rounded-2xl shadow-md mt-8 p-8">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2.5">
                        <span class="text-2xl text-orange-400">
                            <svg width="28" height="28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="4" y="7" width="20" height="14" rx="3" stroke="#ff9100"
                                    stroke-width="2" fill="none" />
                                <rect x="8" y="3" width="12" height="4" rx="2" stroke="#ff9100"
                                    stroke-width="2" fill="none" />
                            </svg>
                        </span>
                        <h3 class="m-0 font-semibold text-lg">Products</h3>
                    </div>
                    <div class="flex gap-2.5">
                        <input type="text" placeholder="Search"
                            class="px-3 py-2 rounded-lg border border-gray-200"
                        >
                        <button
                            class="bg-white border border-orange-400 text-orange-400 rounded-lg px-4 py-2 font-medium">Export ▼</button>
                        <button
                            class="bg-orange-400 text-white border-none rounded-lg px-4 py-2 font-medium flex items-center gap-1.5">
                            <span class="text-xl">+</span> Add Product
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-separate border-spacing-y-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-2"><input type="checkbox"></th>
                                <th class="py-2 px-2 text-left">Item ID</th>
                                <th class="py-2 px-2 text-left">Product Name <span class="text-xs text-gray-400">⇅</span></th>
                                <th class="py-2 px-2 text-left">Category <span class="text-xs text-gray-400">⇅</span></th>
                                <th class="py-2 px-2 text-left">Quantity</th>
                                <th class="py-2 px-2 text-left">Availability</th>
                                <th class="py-2 px-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white">
                                <td class="py-2 px-2"><input type="checkbox"></td>
                                <td class="py-2 px-2">CA00001</td>
                                <td class="py-2 px-2">Beef</td>
                                <td class="py-2 px-2">Meat</td>
                                <td class="py-2 px-2">15 kg</td>
                                <td class="py-2 px-2 text-green-600">In Stock</td>
                                <td class="py-2 px-2">
                                    <a href="#"><span class="text-lg">✏️</span></a>
                                    <a href="#"><span class="text-lg ml-2.5">🗑️</span></a>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <td class="py-2 px-2"><input type="checkbox"></td>
                                <td class="py-2 px-2">CA00002</td>
                                <td class="py-2 px-2">Garlic</td>
                                <td class="py-2 px-2">Vegetables</td>
                                <td class="py-2 px-2">5 pcs</td>
                                <td class="py-2 px-2 text-orange-400">Low Stock</td>
                                <td class="py-2 px-2">
                                    <a href="#"><span class="text-lg">✏️</span></a>
                                    <a href="#"><span class="text-lg ml-2.5">🗑️</span></a>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <td class="py-2 px-2"><input type="checkbox"></td>
                                <td class="py-2 px-2">CA00003</td>
                                <td class="py-2 px-2">Onion</td>
                                <td class="py-2 px-2">Vegetables</td>
                                <td class="py-2 px-2">15 pcs</td>
                                <td class="py-2 px-2 text-green-600">In Stock</td>
                                <td class="py-2 px-2">
                                    <a href="#"><span class="text-lg">✏️</span></a>
                                    <a href="#"><span class="text-lg ml-2.5">🗑️</span></a>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <td class="py-2 px-2"><input type="checkbox"></td>
                                <td class="py-2 px-2">CA00004</td>
                                <td class="py-2 px-2">Okra</td>
                                <td class="py-2 px-2">Vegetables</td>
                                <td class="py-2 px-2">0 pcs</td>
                                <td class="py-2 px-2 text-red-600">Out of Stock</td>
                                <td class="py-2 px-2">
                                    <a href="#"><span class="text-lg">✏️</span></a>
                                    <a href="#"><span class="text-lg ml-2.5">🗑️</span></a>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <td class="py-2 px-2"><input type="checkbox"></td>
                                <td class="py-2 px-2">CA00005</td>
                                <td class="py-2 px-2">Oxtail</td>
                                <td class="py-2 px-2">Meat</td>
                                <td class="py-2 px-2">1 kg</td>
                                <td class="py-2 px-2 text-orange-400">Low Stock</td>
                                <td class="py-2 px-2">
                                    <a href="#"><span class="text-lg">✏️</span></a>
                                    <a href="#"><span class="text-lg ml-2.5">🗑️</span></a>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <td class="py-2 px-2"><input type="checkbox"></td>
                                <td class="py-2 px-2">CA00006</td>
                                <td class="py-2 px-2">Eggplant</td>
                                <td class="py-2 px-2">Vegetables</td>
                                <td class="py-2 px-2">5 pcs</td>
                                <td class="py-2 px-2 text-orange-400">Low Stock</td>
                                <td class="py-2 px-2">
                                    <a href="#"><span class="text-lg">✏️</span></a>
                                    <a href="#"><span class="text-lg ml-2.5">🗑️</span></a>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <td class="py-2 px-2"><input type="checkbox"></td>
                                <td class="py-2 px-2">CA00007</td>
                                <td class="py-2 px-2">Espresso Shot</td>
                                <td class="py-2 px-2">Coffee Base</td>
                                <td class="py-2 px-2">30 shots</td>
                                <td class="py-2 px-2 text-green-600">In Stock</td>
                                <td class="py-2 px-2">
                                    <a href="#"><span class="text-lg">✏️</span></a>
                                    <a href="#"><span class="text-lg ml-2.5">🗑️</span></a>
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <td class="py-2 px-2"><input type="checkbox"></td>
                                <td class="py-2 px-2">CA00008</td>
                                <td class="py-2 px-2">Vanilla Syrup</td>
                                <td class="py-2 px-2">Syrup/Flavoring</td>
                                <td class="py-2 px-2">5-10 pumps</td>
                                <td class="py-2 px-2 text-orange-400">Low Stock</td>
                                <td class="py-2 px-2">
                                    <a href="#"><span class="text-lg">✏️</span></a>
                                    <a href="#"><span class="text-lg ml-2.5">🗑️</span></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="flex items-center justify-between mt-6">
                    <button class="bg-white border border-gray-300 rounded-md px-4 py-2">Previous</button>
                    <span class="text-gray-500">Page 1 of <b>10</b></span>
                    <button class="bg-white border border-gray-300 rounded-md px-4 py-2">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
