<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Caffe Arabica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="relative min-h-screen bg-cover bg-center flex items-center justify-center"
    style="background-image: url('{{ asset('images/viewWelcomeBladeBackground.svg') }}');">

    <!-- ✅ Orange color overlay (acts like a filter/tint) -->
    <div class="absolute inset-0 bg-[#E67809] opacity-20 z-0 pointer-events-none"></div>

    <!-- Main content stays above the overlay -->
    <div class="relative z-10 text-center text-white px-4">
        <p class="italic mb-4 -mt-6" style="font-family: 'Times New Roman', serif; font-size: 24px;">
            "A cup of coffee a day without God is tasteless!"
        </p>
        <h1 class="text-[48px] md:text-5xl font-bold mb-2 font-bold" style="font-family: 'Cinzel', serif;">
            WELCOME TO CAFFE ARABICA
        </h1>

        <h2 class="text-lg md:text-xl tracking-wider uppercase" style="font-family: 'Times New Roman', serif;">
            A Premium Dining Experience
        </h2>
    </div>

    <!-- 📍 Full-width 'Touch to start' at bottom -->
    <a href="{{ route('customer.viewReminder') }}">
        <div
            class="absolute bottom-0 left-0 w-full bg-black bg-opacity-80 py-6 px-4 text-white text-center z-10 cursor-pointer">
            <p class="text-2xl font-semibold mb-2">Touch to start</p>
            <p class="text-sm">Ready to order? Tap to begin.</p>
        </div>
    </a>

</body>

</html>
