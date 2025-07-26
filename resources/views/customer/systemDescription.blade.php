<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Caffe Arabica</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <style>
        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .bg-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative bg-gray-900">

    <!-- SVG Background (two methods for better compatibility) -->
    <img src="{{ asset('images/sysDescription.svg') }}" alt="Background" class="bg-svg">
    <div class="bg-overlay"></div>

    <h1 class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white font-bold text-4xl md:text-5xl lg:text-6xl text-center px-4" style="font-family: 'Cinzel', serif;">
        YOU ARE USING AN AI POWERED KIOSK
    </h1>
    <span class="absolute left-1/2 top-[45%] -translate-x-1/2 text-white text-lg md:text-xl lg:text-2xl font-normal text-center w-full px-4" style="font-family:'Times New Roman', Times, serif; letter-spacing: 0.1em;">
        This Kiosk is powered by AI Voice Technology to make your <br>
        ordering experience faster and more convenient. With voice<br>
        assisted features and minimal touch interaction, you can place <br>
        your order with ease and comfort.
    </span>

    <script>
        // Global flag to track if we're currently speaking
        let isSpeaking = false;
        
        // Improved voice synthesis with queue system
        function speakText() {
            if (isSpeaking) return;
            isSpeaking = true;
            
            if (!('speechSynthesis' in window)) {
                console.warn("Speech synthesis not supported");
                isSpeaking = false;
                return;
            }

            // Cancel any ongoing speech
            window.speechSynthesis.cancel();
            
            // Wait for voices to load if needed
            const voices = window.speechSynthesis.getVoices();
            if (voices.length === 0) {
                window.speechSynthesis.onvoiceschanged = initSpeech;
                return;
            }
            
            initSpeech();
            
            function initSpeech() {
                const voices = window.speechSynthesis.getVoices();
                if (voices.length === 0) {
                    console.warn("No voices available");
                    isSpeaking = false;
                    return;
                }

                // Select the best available voice
                const preferredVoices = [
                    'Microsoft Zira - English (United States)',
                    'Google UK English Female',
                    'Samantha',
                    'Karen',
                    'Daniel',
                    'Google US English'
                ];
                
                const selectedVoice = voices.find(voice => 
                    preferredVoices.includes(voice.name)
                ) || voices[0];

                // Split the message into two utterances
                const message1 = "This Kiosk is powered by AI Voice Technology to make your ordering experience faster and more convenient.";
                const message2 = "With voice assisted features and minimal touch interaction, you can place your order with ease and comfort.";
                
                const utterance1 = new SpeechSynthesisUtterance(message1);
                const utterance2 = new SpeechSynthesisUtterance(message2);
                
                // Configure both utterances
                [utterance1, utterance2].forEach(utt => {
                    if (selectedVoice) utt.voice = selectedVoice;
                    utt.volume = 1;
                    utt.rate = 0.85; // Slightly slower for better comprehension
                    utt.pitch = 1;
                });

                // Queue the utterances
                utterance1.onend = function() {
                    // Small delay before second part
                    setTimeout(() => {
                        try {
                            window.speechSynthesis.speak(utterance2);
                        } catch (e) {
                            console.error("Error speaking part 2:", e);
                            isSpeaking = false;
                        }
                    }, 500); // Increased pause between parts
                };
                
                utterance2.onend = function() {
                    isSpeaking = false;
                };
                
                utterance1.onerror = function(event) {
                    console.error("Speech error:", event.error);
                    isSpeaking = false;
                };
                
                utterance2.onerror = function(event) {
                    console.error("Speech error:", event.error);
                    isSpeaking = false;
                };
                
                // Start speaking
                try {
                    window.speechSynthesis.speak(utterance1);
                } catch (e) {
                    console.error("Error speaking part 1:", e);
                    isSpeaking = false;
                }
            }
        }

        // Start voice when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Some browsers need a small delay
            setTimeout(() => {
                speakText();
            }, 1000); // Increased initial delay
        });

        // Redirect functionality
        function goToLogin() {
            window.location.href = "#";
        }

        let redirected = false;
        function handleRedirect() {
            if (!redirected) {
                redirected = true;
                if (window.speechSynthesis) {
                    window.speechSynthesis.cancel();
                }
                goToLogin();
            }
        }

        // Auto-redirect after 15 seconds (longer to hear full message)
        setTimeout(handleRedirect, 15000);
        
        // Redirect on any user interaction
        document.body.addEventListener('click', handleRedirect);
        document.body.addEventListener('touchstart', handleRedirect);
    </script>
</body>
</html>