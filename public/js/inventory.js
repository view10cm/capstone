// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Real-time clock for Philippine Standard Time
function updateDateTime() {
    const now = new Date();
    
    // Convert to Philippine Standard Time (UTC+8)
    const philippineTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Manila"}));
    
    // Format date
    const dateOptions = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        timeZone: 'Asia/Manila'
    };
    const formattedDate = philippineTime.toLocaleDateString('en-US', dateOptions);
    
    // Format time
    const timeOptions = { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit',
        hour12: true,
        timeZone: 'Asia/Manila'
    };
    const formattedTime = philippineTime.toLocaleTimeString('en-US', timeOptions);
    
    // Update DOM elements
    document.getElementById('currentDate').textContent = formattedDate;
    document.getElementById('currentTime').textContent = formattedTime + ' PST';
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Update immediately and then every second
    updateDateTime();
    setInterval(updateDateTime, 1000);
});