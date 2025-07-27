<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/Mug.svg') }}">
    <!-- Other head elements -->
    @vite('resources/css/app.css')
</head>
<body class="bg-[#DBD6D6] min-h-screen">
    @yield('content')
</body>
</html>