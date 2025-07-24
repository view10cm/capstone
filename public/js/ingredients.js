// Get CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Date and time functionality
function updateDateTime() {
    const now = new Date();
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    const dateString = now.toLocaleDateString('en-US', options);
    const timeString = now.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
    
    document.getElementById('currentDate').textContent = dateString;
    document.getElementById('currentTime').textContent = timeString;
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
    const productName = document.querySelector('#addIngredientModal input[placeholder="Enter product name"]').value.trim();
    const quantity = document.getElementById('quantityInput').value;
    const category = document.getElementById('categorySelect').value;
    const availability = document.getElementById('availabilityInput').value;
    
    // Validation
    if (!productName) {
        alert('Please enter a product name');
        return;
    }
    
    if (!quantity || quantity < 0) {
        alert('Please enter a valid quantity');
        return;
    }
    
    if (!category) {
        alert('Please select a category');
        return;
    }
    
    if (!availability) {
        alert('Please ensure availability is set');
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
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the ingredient');
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
    // Add ingredient button click event
    const addProductButton = document.querySelector('#addIngredientModal button[class*="bg-orange-500"]');
    if (addProductButton) {
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