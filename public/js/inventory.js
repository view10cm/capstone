function openModal() {
    document.getElementById("addIngredientModal").classList.remove("hidden");
    // Don't initialize availability on modal open - keep it blank
}

function closeModal() {
    document.getElementById("addIngredientModal").classList.add("hidden");
    // Reset form when closing
    document.getElementById("quantityInput").value = "";
    document.getElementById("availabilityInput").value = "";
}

function openCategoryModal() {
    document.getElementById("createCategoryModal").classList.remove("hidden");
}

function closeCategoryModal() {
    document.getElementById("createCategoryModal").classList.add("hidden");
    // Reset form when closing
    document.getElementById("categoryNameInput").value = "";
}

function showSuccessModal() {
    document.getElementById("successModal").classList.remove("hidden");

    // Auto-hide after 2 seconds
    setTimeout(function () {
        document.getElementById("successModal").classList.add("hidden");
    }, 2000);
}

function addCategory() {
    const categoryNameInput = document.getElementById("categoryNameInput");
    const categoryName = categoryNameInput.value.trim();

    if (categoryName) {
        // Show loading state
        const addButton = document.querySelector(
            '#createCategoryModal button[onclick="addCategory()"]'
        );
        const originalText = addButton.textContent;
        addButton.textContent = "Adding...";
        addButton.disabled = true;

        // Send AJAX request to save category
        fetch("/admin/ingredient-categories", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                categoryName: categoryName,
            }),
        })
            .then((response) => {
                // Check if response is ok
                if (!response.ok) {
                    return response.json().then((err) => Promise.reject(err));
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    // Add to select dropdown
                    const categorySelect = document.getElementById("categorySelect");
                    const newOption = document.createElement("option");
                    newOption.value = data.category.categoryID;
                    newOption.textContent = data.category.categoryName;
                    categorySelect.appendChild(newOption);

                    // Select the newly added category
                    categorySelect.value = data.category.categoryID;

                    // Close the category modal
                    closeCategoryModal();

                    // Show success modal for 2 seconds
                    showSuccessModal();
                } else {
                    alert(data.message || "Error adding category");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                let errorMessage = "Error adding category. Please try again.";

                // Show more specific error message if available
                if (error.message) {
                    errorMessage = error.message;
                } else if (error.errors) {
                    // Handle validation errors
                    const firstError = Object.values(error.errors)[0];
                    if (firstError && firstError[0]) {
                        errorMessage = firstError[0];
                    }
                }

                alert(errorMessage);
            })
            .finally(() => {
                // Reset button state
                addButton.textContent = originalText;
                addButton.disabled = false;
            });
    } else {
        alert("Please enter a category name");
    }
}

function updateAvailability() {
    const quantityInput = document.getElementById("quantityInput");
    const availabilityInput = document.getElementById("availabilityInput");
    const quantity = parseInt(quantityInput.value);

    let availabilityStatus = "";
    let statusColor = "";

    // Only update if there's a valid quantity value
    if (!isNaN(quantity)) {
        if (quantity === 0) {
            availabilityStatus = "No Stock";
            statusColor = "text-red-600";
        } else if (quantity >= 1 && quantity <= 10) {
            availabilityStatus = "Low Stock";
            statusColor = "text-yellow-600";
        } else if (quantity >= 11) {
            availabilityStatus = "In Stock";
            statusColor = "text-green-600";
        }
    }

    availabilityInput.value = availabilityStatus;
    availabilityInput.className = `w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 ${statusColor} font-medium`;
}

// Close modals when clicking outside of them
document.addEventListener("click", function (event) {
    const addIngredientModal = document.getElementById("addIngredientModal");
    const createCategoryModal = document.getElementById("createCategoryModal");
    const successModal = document.getElementById("successModal");

    if (event.target === addIngredientModal) {
        closeModal();
    }

    if (event.target === createCategoryModal) {
        closeCategoryModal();
    }

    if (event.target === successModal) {
        successModal.classList.add("hidden");
    }
});

// Search functionality
document.getElementById("searchInput").addEventListener("input", function (e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

// Real-time clock for Philippine Standard Time
function updateDateTime() {
    const now = new Date();

    // Convert to Philippine Standard Time (UTC+8)
    const philippineTime = new Date(
        now.toLocaleString("en-US", { timeZone: "Asia/Manila" })
    );

    // Format date
    const dateOptions = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        timeZone: "Asia/Manila",
    };
    const formattedDate = philippineTime.toLocaleDateString(
        "en-US",
        dateOptions
    );

    // Format time
    const timeOptions = {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: true,
        timeZone: "Asia/Manila",
    };
    const formattedTime = philippineTime.toLocaleTimeString(
        "en-US",
        timeOptions
    );

    // Update DOM elements
    document.getElementById("currentDate").textContent = formattedDate;
    document.getElementById("currentTime").textContent = formattedTime + " PST";
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    // Update immediately and then every second
    updateDateTime();
    setInterval(updateDateTime, 1000);
});
