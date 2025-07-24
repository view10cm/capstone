
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <head>
    <title>@yield('title', 'Default Title')</title>
    <!-- Other head elements -->
</head>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#DBD6D6] min-h-screen">
    @yield('content')
</body>
</html>

