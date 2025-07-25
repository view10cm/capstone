// Menu Management JavaScript - Database Integration Version

// Categories and subcategories storage
let categories = [];
let subcategories = {};

// DOM Elements
let modal, modalContent, categorySelect, subcategorySelect, imageUploadArea, imageInput;
let addCategoryModal, addSubcategoryModal, addSubcategoryLink;

// CSRF Token for Laravel
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                  document.querySelector('input[name="_token"]')?.value || '';

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if CSRF token exists
    if (!csrfToken) {
        console.error('CSRF token not found. Make sure to add <meta name="csrf-token" content="{{ csrf_token() }}"> to your HTML head.');
        showNotification('CSRF token not found. Please refresh the page.', 'error');
        return;
    }

    // Get DOM elements
    modal = document.getElementById('createMenuModal');
    modalContent = modal?.querySelector('.bg-white');
    categorySelect = document.getElementById('productCategory');
    subcategorySelect = document.getElementById('productSubcategory');
    imageUploadArea = document.getElementById('imageUploadArea');
    imageInput = document.getElementById('productImage');
    addCategoryModal = document.getElementById('addCategoryModal');
    addSubcategoryModal = document.getElementById('addSubcategoryModal');
    addSubcategoryLink = document.getElementById('addSubcategoryLink');

    // Load categories from database
    loadCategoriesFromDatabase();
    
    // Set up event listeners
    setupEventListeners();
});

