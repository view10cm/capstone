{{-- filepath: c:\Users\redne\capstone\resources\views\systemDescription.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Caffe Arabica</title>
    @vite('resources/css/app.css') {{-- Ensure Tailwind is included --}}
</head>
<body class="bg-amber-50 min-h-screen flex items-center justify-center relative"
      style="background: url('{{ asset('/images/WELCOME (1).svg') }}') center center / cover no-repeat;">

    <h1 class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white font-bold text-[48px] responsive-font" style="font-family: 'Cinzel', serif;">
        YOU ARE USING AN AI POWERED KIOSK
    </h1>
    <span class="absolute left-1/2 top-[45%] -translate-x-1/2 text-white text-[24px] font-normal responsive-font text-center w-full px-4" style="font-family:'Times New Roman', Times, serif; letter-spacing: 0.1em;">
        This Kiosk is powered by AI Voice Technology to make your <br>
        ordering experience faster and more convenient. With voice<br>
        assisted features and minimal touch interaction, you can place <br>
        your order with ease and comfort.
    </span>

    <script>
        // Redirect to login after 7 seconds or on any click/tap
        function goToLogin() {
            window.location.href = "{{ route('login') }}";
        }
        let redirected = false;
        function handleRedirect() {
            if (!redirected) {
                redirected = true;
                goToLogin();
            }
        }
        setTimeout(handleRedirect, 7000);
        document.body.addEventListener('click', handleRedirect);
        document.body.addEventListener('touchstart', handleRedirect);
    </script>
</body>
</html>
