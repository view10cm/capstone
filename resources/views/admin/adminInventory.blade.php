@extends('base')

@section('content')
    <div class="flex min-h-screen">
        @include('admin.adminSidebar')
        <div class="flex-1 px-10 py-10">
            <div class="max-w-10xl mx-auto">
                <!-- Inventory Header -->
                <nav class="flex items-center justify-between bg-white rounded-2xl shadow px-8 py-4">
                    <div class="flex items-center gap-3">
                        <span class="text-orange-400">
                            <!-- Inventory Icon -->
                            <svg width="32" height="32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="5" y="8" width="22" height="16" rx="4" stroke="#ff9100"
                                    stroke-width="2" fill="none" />
                                <rect x="9" y="4" width="14" height="4" rx="2" stroke="#ff9100"
                                    stroke-width="2" fill="none" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="m-0 font-semibold text-2xl">Inventory</h2>
                            <span class="text-gray-500 text-sm">Manage your inventory items</span>
                        </div>
                    </div>
                    <div class="flex-1 flex justify-center">
                        <div class="relative w-[700px]">
                            <input type="text" placeholder="Search..."
                                class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-200 bg-gray-100 focus:outline-none">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <!-- Search Icon -->
                                <svg fill="none" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 20l-5.197-5.197A7.92 7.92 0 0018 10a8 8 0 10-8 8 7.92 7.92 0 004.803-1.803L20 21zM4 10a6 6 0 1112 0 6 6 0 01-12 0z" />
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
                        <div class="relative">
                            <input type="text" placeholder="Search"
                                class="px-3 py-2 rounded-lg border border-gray-200 pl-10">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-orange-400">
                                <!-- inventorySearch.svg -->
                                <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="9" cy="9" r="7" stroke="#ff9100" stroke-width="2" />
                                    <line x1="14.5" y1="14.5" x2="19" y2="19" stroke="#ff9100"
                                        stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </span>
                        </div>
                        <button
                            class="bg-white border border-orange-400 text-orange-400 rounded-lg px-4 py-2 font-medium">Export
                            ▼</button>
                        <button
                            class="bg-orange-400 text-white border-none rounded-lg px-4 py-2 font-medium flex items-center gap-1.5 cursor-pointer"
                            onclick="openAddIngredientModal()">
                            <span class="text-xl">+</span> Add Product
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <!-- Add Ingredient Modal -->
                    <div id="addIngredientModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-transparent bg-opacity-40 backdrop-blur-sm backdrop-blur-[8px] hidden">
                        <div class="bg-white rounded-2xl shadow-lg w-full max-w-2xl p-10 relative flex flex-col"
                            style="min-width: 600px;">
                            <button class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 text-3xl font-bold"
                                onclick="closeAddIngredientModal()">&times;</button>
                            <div class="flex items-center mb-8">
                                <span class="text-orange-400 mr-3">
                                    <svg width="32" height="32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="5" y="8" width="22" height="16" rx="4" stroke="#ff9100"
                                            stroke-width="2" fill="none" />
                                        <rect x="9" y="4" width="14" height="4" rx="2" stroke="#ff9100"
                                            stroke-width="2" fill="none" />
                                    </svg>
                                </span>
                                <h2 class="text-2xl font-bold text-gray-900">Products</h2>
                            </div>
                            <form id="addIngredientForm" onsubmit="return handleAddIngredient(event)">
                                <div class="flex gap-8">
                                    <div class="flex-1">
                                        <label class="block text-gray-700 mb-2 font-medium">Product Name <span
                                                class="text-orange-500">*</span></label>
                                        <input type="text" id="ingredientName" name="ingredientName"
                                            placeholder="Enter product name"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none mb-6"
                                            required>
                                        <label class="block text-gray-700 mb-2 font-medium">Quantity Type <span
                                                class="text-orange-500">*</span></label>
                                        <div class="flex items-center gap-6 mb-6">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="quantityType" value="Each" checked
                                                    class="accent-orange-400 mr-2">
                                                <span>Each</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="quantityType" value="Weight"
                                                    class="accent-orange-400 mr-2">
                                                <span>Weight</span>
                                            </label>
                                        </div>
                                        <label class="block text-gray-700 mb-2 font-medium">Quantity (<span
                                                id="quantityTypeLabel">Each</span>) <span
                                                class="text-orange-500">*</span></label>
                                        <input type="number" id="ingredientQuantity" name="ingredientQuantity"
                                            placeholder="Enter quantity"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none mb-6"
                                            min="0" required oninput="updateAvailability()">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <label class="block text-gray-700 font-medium">Category <span
                                                    class="text-orange-500">*</span></label>
                                            <button type="button"
                                                class="text-orange-400 font-medium flex items-center gap-1"
                                                onclick="addCategory()">
                                                <span>+ Add Category</span>
                                            </button>
                                        </div>
                                        <select id="ingredientCategory" name="ingredientCategory"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none mb-4"
                                            required>
                                            <option value="" disabled selected>Select a category</option>
                                            <option value="Vegetable">Vegetable</option>
                                            <option value="Meat">Meat</option>
                                            <option value="Coffee Base">Coffee Base</option>
                                            <option value="Syrup/Flavoring">Syrup/Flavoring</option>
                                        </select>

                                        <label class="block text-gray-700 mt-22 mb-2 font-medium">Ingredient
                                            Availability</label>
                                        <input type="text" id="ingredientAvailability" name="ingredientAvailability"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100"
                                            readonly>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-8 gap-4">
                                    <button type="button"
                                        class="px-6 py-2 rounded-lg bg-gray-100 text-gray-700 font-semibold border border-gray-300"
                                        onclick="closeAddIngredientModal()">Cancel</button>
                                    <button type="submit"
                                        class="px-6 py-2 rounded-lg bg-orange-400 text-white font-semibold flex items-center gap-2"><span
                                            class="text-xl">+</span> Add Product</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Add Category Modal HTML (add this after your existing Add Ingredient Modal) -->
                    <div id="addCategoryModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm hidden">
                        <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-8 relative">
                            <button class="absolute top-4 right-6 text-gray-400 hover:text-gray-600 text-2xl font-bold"
                                onclick="closeAddCategoryModal()">&times;</button>

                            <h2 class="text-xl font-bold text-gray-900 mb-6">Add New Category</h2>

                            <form id="addCategoryForm" onsubmit="return handleAddCategory(event)">
                                <div class="mb-6">
                                    <label class="block text-gray-700 mb-2 font-medium">Category Name <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" id="categoryName" name="categoryName"
                                        placeholder="Enter category name"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-orange-400"
                                        required>
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="button"
                                        class="px-6 py-2 rounded-lg bg-gray-100 text-gray-700 font-semibold border border-gray-300"
                                        onclick="closeAddCategoryModal()">Cancel</button>
                                    <button type="submit"
                                        class="px-6 py-2 rounded-lg bg-orange-400 text-white font-semibold">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="w-full border-separate border-spacing-y-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-2"><input type="checkbox"></th>
                                <th class="py-2 px-2 text-left">Item ID</th>
                                <th class="py-2 px-2 text-left">Ingredient <span class="text-xs text-gray-400">⇅</span>
                                </th>
                                <th class="py-2 px-2 text-left">Category <span class="text-xs text-gray-400">⇅</span></th>
                                <th class="py-2 px-2 text-left">Quantity</th>
                                <th class="py-2 px-2 text-left">Availability</th>
                                <th class="py-2 px-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <img src="/images/empty_kitchen.svg" alt="No Ingredients"
                                            class="w-40 h-40 mb-4 opacity-80 mx-auto">
                                        <p class="text-lg text-gray-500 font-semibold mt-10">No ingredients found in your
                                            Kitchen. Please add some ingredients to get started.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <script>
                        // Modal quantity type label update
                        document.addEventListener('DOMContentLoaded', function() {
                            const radios = document.getElementsByName('quantityType');
                            const label = document.getElementById('quantityTypeLabel');
                            radios.forEach(radio => {
                                radio.addEventListener('change', function() {
                                    label.textContent = this.value;
                                });
                            });
                        });

                        // Add Category (demo only)
                        function addCategory() {
                            alert('Add Category functionality is a demo. Implement as needed.');
                        }

                        function openAddIngredientModal() {
                            document.getElementById('addIngredientModal').classList.remove('hidden');
                            document.getElementById('ingredientName').value = '';
                            document.getElementById('ingredientCategory').value = '';
                            document.getElementById('ingredientQuantity').value = '';
                            document.getElementById('ingredientAvailability').value = '';
                        }

                        function closeAddIngredientModal() {
                            document.getElementById('addIngredientModal').classList.add('hidden');
                        }

                        function updateAvailability() {
                            const qty = parseInt(document.getElementById('ingredientQuantity').value, 10);
                            let availability = '';
                            if (isNaN(qty) || qty === '') {
                                availability = '';
                            } else if (qty === 0) {
                                availability = 'No Stock';
                            } else if (qty > 0 && qty <= 10) {
                                availability = 'Low Stock';
                            } else if (qty > 10) {
                                availability = 'In Stock';
                            }
                            document.getElementById('ingredientAvailability').value = availability;
                        }

                        function handleAddIngredient(event) {
                            event.preventDefault();
                            // Here you would normally submit the form via AJAX or similar
                            alert('Ingredient added! (Demo only, not saved)');
                            closeAddIngredientModal();
                            return false;
                        }

                        // Updated JavaScript functions
                        function addCategory() {
                            document.getElementById('addCategoryModal').classList.remove('hidden');
                            document.getElementById('categoryName').value = '';
                        }

                        function closeAddCategoryModal() {
                            document.getElementById('addCategoryModal').classList.add('hidden');
                        }

                        function handleAddCategory(event) {
                            event.preventDefault();

                            const categoryName = document.getElementById('categoryName').value.trim();

                            if (!categoryName) {
                                alert('Please enter a category name');
                                return false;
                            }

                            // Send AJAX request to save category
                            fetch('/admin/categories', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        category_name: categoryName
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Add the new category to the dropdown
                                        const categorySelect = document.getElementById('ingredientCategory');
                                        const newOption = document.createElement('option');
                                        newOption.value = data.category.ingredient_category_name;
                                        newOption.textContent = data.category.ingredient_category_name;
                                        categorySelect.appendChild(newOption);

                                        // Select the newly added category
                                        categorySelect.value = data.category.ingredient_category_name;

                                        alert('Category added successfully!');
                                        closeAddCategoryModal();
                                    } else {
                                        alert('Error adding category: ' + (data.message || 'Unknown error'));
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error adding category. Please try again.');
                                });

                            return false;
                        }
                    </script>
                </div>
                <!-- Pagination -->
                <!--<div class="flex items-center justify-between mt-6">
                            <button class="bg-white border border-gray-300 rounded-md px-4 py-2">Previous</button>
                            <span class="text-gray-500">Page 1 of <b>10</b></span>
                            <button class="bg-white border border-gray-300 rounded-md px-4 py-2">Next</button>
                        </div>-->
            </div>
        </div>
    </div>
    </div>
@endsection
