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

// Search functionality
document.getElementById("searchInput").addEventListener("keyup", function () {
    const searchText = this.value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach((row) => {
        const username = row
            .querySelector("td:first-child")
            .textContent.toLowerCase();
        const email = row
            .querySelector("td:nth-child(2)")
            .textContent.toLowerCase();

        if (username.includes(searchText) || email.includes(searchText)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

// Modal functions
function openModalUser() {
    document.getElementById("addUserModal").classList.remove("hidden");
    document.getElementById("addUserModal").classList.add("flex");
}

function closeModalUser() {
    document.getElementById("addUserModal").classList.remove("flex");
    document.getElementById("addUserModal").classList.add("hidden");
}

// Close modal when clicking outside
document.getElementById("addUserModal").addEventListener("click", function (e) {
    if (e.target.id === "addUserModal") {
        closeModalUser();
    }
});

// Form submission handling
document.getElementById("addUserForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const password = formData.get("password");
    const passwordConfirmation = formData.get("password_confirmation");

    // Validate passwords match
    if (password !== passwordConfirmation) {
        alert("Passwords do not match!");
        return;
    }

    // Submit the form if validation passes
    this.submit();
});

// User Created Modal functions
function showUserCreatedModal() {
    const modal = document.getElementById("userCreatedModal");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
}

function closeUserCreatedModal() {
    const modal = document.getElementById("userCreatedModal");
    modal.classList.remove("flex");
    modal.classList.add("hidden");
}

// Close modal when clicking outside
if (document.getElementById("userCreatedModal")) {
    document
        .getElementById("userCreatedModal")
        .addEventListener("click", function (e) {
            if (e.target.id === "userCreatedModal") {
                closeUserCreatedModal();
            }
        });
}

// Update the form submission handling to show success modal
document
    .getElementById("addUserForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const password = formData.get("password");
        const passwordConfirmation = formData.get("password_confirmation");

        // Validate passwords match
        if (password !== passwordConfirmation) {
            alert("Passwords do not match!");
            return;
        }

        // Show loading state (optional)
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.textContent = "Creating...";
        submitButton.disabled = true;

        try {
            // Submit the form via AJAX
            const response = await fetch(this.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const data = await response.json();

            if (response.ok) {
                // Close the add user modal
                closeModalUser();

                // Show success modal
                showUserCreatedModal();

                // Wait 3 seconds before closing the modal and refreshing
                setTimeout(() => {
                    closeUserCreatedModal();
                    window.location.reload();
                }, 3000);
            } else {
                // Handle validation errors
                if (data.errors) {
                    let errorMessage = "Please fix the following errors:\n";
                    for (const field in data.errors) {
                        errorMessage += `- ${data.errors[field][0]}\n`;
                    }
                    alert(errorMessage);
                } else {
                    alert(data.message || "Error creating user");
                }
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Network error. Please check your connection and try again.");
        } finally {
            // Restore button state
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    });
