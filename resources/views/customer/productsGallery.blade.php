<!-- Double Navbar System -->
<div class="bg-white shadow-sm">
    <!-- Primary Navbar - Categories -->
    <div class="flex justify-center space-x-4 px-4 py-3">
        <button onclick="changeCategory('drinks')" id="drinks-btn"
            class="px-6 py-2 rounded-full font-medium text-gray-800 hover:bg-orange-100 transition-colors active-category">
            Drinks
        </button>
        <button onclick="changeCategory('main-course')" id="main-course-btn"
            class="px-6 py-2 rounded-full font-medium text-gray-800 hover:bg-orange-100 transition-colors">
            Main Course
        </button>
        <button onclick="changeCategory('appetizers')" id="appetizers-btn"
            class="px-6 py-2 rounded-full font-medium text-gray-800 hover:bg-orange-100 transition-colors">
            Appetizers
        </button>
    </div>

    <!-- Secondary Navbar - Subcategories -->
    <div class="flex justify-center space-x-6 px-4 py-3 bg-gray-50 border-t border-gray-200 overflow-x-auto">
        <!-- Drinks Subcategories (default visible) -->
        <div id="drinks-subcategories" class="flex space-x-6">
            <button onclick="changeSubcategory('Hot')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors active-subcategory">
                Hot
            </button>
            <button onclick="changeSubcategory('Iced')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Iced
            </button>
            <button onclick="changeSubcategory('Frappe')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Frappe
            </button>
            <button onclick="changeSubcategory('Milktea')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Milktea
            </button>
            <button onclick="changeSubcategory('Specials')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Specials
            </button>
        </div>

        <!-- Main Course Subcategories (hidden by default) -->
        <div id="main-course-subcategories" class="flex space-x-6 hidden">
            <button onclick="changeSubcategory('Pork')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Pork
            </button>
            <button onclick="changeSubcategory('Chicken')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Chicken
            </button>
            <button onclick="changeSubcategory('Beef')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Beef
            </button>
            <button onclick="changeSubcategory('Fish and Seafood')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Fish & Seafood
            </button>
            <button onclick="changeSubcategory('Pasta')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Pasta
            </button>
            <button onclick="changeSubcategory('Noodles')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Noodles
            </button>
            <button onclick="changeSubcategory('Specials')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Specials
            </button>
        </div>

        <!-- Appetizers Subcategories (hidden by default) -->
        <div id="appetizers-subcategories" class="flex space-x-6 hidden">
            <button onclick="changeSubcategory('Sandwiches')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Sandwiches
            </button>
            <button onclick="changeSubcategory('Knick/Knacks')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Knick/Knacks
            </button>
            <button onclick="changeSubcategory('Salads')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Salads
            </button>
            <button onclick="changeSubcategory('Specials')"
                class="px-3 py-1 font-medium text-gray-700 hover:text-orange-500 transition-colors">
                Specials
            </button>
        </div>
    </div>
</div>

<!-- Products Display Area -->
<div class="pl-12 pr-12 pt-3 relative">
    <div id="products-container" class="grid grid-cols-4 gap-1">
        @foreach ($products->take(8) as $product)
            <div class="bg-white rounded-lg shadow p-2 flex flex-col items-center min-h-[210px]" style="width:calc(100% - 10px);">
                @if ($product->productImage)
                    <img src="{{ asset('storage/' . $product->productImage) }}"
                        alt="{{ $product->productName }}" class="w-full h-28 object-cover rounded mb-2" />
                @else
                    <div class="w-full h-12 bg-gray-200 rounded mb-2"></div>
                @endif
                <h3 class="font-semibold text-base mb-1 text-center">{{ $product->productName }}</h3>
                <p class="text-xs text-gray-600 mb-1 text-center">{{ $product->productDescription }}</p>
                <span class="text-orange-500 font-bold mb-1">₱{{ number_format($product->productPrice, 2) }}</span>
                <div class="flex-grow"></div>
                <button 
                    onclick="addToOrder({{ json_encode($product) }})" 
                    class="w-full bg-orange-200 hover:bg-orange-300 text-orange-900 font-semibold py-1 rounded text-sm"
                >
                    Add Item
                </button>
            </div>
        @endforeach
    </div>
    
    <!-- Left Arrow -->
    <button id="prev-btn" onclick="navigateProducts('prev')" class="absolute left-0 z-10 bg-white rounded-full shadow p-2 flex items-center justify-center hover:bg-orange-100" style="top:50%; transform:translateY(-50%);">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
    </button>
    
    <!-- Right Arrow -->
    <button id="next-btn" onclick="navigateProducts('next')" class="absolute right-0 z-10 bg-white rounded-full shadow p-2 flex items-center justify-center hover:bg-orange-100" style="top:50%; transform:translateY(-50%);">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
    </button>
</div>

