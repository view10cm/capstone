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
    document.getElementById('addUserModal').classList.remove('hidden');
    document.getElementById('addUserModal').classList.add('flex');
}

function closeModalUser() {
    document.getElementById('addUserModal').classList.remove('flex');
    document.getElementById('addUserModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('addUserModal').addEventListener('click', function(e) {
    if (e.target.id === 'addUserModal') {
        closeModalUser();
    }
});

// Form submission handling
document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const password = formData.get('password');
    const passwordConfirmation = formData.get('password_confirmation');
    
    // Validate passwords match
    if (password !== passwordConfirmation) {
        alert('Passwords do not match!');
        return;
    }
    
    // Submit the form if validation passes
    this.submit();
});