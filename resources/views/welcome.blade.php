{{-- filepath: c:\Users\redne\capstone\resources\views\welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Caffe Arabica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet">

</head>
<body class="bg-amber-50 min-h-screen flex items-center justify-center relative"
      style="background: url('{{ asset('/images/START (1).svg') }}') center center / cover no-repeat;">

    <span class="absolute top-20 left-1/2 -translate-x-1/2 text-white text-[24px] font-normal responsive-font" style="font-family:'Times New Roman', Times, serif;">
        A cup of coffee a day without God is tasteless
    </span>
    <h1 class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white font-bold text-[48px] responsive-font" style="font-family: 'Cinzel', serif;">
        WELCOME TO CAFFE ARABICA
    </h1>
    <span class="absolute left-1/2 top-[53%] -translate-x-1/2 text-white text-[24px] font-normal responsive-font" style="font-family:'Times New Roman', Times, serif; letter-spacing: 0.1em;">
        A PREMIUM DINING EXPERIENCE
    </span>

    <!-- Bottom "Touch to start" button overlay -->
    <div class="fixed bottom-0 left-0 w-full bg-black bg-opacity-50 flex flex-col items-center py-6 cursor-pointer"
         style="cursor: pointer;">
        <a href="{{ route('systemDescription') }}">
            <button class="text-white text-3xl font-semibold mb-2 focus:outline-none responsive-font" style="font-family: 'Cinzel', serif; cursor: pointer;">
                Touch to start
            </button>
        </a>
        <span class="text-white text-base opacity-80 responsive-font" style="font-family:'Times New Roman', Times, serif; cursor: pointer;">
            Ready to order? Tap to begin.
        </span>
    </div>
</body>
<script>
    // Check for browser support
    window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (window.SpeechRecognition) {
        const recognition = new window.SpeechRecognition();
        recognition.continuous = true;
        recognition.interimResults = false;
        recognition.lang = 'en-US';

        recognition.onresult = function(event) {
            for (let i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    const transcript = event.results[i][0].transcript.trim().toLowerCase();
                    if (transcript.includes('touch to start')) {
                        window.location.href = "{{ route('systemDescription') }}";
                    }
                }
            }
        };

        recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
        };

        recognition.start();
    } else {
        console.warn('Speech Recognition API not supported in this browser.');
    }
</script>

</html>
