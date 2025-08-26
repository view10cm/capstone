@extends('base')

@section('title', 'Caffe Arabica - Users')

@section('content')
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        @include('admin.adminSidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-lg border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center">
                        <!-- Left side - Title -->
                        <div class="flex-1">
                            <h1 class="text-black"
                                style="font-family: 'Manrope', sans-serif; font-weight: 600; font-style: normal; font-size: 24px;">
                                Users</h1>
                            <p class="text-sm text-gray-600 mt-1">Manage user accounts in your system</p>
                        </div>

                        <!-- Center - Search Bar -->
                        <div class="flex-1 flex justify-center">
                            <div class="relative" style="width: 550px;">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" placeholder="Search..."
                                    class="block w-full pl-12 pr-4 border border-gray-300 text-sm transition-all duration-200 focus:outline-none focus:ring-0 focus:border-orange-500 focus:bg-white"
                                    style="height: 45px; border-radius: 50px; background-color: #f5f5f5;" id="searchInput">
                            </div>
                        </div>

                        <!-- Right side - Date and Time -->
                        <div class="flex-1 flex justify-end">
                            <div class="text-right">
                                <div id="currentDate" class="text-sm font-medium text-gray-900"></div>
                                <div id="currentTime" class="text-xs text-gray-600 mt-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6 overflow-auto">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <!-- Content Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <!-- Left side - Products title with icon -->
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded mr-3 flex items-center justify-center">
                                <img src="{{ asset('images/usersIcon.svg') }}" alt="User Icon" class="w-8 h-8">
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">User Accounts</h2>
                        </div>

                        <!-- Right side - Search and buttons -->
                        <div class="flex items-center space-x-4">
                            <!-- Search Input -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" placeholder="Search for user..."
                                    class="pl-10 pr-4 border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                    style="width: 350px; height: 35px; border-radius: 10px; background-color: #f5f5f5;">
                            </div>

                            <!-- Status Button -->
                            <div class="relative">
                                <button
                                    class="flex items-center px-12 py-2 bg-gray-200 text-black-800 rounded-md hover:bg-orange-300 transition-colors">
                                    <!-- Funnel Icon -->
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6.414 6.414A2 2 0 0013 14.586V19a1 1 0 01-1.447.894l-2-1A1 1 0 019 18v-3.414a2 2 0 00-.293-1.293L2.293 6.707A1 1 0 012 6V4z"/>
                                    </svg>
                                    <span class="text-sm font-medium">Status</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Add User Button -->
                            <button onclick="openModalUser()"
                                class="flex items-center px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors cursor-pointer">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="text-sm font-medium">Add New User</span>
                            </button>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Username</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Last Login</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Admin User from DatabaseSeeder -->
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">CaffeArabica Admin</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">caffearabicaexample@gmail.com</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Admin
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ now()->format('Y-m-d H:i') }}
                                    </td>
                                </tr>
                                <!-- Customer User from DatabaseSeeder -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">CaffeArabica Customer</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">customer@caffearabica.com</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Activated
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ now()->format('Y-m-d H:i') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Include the external JavaScript file -->
    <script src="{{ asset('js/users.js') }}"></script>
@endsection