// Load categories from database
async function loadCategoriesFromDatabase() {
    try {
        console.log('Loading categories from database...');
        const response = await fetch('/admin/categories', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Categories data:', data);

        if (data.success) {
            categories = data.categories;
            
            // Initialize subcategories (you'll need to create similar API for subcategories)
            initializeSubcategories();
            
            // Populate the category dropdown
            populateCategories();
        } else {
            console.error('Failed to load categories:', data.message);
            showNotification(data.message || 'Failed to load categories', 'error');
        }
    } catch (error) {
        console.error('Error loading categories:', error);
        showNotification(`Error loading categories: ${error.message}`, 'error');
    }
}

// Create new category - Database version
async function createNewCategory() {
    const name = document.getElementById('newCategoryName').value.trim();

    if (!name) {
        showNotification('Category name is required', 'error');
        return;
    }

    // Show loading state
    const submitButton = document.querySelector('button[onclick="createNewCategory()"]');
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Creating...
    `;
    submitButton.disabled = true;

    try {
        console.log('Creating category:', name);
        console.log('CSRF Token:', csrfToken);
        
        const response = await fetch('/admin/categories', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                menuCategoryName: name
            })
        });

        console.log('Create response status:', response.status);
        
        // Log the raw response text for debugging
        const responseText = await response.text();
        console.log('Raw response:', responseText);
        
        let data;
        try {
            data = JSON.parse(responseText);
        } catch (parseError) {
            console.error('Failed to parse JSON response:', parseError);
            throw new Error('Invalid JSON response from server');
        }

        console.log('Parsed response data:', data);

        if (data.success) {
            // Add the new category to the local array
            categories.push(data.category);
            
            // Initialize empty subcategories array for the new category
            subcategories[data.category.id] = [];

            // Update category dropdown
            populateCategories();

            // Select the new category
            categorySelect.value = data.category.id;
            handleCategoryChange();

            showNotification('Category added successfully!', 'success');
            closeAddCategoryModal();
        } else {
            showNotification(data.message || 'Error creating category', 'error');
        }
    } catch (error) {
        console.error('Error creating category:', error);
        showNotification(`Error creating category: ${error.message}`, 'error');
    } finally {
        // Reset button
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    }
}

// Initialize subcategories (temporary - replace with database call)
function initializeSubcategories() {
    subcategories = {
        1: [ // Beverages ID
            { id: 'hot_coffee', name: 'Hot Coffee' },
            { id: 'iced_coffee', name: 'Iced Coffee' },
            { id: 'espresso', name: 'Espresso' },
            { id: 'tea', name: 'Tea' },
            { id: 'cold_brew', name: 'Cold Brew' },
            { id: 'smoothies', name: 'Smoothies' },
            { id: 'juices', name: 'Juices' },
            { id: 'soft_drinks', name: 'Soft Drinks' }
        ],
        2: [ // Food ID
            { id: 'breakfast', name: 'Breakfast' },
            { id: 'sandwiches', name: 'Sandwiches' },
            { id: 'salads', name: 'Salads' },
            { id: 'pasta', name: 'Pasta' },
            { id: 'rice_meals', name: 'Rice Meals' },
            { id: 'appetizers', name: 'Appetizers' },
            { id: 'main_course', name: 'Main Course' }
        ],
        3: [ // Desserts ID
            { id: 'ice_cream', name: 'Ice Cream' },
            { id: 'cakes', name: 'Cakes' },
            { id: 'cookies', name: 'Cookies' },
            { id: 'puddings', name: 'Puddings' },
            { id: 'frozen_desserts', name: 'Frozen Desserts' },
            { id: 'seasonal_specials', name: 'Seasonal Specials' }
        ],
        4: [ // Pastries ID
            { id: 'croissants', name: 'Croissants' },
            { id: 'muffins', name: 'Muffins' },
            { id: 'danish', name: 'Danish' },
            { id: 'bread', name: 'Bread' },
            { id: 'scones', name: 'Scones' },
            { id: 'tarts', name: 'Tarts' },
            { id: 'pies', name: 'Pies' }
        ]
    };
}

// Populate categories in select dropdown
function populateCategories() {
    if (!categorySelect) return;
    
    // Clear existing options except the first one
    categorySelect.innerHTML = '<option value="">Select a category</option>';
    
    // Add categories from database
    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category.id;
        option.textContent = category.name;
        categorySelect.appendChild(option);
    });
}

// Set up all event listeners
function setupEventListeners() {
    // Category change listener
    if (categorySelect) {
        categorySelect.addEventListener('change', handleCategoryChange);
    }

    // Image upload listeners
    if (imageUploadArea && imageInput) {
        imageUploadArea.addEventListener('click', () => imageInput.click());
        imageInput.addEventListener('change', handleImageUpload);
        
        // Drag and drop functionality
        imageUploadArea.addEventListener('dragover', handleDragOver);
        imageUploadArea.addEventListener('drop', handleImageDrop);
        imageUploadArea.addEventListener('dragleave', handleDragLeave);
    }

    // Close modals when clicking outside
    [modal, addCategoryModal, addSubcategoryModal].forEach(modalEl => {
        if (modalEl) {
            modalEl.addEventListener('click', function(e) {
                if (e.target === modalEl) {
                    if (modalEl === modal) closeModal();
                    else if (modalEl === addCategoryModal) closeAddCategoryModal();
                    else if (modalEl === addSubcategoryModal) closeAddSubcategoryModal();
                }
            });
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (addSubcategoryModal && !addSubcategoryModal.classList.contains('invisible')) {
                closeAddSubcategoryModal();
            } else if (addCategoryModal && !addCategoryModal.classList.contains('invisible')) {
                closeAddCategoryModal();
            } else if (modal && !modal.classList.contains('invisible')) {
                closeModal();
            }
        }
    });
}

// Open modal function
function openModal() {
    if (modal) {
        resetForm();
        showModal(modal, modalContent);
        document.body.style.overflow = 'hidden';
    }
}

// Close modal function
function closeModal() {
    if (modal) {
        hideModal(modal, modalContent, resetForm);
        document.body.style.overflow = '';
    }
}

// Open add category modal
function openAddCategoryModal() {
    if (addCategoryModal) {
        document.getElementById('newCategoryName').value = '';
        showModal(addCategoryModal, addCategoryModal.querySelector('.bg-white'));
    }
}

// Close add category modal
function closeAddCategoryModal() {
    if (addCategoryModal) {
        hideModal(addCategoryModal, addCategoryModal.querySelector('.bg-white'));
    }
}

// Open add subcategory modal
function openAddSubcategoryModal() {
    const selectedCategory = categorySelect.value;
    if (!selectedCategory) {
        showNotification('Please select a category first', 'error');
        return;
    }

    if (addSubcategoryModal) {
        const selectedCategoryName = categories.find(cat => cat.id == selectedCategory)?.name || '';
        document.getElementById('parentCategoryDisplay').textContent = selectedCategoryName;
        document.getElementById('newSubcategoryName').value = '';
        showModal(addSubcategoryModal, addSubcategoryModal.querySelector('.bg-white'));
    }
}

// Close add subcategory modal
function closeAddSubcategoryModal() {
    if (addSubcategoryModal) {
        hideModal(addSubcategoryModal, addSubcategoryModal.querySelector('.bg-white'));
    }
}

// Generic show modal function
function showModal(modalEl, contentEl) {
    modalEl.classList.remove('invisible', 'opacity-0');
    contentEl.classList.remove('scale-95');
    
    setTimeout(() => {
        modalEl.classList.add('opacity-100');
        contentEl.classList.add('scale-100');
    }, 10);
}

// Generic hide modal function
function hideModal(modalEl, contentEl, callback) {
    modalEl.classList.remove('opacity-100');
    contentEl.classList.remove('scale-100');
    modalEl.classList.add('opacity-0');
    contentEl.classList.add('scale-95');
    
    setTimeout(() => {
        modalEl.classList.add('invisible');
        if (callback) callback();
    }, 300);
}

// Create new subcategory (you'll need to implement database version)
function createNewSubcategory() {
    const selectedCategory = categorySelect.value;
    const name = document.getElementById('newSubcategoryName').value.trim();

    if (!selectedCategory) {
        showNotification('No category selected', 'error');
        return;
    }

    if (!name) {
        showNotification('Subcategory name is required', 'error');
        return;
    }

    // Check if subcategory already exists in this category
    if (subcategories[selectedCategory] && 
        subcategories[selectedCategory].some(sub => sub.name.toLowerCase() === name.toLowerCase())) {
        showNotification('Subcategory already exists in this category', 'error');
        return;
    }

    // Create new subcategory (temporary - replace with database call)
    const newSubcategory = {
        id: name.toLowerCase().replace(/\s+/g, '_'),
        name: name
    };

    if (!subcategories[selectedCategory]) {
        subcategories[selectedCategory] = [];
    }

    subcategories[selectedCategory].push(newSubcategory);

    // Update subcategory dropdown
    handleCategoryChange();

    // Select the new subcategory
    subcategorySelect.value = newSubcategory.id;

    showNotification('Subcategory added successfully!', 'success');
    closeAddSubcategoryModal();
}

// Handle category change
function handleCategoryChange() {
    const selectedCategory = categorySelect.value;
    const subcategoryOptions = subcategories[selectedCategory] || [];
    
    // Clear subcategory options
    subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
    
    if (subcategoryOptions.length > 0) {
        // Add existing subcategories
        subcategoryOptions.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option.id;
            optionElement.textContent = option.name;
            subcategorySelect.appendChild(optionElement);
        });
        
        // Enable subcategory select
        subcategorySelect.disabled = false;
        subcategorySelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
        subcategorySelect.classList.add('bg-white');
    } else {
        // Disable subcategory select
        subcategorySelect.disabled = true;
        subcategorySelect.classList.add('bg-gray-100', 'cursor-not-allowed');
        subcategorySelect.classList.remove('bg-white');
    }

    // Show/hide add subcategory link
    if (selectedCategory && addSubcategoryLink) {
        addSubcategoryLink.style.display = 'flex';
    } else if (addSubcategoryLink) {
        addSubcategoryLink.style.display = 'none';
    }
}

// Handle image upload
function handleImageUpload(e) {
    const file = e.target.files[0];
    if (file) {
        displayImagePreview(file);
    }
}

// Handle drag over
function handleDragOver(e) {
    e.preventDefault();
    imageUploadArea.classList.add('border-orange-500', 'bg-orange-50');
}

// Handle drag leave
function handleDragLeave(e) {
    e.preventDefault();
    imageUploadArea.classList.remove('border-orange-500', 'bg-orange-50');
}

// Handle image drop
function handleImageDrop(e) {
    e.preventDefault();
    imageUploadArea.classList.remove('border-orange-500', 'bg-orange-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
            imageInput.files = files;
            displayImagePreview(file);
        }
    }
}

// Display image preview
function displayImagePreview(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        imageUploadArea.innerHTML = `
            <div class="relative">
                <img src="${e.target.result}" alt="Preview" class="w-full h-40 object-cover rounded-lg">
                <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="mt-2 text-center">
                    <p class="text-sm text-gray-600">${file.name}</p>
                    <button type="button" onclick="changeImage()" class="text-orange-500 text-sm hover:text-orange-600 transition-colors">
                        Change Image
                    </button>
                </div>
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

// Remove image
function removeImage() {
    imageInput.value = '';
    resetImageUploadArea();
}

// Change image
function changeImage() {
    imageInput.click();
}

// Reset image upload area
function resetImageUploadArea() {
    imageUploadArea.innerHTML = `
        <div class="flex flex-col items-center">
            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-sm text-gray-500 mb-2">Upload your product image here</p>
            <button type="button" class="px-4 py-2 bg-orange-500 text-white text-sm rounded-lg hover:bg-orange-600 transition-colors">
                Choose File
            </button>
        </div>
    `;
}

// Create menu product - Database version
async function createMenuProduct() {
    const formData = new FormData();
    formData.append('name', document.getElementById('productName').value.trim());
    formData.append('description', document.getElementById('productDescription').value.trim());
    formData.append('category', categorySelect.value);
    formData.append('subcategory', subcategorySelect.value);
    formData.append('price', document.getElementById('productPrice').value);
    
    // Append the image file if it exists
    if (imageInput.files[0]) {
        formData.append('image', imageInput.files[0]);
    }

    // Validate required fields
    if (!formData.get('name') || !formData.get('category') || 
        !formData.get('subcategory') || !formData.get('price') || 
        parseFloat(formData.get('price')) <= 0) {
        showNotification('Please fill all required fields with valid values', 'error');
        return;
    }

    // Show loading state
    const submitButton = document.querySelector('button[onclick="createMenuProduct()"]');
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Creating...
    `;
    submitButton.disabled = true;

    try {
        const response = await fetch('/admin/products', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Failed to create product');
        }

        if (data.success) {
            showNotification('Product created successfully!', 'success');
            closeModal();
            // Optionally refresh the product list or redirect
        } else {
            showNotification(data.message || 'Error creating product', 'error');
        }
    } catch (error) {
        console.error('Error creating product:', error);
        showNotification(`Error creating product: ${error.message}`, 'error');
    } finally {
        // Reset button
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    }
}

// Validate form
function validateForm(data) {
    const errors = [];

    if (!data.name) errors.push('Product name is required');
    if (!data.category) errors.push('Category is required');
    if (!data.subcategory) errors.push('Subcategory is required');
    if (!data.price || parseFloat(data.price) <= 0) errors.push('Valid price is required');

    if (errors.length > 0) {
        showNotification(errors.join('\n'), 'error');
        return false;
    }

    return true;
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-[70] p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-2">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Reset form
function resetForm() {
    document.getElementById('createMenuForm').reset();
    subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
    subcategorySelect.disabled = true;
    subcategorySelect.classList.add('bg-gray-100', 'cursor-not-allowed');
    subcategorySelect.classList.remove('bg-white');
    
    // Hide add subcategory link
    if (addSubcategoryLink) {
        addSubcategoryLink.style.display = 'none';
    }
    
    resetImageUploadArea();
}