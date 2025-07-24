{{-- filepath: c:\Users\redne\capstone\resources\views\admin\adminSidebar.blade.php --}}
<div class="flex flex-col h-screen bg-white px-6 py-8" style="width: 310px;">
    <!-- Logo Section -->
    <div class="flex flex-col items-center mb-10">
        <img src="{{ asset('images/caffeArabicaSidebarLogo.svg') }}" alt="Caffé Arabica Logo" class="w-50 h-22 mb-2 mr-2">
    </div>
    <!-- Navigation -->
    <nav class="flex-1">
        <ul class="space-y-4">
            <li>
                <a href="{{ route('admin.adminDashboard') }}" class="flex items-center text-black hover:text-orange-600 font-medium transition-colors">
                    <!-- Dashboard Icon -->
                    <img src="{{ asset('images/sidebarDashboard.svg') }}" alt="Dashboard Icon" class="h-6 w-6 mr-3">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.adminInventory') }}" class="flex items-center text-black hover:text-orange-600 font-medium transition-colors">
                    <!-- Inventory Icon -->
                    <img src="{{ asset('images/sidebarInventory.svg') }}" alt="Dashboard Icon" class="h-5 w-5 mr-3">
                    Inventory
                </a>
            </li>
            <li>
                <a href="{{ route('admin.adminMenu') }}" class="flex items-center text-black hover:text-orange-600 font-medium transition-colors">
                    <!-- Menu Icon -->
                    <img src="{{ asset('images/sidebarMenu.svg') }}" alt="Dashboard Icon" class="h-6 w-6 mr-3">
                    Menu
                </a>
            </li>
            <li>
                <a href="{{ route('admin.adminUsers') }}" class="flex items-center text-black hover:text-orange-600 font-medium transition-colors">
                    <!-- Users Icon -->
                    <img src="{{ asset('images/sidebarUsers.svg') }}" alt="Dashboard Icon" class="h-6 w-6 mr-3">
                    Users
                </a>
            </li>
            <li>
                <a href="{{ route('admin.adminOrderHistory') }}" class="flex items-center text-black hover:text-orange-600 font-medium transition-colors">
                    <!-- Order History Icon -->
                    <img src="{{ asset('images/sidebarOrderHistory.svg') }}" alt="Dashboard Icon" class="h-6 w-6 mr-3">
                    Order History
                </a>
            </li>
        </ul>
    </nav>
    <!-- Logout -->
    <div class="mt-auto">
        <a href="{{ route('logout') }}" class="flex items-center text-black hover:text-orange-600 font-medium transition-colors">
            <!-- Logout Icon -->
            <img src="{{ asset('images/sidebarLogout.svg') }}" alt="Dashboard Icon" class="h-6 w-6 mr-3">
            Log Out
        </a>
    </div>
</div>