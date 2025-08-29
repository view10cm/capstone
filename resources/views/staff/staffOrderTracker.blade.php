<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Caffe Arabica - Order Tracker')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/Mug.svg') }}">
    <!-- Other head elements -->
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5] min-h-screen">
    <!-- Navbar -->
    <nav class="bg-[#2B2B2B] text-white px-6 py-4 flex items-center justify-between">
        <!-- Left - Brand Text -->
        <div class="flex items-center space-x-3">
            <!-- Coffee mug icon -->
            <div class="w-8 h-8 bg-orange-500 rounded-sm flex items-center justify-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                    <path
                        d="M2 21h18v-2H2v2zm1.45-5h12.9c.75 0 1.36-.61 1.36-1.36V5c0-.75-.61-1.36-1.36-1.36H3.45C2.7 3.64 2.09 4.25 2.09 5v9.64c0 .75.61 1.36 1.36 1.36zM4 5h11v9H4V5zm16.5 2c-.28 0-.5.22-.5.5v6c0 .28.22.5.5.5s.5-.22.5-.5v-6c0-.28-.22-.5-.5-.5z" />
                </svg>
            </div>

            <!-- Brand text -->
            <div class="flex flex-col">
                <h1 class="text-xl font-bold tracking-wider">CAFFÉ ARABICA</h1>
                <p class="text-xs text-gray-300 tracking-widest uppercase">Kitchen Display System</p>
            </div>
        </div>

        <!-- Middle Left - Employee Info -->
        <div class="flex-1 ml-16">
            @php
                $employee = \App\Models\User::where('role', 'Staff')->first();
            @endphp
            <p class="text-sm text-gray-300">Employee:
                <span class="text-white font-medium">
                    {{ $employee ? $employee->name : 'Staff Member' }}
                </span>
            </p>
        </div>

        <!-- Middle Right - Order Tracker Button -->
        <div class="mr-16">
            <a href="{{ route('staff.staffLandingPage') }}"
                class="bg-orange-500 hover:bg-orange-600 transition-colors duration-200 text-white px-6 py-2 rounded-md font-medium inline-block">
                Order Desk
            </a>
        </div>
        <!-- Right - Date/Time -->
        <div class="text-right">
            <p class="text-sm text-white font-medium" id="current-date"></p>
            <p class="text-sm text-gray-300" id="current-time"></p>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScript for real-time date and time -->
    <script>
        function updateDateTime() {
            const now = new Date();

            // Format date
            const dateOptions = {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('en-US', dateOptions);

            // Format time
            const timeOptions = {
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };
            const formattedTime = now.toLocaleTimeString('en-US', timeOptions);

            // Update elements
            document.getElementById('current-date').textContent = formattedDate;
            document.getElementById('current-time').textContent = formattedTime;
        }

        // Update immediately and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>

</html>