<script>
    // Store all products and pagination state
    let allProducts = @json($products);
    let currentPage = 1;
    const productsPerPage = 8;
    let totalPages = Math.ceil(allProducts.length / productsPerPage);
    
    // Track current category and subcategory
    let currentCategory = 'drinks';
    let currentSubcategory = 'Hot';

    // Function to change category
    function changeCategory(category) {
        // Update current category
        currentCategory = category;
        
        // Reset to first page when changing category
        currentPage = 1;
        
        // Update UI for category buttons
        document.querySelectorAll('[id$="-btn"]').forEach(btn => {
            btn.classList.remove('bg-orange-500', 'text-white');
            btn.classList.add('text-gray-800', 'hover:bg-orange-100');
        });
        
        // Highlight the active category button
        document.getElementById(`${category}-btn`).classList.add('bg-orange-500', 'text-white');
        document.getElementById(`${category}-btn`).classList.remove('text-gray-800', 'hover:bg-orange-100');
        
        // Show the appropriate subcategories
        document.querySelectorAll('[id$="-subcategories"]').forEach(subcat => {
            subcat.classList.add('hidden');
        });
        document.getElementById(`${category}-subcategories`).classList.remove('hidden');
        
        // Reset subcategory to the first one in the category
        const firstSubcategory = document.querySelector(`#${category}-subcategories button`);
        if (firstSubcategory) {
            changeSubcategory(firstSubcategory.textContent.trim());
        }
        
        // Update products display
        updateProductsDisplay();
        updateArrowButtons();
    }

    // Function to change subcategory
    function changeSubcategory(subcategory) {
        // Update current subcategory
        currentSubcategory = subcategory;
        
        // Reset to first page when changing subcategory
        currentPage = 1;
        
        // Update UI for subcategory buttons
        document.querySelectorAll(`#${currentCategory}-subcategories button`).forEach(btn => {
            btn.classList.remove('text-orange-500', 'font-bold');
            btn.classList.add('text-gray-700');
        });
        
        // Find and highlight the active subcategory button
        const subcategoryButtons = document.querySelectorAll(`#${currentCategory}-subcategories button`);
        for (let button of subcategoryButtons) {
            if (button.textContent.trim() === subcategory) {
                button.classList.add('text-orange-500', 'font-bold');
                button.classList.remove('text-gray-700');
                break;
            }
        }
        
        // Update products display
        updateProductsDisplay();
        updateArrowButtons();
    }

    // Function to navigate between product pages
    function navigateProducts(direction) {
        // Get filtered products for current category and subcategory
        const filteredProducts = filterProductsBySubcategory();
        const filteredTotalPages = Math.ceil(filteredProducts.length / productsPerPage);
        
        if (direction === 'next' && currentPage < filteredTotalPages) {
            currentPage++;
        } else if (direction === 'prev' && currentPage > 1) {
            currentPage--;
        } else {
            return; // Do nothing if at the first or last page
        }
        
        updateProductsDisplay();
        updateArrowButtons();
    }

    // Function to filter products by current subcategory
    function filterProductsBySubcategory() {
        return allProducts.filter(product => 
            product.productSubcategory === currentSubcategory
        );
    }

    // Function to update the products display
    function updateProductsDisplay() {
        // Filter products by current subcategory
        const filteredProducts = filterProductsBySubcategory();
        
        // Update total pages based on filtered products
        totalPages = Math.ceil(filteredProducts.length / productsPerPage);
        
        const startIndex = (currentPage - 1) * productsPerPage;
        const endIndex = startIndex + productsPerPage;
        const currentProducts = filteredProducts.slice(startIndex, endIndex);
        
        const productsContainer = document.getElementById('products-container');
        productsContainer.innerHTML = '';
        
        if (currentProducts.length === 0) {
            // Display message when no products are found
            productsContainer.innerHTML = `
                <div class="col-span-4 text-center py-10">
                    <p class="text-gray-500 text-lg">No products in this category</p>
                </div>
            `;
            return;
        }
        
        currentProducts.forEach(product => {
            const productElement = document.createElement('div');
            productElement.className = 'bg-white rounded-lg shadow p-2 flex flex-col items-center min-h-[210px]';
            productElement.style.width = 'calc(100% - 10px)';
            
            productElement.innerHTML = `
                ${product.productImage ? 
                    `<img src="/storage/${product.productImage}" alt="${product.productName}" class="w-full h-28 object-cover rounded mb-2" />` : 
                    `<div class="w-full h-12 bg-gray-200 rounded mb-2"></div>`
                }
                <h3 class="font-semibold text-base mb-1 text-center">${product.productName}</h3>
                <p class="text-xs text-gray-600 mb-1 text-center">${product.productDescription}</p>
                <span class="text-orange-500 font-bold mb-1">₱${parseFloat(product.productPrice).toFixed(2)}</span>
                <div class="flex-grow"></div>
                <button 
                    onclick="addToOrder(${JSON.stringify(product).replace(/"/g, '&quot;')})" 
                    class="w-full bg-orange-200 hover:bg-orange-300 text-orange-900 font-semibold py-1 rounded text-sm"
                >
                    Add Item
                </button>
            `;
            
            productsContainer.appendChild(productElement);
        });
    }

    // Function to update arrow button states
    function updateArrowButtons() {
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        
        // Get filtered products for current category and subcategory
        const filteredProducts = filterProductsBySubcategory();
        const filteredTotalPages = Math.ceil(filteredProducts.length / productsPerPage);
        
        // Disable prev button on first page
        if (currentPage === 1 || filteredProducts.length === 0) {
            prevBtn.classList.add('opacity-50', 'cursor-not-allowed');
            prevBtn.disabled = true;
        } else {
            prevBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            prevBtn.disabled = false;
        }
        
        // Disable next button on last page
        if (currentPage === filteredTotalPages || filteredProducts.length === 0) {
            nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
            nextBtn.disabled = true;
        } else {
            nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            nextBtn.disabled = false;
        }
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial active category
        changeCategory('drinks');
        
        // Initialize arrow button states
        updateArrowButtons();
    });
</script>