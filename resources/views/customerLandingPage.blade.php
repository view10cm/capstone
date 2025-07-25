<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Caffe Arabica</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <style>
        .welcome-bg {
            background: url('{{ asset('/images/Login.svg') }}') center center / cover no-repeat;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="welcome-bg min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-[12px] shadow-md w-[400px]">
            <h2 class="mb-6 text-center font-bold" style="font-family: 'Cinzel', serif; font-size: 32px;">Welcome Back!</h2>
            
            <div class="text-center mb-6">
                <p class="text-gray-700">You're logged in as a customer.</p>
                <p class="text-gray-700 mt-2">Enjoy your Caffe Arabica experience!</p>
            </div>
            
            <div class="flex justify-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>