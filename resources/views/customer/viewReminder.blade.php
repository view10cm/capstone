<!-- VIEW REMINDER BLADE VIEW-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Kiosk Reminder</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .reminder-title {
            color: #fff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.7);
        }
        .reminder-desc {
            color: #fff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.7);
        }
    </style>
</head>
<body class="bg-cover bg-center h-screen text-white" style="background-image: url('{{ asset('images/viewReminderBackground.svg') }}');">
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('viewCustomerOrderProper') }}";
        }, 5000);
    </script>
    <div class="flex items-center justify-center h-full bg-black bg-opacity-60 px-4">
        <div class="text-center max-w-2xl">
            <h1 class="reminder-title text-3xl md:text-4xl font-bold mb-6">YOU ARE USING AN AI POWERED KIOSK</h1>
            <p class="reminder-desc text-lg md:text-xl leading-relaxed">
                This kiosk is powered by AI voice technology to make your ordering experience faster and more convenient.
                With voice-assisted features and minimal touch interaction, you can place your order with ease and comfort.
            </p>
        </div>
    </div>
</body>
</html>
