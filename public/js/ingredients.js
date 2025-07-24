// Get CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Date and time functionality
function updateDateTime() {
    const now = new Date();
    const dateOptions = { 
        weekday: 'long',
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    const timeOptions = { 
        hour: '2-digit', 
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    };
    
    const dateString = now.toLocaleDateString('en-US', dateOptions);
    const timeString = now.toLocaleTimeString('en-US', timeOptions);
    
    const currentDateEl = document.getElementById('currentDate');
    const currentTimeEl = document.getElementById('currentTime');
    
    if (currentDateEl) {
        currentDateEl.textContent = dateString;
    }
    
    if (currentTimeEl) {
        currentTimeEl.textContent = timeString;
    }
}

// Update date and time every second
setInterval(updateDateTime, 1000);
updateDateTime(); // Initial call

// Modal functions
function openModal() {
    document.getElementById('addIngredientModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('addIngredientModal').classList.add('hidden');
    // Reset form
    document.querySelector('#addIngredientModal input[placeholder="Enter product name"]').value = '';
    document.getElementById('quantityInput').value = '';
    document.getElementById('categorySelect').value = '';
    document.getElementById('availabilityInput').value = '';
}

function openCategoryModal() {
    document.getElementById('createCategoryModal').classList.remove('hidden');
}

function closeCategoryModal() {
    document.getElementById('createCategoryModal').classList.add('hidden');
    // Reset form
    document.getElementById('categoryNameInput').value = '';
}

// Update availability based on quantity
function updateAvailability() {
    const quantity = parseInt(document.getElementById('quantityInput').value) || 0;
    const availabilityInput = document.getElementById('availabilityInput');
    
    if (quantity > 10) {
        availabilityInput.value = 'In Stock';
    } else if (quantity > 0) {
        availabilityInput.value = 'Low Stock';
    } else {
        availabilityInput.value = 'Out of Stock';
    }
}

// Add new category
function addCategory() {
    const categoryName = document.getElementById('categoryNameInput').value.trim();
    
    if (!categoryName) {
        alert('Please enter a category name');
        return;
    }
    
    fetch('/admin/ingredients/categories', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            category_name: categoryName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add new category to dropdown
            const categorySelect = document.getElementById('categorySelect');
            const option = document.createElement('option');
            option.value = data.category.id;
            option.textContent = data.category.categoryName;
            categorySelect.appendChild(option);
            
            // Close category modal
            closeCategoryModal();
            
            // Show success modal
            showSuccessModal('Category Created', 'Your category has been successfully created!');
        } else {
            alert(data.message || 'Error creating category');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while creating the category');
    });
}

// Add new ingredient
function addIngredient() {
    // Prevent multiple submissions
    const button = event.target;
    if (button.disabled) return;
    button.disabled = true;
    button.textContent = 'Adding...';
    
    const productName = document.querySelector('#addIngredientModal input[placeholder="Enter product name"]').value.trim();
    const quantity = document.getElementById('quantityInput').value;
    const category = document.getElementById('categorySelect').value;
    const availability = document.getElementById('availabilityInput').value;
    
    // Reset button function
    const resetButton = () => {
        button.disabled = false;
        button.textContent = '+ Add Product';
    };
    
    // Validation
    if (!productName) {
        alert('Please enter a product name');
        resetButton();
        return;
    }
    
    if (!quantity || quantity < 0) {
        alert('Please enter a valid quantity');
        resetButton();
        return;
    }
    
    if (!category) {
        alert('Please select a category');
        resetButton();
        return;
    }
    
    if (!availability) {
        alert('Please ensure availability is set');
        resetButton();
        return;
    }
    
    fetch('/admin/ingredients', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            product_name: productName,
            category: category,
            quantity: parseInt(quantity),
            availability: availability
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close add ingredient modal
            closeModal();
            
            // Show success modal
            showSuccessModal('Ingredient Added to the Kitchen', 'Your ingredient has been successfully added!');
            
            // Redirect after 2 seconds
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            alert(data.message || 'Error adding ingredient');
            resetButton();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the ingredient');
        resetButton();
    });
}

// Show success modal
function showSuccessModal(title, message) {
    const modal = document.getElementById('successModal');
    const titleElement = modal.querySelector('h3');
    const messageElement = modal.querySelector('p');
    
    titleElement.textContent = title;
    messageElement.textContent = message;
    
    modal.classList.remove('hidden');
    
    // Auto close after 2 seconds
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 2000);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Remove any existing event listeners first
    const addProductButton = document.querySelector('#addIngredientModal button[onclick="addIngredient()"]');
    if (addProductButton) {
        // Remove onclick attribute to prevent double execution
        addProductButton.removeAttribute('onclick');
        addProductButton.addEventListener('click', addIngredient);
    }
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            // Add search functionality here if needed
            console.log('Searching for:', this.value);
        });
    }
});