{{-- filepath: c:\Users\redne\capstone\resources\views\admin\adminSidebar.blade.php --}}
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px; height: 100vh;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <span class="fs-4">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.adminDashboard') }}" class="nav-link active">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.adminInventory') }}" class="nav-link link-dark">
                Inventory
            </a>
        </li>
        <li>
            <a href="{{ route('admin.adminMenu') }}" class="nav-link link-dark">
                Menu
            </a>
        </li>
        <li>
            <a href="{{ route('admin.adminUsers') }}" class="nav-link link-dark">
                Users
            </a>
        </li>
                <li>
            <a href="{{ route('admin.adminOrderHistory') }}" class="nav-link link-dark">
                Order History
            </a>
        </li>
    </ul>
    <hr>
    <div>
        <a href="{{ route('logout') }}" class="btn btn-outline-danger w-100">Logout</a>
    </div>
</div>
