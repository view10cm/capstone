@extends('customerBase')

@section('title', 'Caffe Arabica - Order Area')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        .active-category {
            background-color: #f97316;
            /* orange-500 */
            color: white;
        }

        .active-subcategory {
            border-bottom: 2px solid #f97316;
            /* orange-500 */
            color: #f97316;
        }

        /* Custom scrollbar for order items */
        .order-items-container {
            max-height: 300px;
            overflow-y: auto;
        }

        .order-items-container::-webkit-scrollbar {
            width: 6px;
        }

        .order-items-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .order-items-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .order-items-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Loading spinner */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left: 4px solid #f97316;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 10px;
            vertical-align: middle;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('content')
    <div class="flex min-h-screen bg-gray-50">
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col relative">
            <!-- Brand Header -->
            <div class="">
                <img src="{{ asset('images/Brand Header.svg') }}" alt="Caffe Arabica" class="w-full object-cover"
                    style="height: 120px; max-height: 120px;">
            </div>

            @include('customer.productsGallery')

            <!-- Spacer to push the conversation panel and bottom image down -->
            <div class="flex-1"></div>

            <!-- Bottom Customer Order Area Image with Microphone Button -->
            <div class="mt-auto relative">
                <!-- Conversation Panel - Positioned behind the microphone, full width of main content area -->
                <div class="absolute bottom-0 left-0 right-0 z-10 mb-6">
                    <div class="bg-white shadow-lg border border-gray-200 max-h-48 overflow-hidden"
                        style="font-family: 'Manrope', 'Arial', sans-serif;">
                        <!-- Conversation Messages Area -->
                        <div id="conversation-panel" class="p-6 max-h-40 overflow-y-auto scrollbar-hide"
                            style="scrollbar-width: none; -ms-overflow-style: none;">
                            <style>
                                .scrollbar-hide::-webkit-scrollbar {
                                    display: none;
                                }
                            </style>
                            <!-- Welcome Message -->
                            <div class="mb-4">
                                <div class="flex items-start space-x-3">
                                    <div class="bg-orange-100 rounded-full p-2 flex-shrink-0">
                                        <img src="{{ asset('images/voiceFill.svg') }}" alt="Voice Assistant"
                                            class="w-4 h-4">
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-gray-100 rounded-lg px-4 py-3 max-w-md">
                                            <p class="text-gray-800" style="font-size: 16px;">Hello! Welcome to Caffe
                                                Arabica. My name is Dinevo! What would you like to order today?</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Assistant</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Placeholder for conversation messages -->
                            <div id="conversation-messages" class="text-center text-gray-400 py-8">
                                <!-- Transcribed messages will appear here -->
                            </div>
                        </div>
                    </div>
                </div>

                <img src="{{ asset('images/orderSpeakOrange.svg') }}" alt="Customer Order Area"
                    class="w-full h-auto relative z-20">

                <!-- Microphone Button Overlay -->
                <div class="absolute inset-0 flex items-center justify-center z-30" style="transform: translateY(-25%)">
                    <button
                        class="bg-white rounded-full p-4 shadow-lg hover:shadow-xl transition-shadow duration-200 hover:bg-gray-50 active:scale-95 transform transition-transform border-2 border-gray-300"
                        id="microphone-btn" type="button">
                        <svg class="w-8 h-8 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z" />
                            <path
                                d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Order Summary -->
        <div class="w-80 bg-white shadow-lg border-l border-gray-200 rounded-tl-xl rounded-tr-xl">
            <div class="p-6 h-full flex flex-col">
                <!-- Header -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Order Summary</h2>

                    <!-- Order Type Selection -->
                    <div class="flex mt-4 space-x-2">
                        <button id="dine-in-btn"
                            class="flex-1 py-2 bg-orange-500 text-white rounded-md font-medium text-sm">
                            Dine-in
                        </button>
                        <button id="takeout-btn"
                            class="flex-1 py-2 bg-gray-200 text-gray-700 rounded-md font-medium text-sm">
                            Takeout
                        </button>
                    </div>
                </div>

                <!-- Order Items Container -->
                <div id="order-items-container" class="order-items-container mb-4">
                    <!-- Order items will be dynamically added here -->
                </div>

                <!-- Order Summary Details -->
                <div class="mt-auto border-t border-gray-200 pt-4">
                    <!-- Special Request -->
                    <div class="mb-4">
                        <textarea id="special-request" placeholder="Special Request"
                            class="w-full p-2 border border-gray-300 rounded-md text-sm resize-none" rows="2"></textarea>
                    </div>

                    <!-- Summary -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Items (<span id="items-count">0</span>)</span>
                            <span>₱<span id="subtotal">0.00</span></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax</span>
                            <span>₱<span id="tax">0.00</span></span>
                        </div>
                        <div class="flex justify-between font-semibold text-lg mt-2">
                            <span>Total Amount</span>
                            <span>₱<span id="total-amount">0.00</span></span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3 mt-6">
                        <button id="cancel-order" class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-md font-medium">
                            Cancel
                        </button>
                        <button id="checkout-btn" class="flex-1 py-3 bg-orange-500 text-white rounded-md font-medium"
                            disabled style="cursor: not-allowed; opacity: 0.6;">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Confirmation Modal -->
    <div id="order-confirm-modal" class="fixed inset-0 flex items-center justify-center bg-transparent backdrop-blur-md bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Confirm Order?</h3>
            <p class="text-gray-600 mb-6">Your order will be sent to Caffe Arabica Staff for payment.</p>
            <div class="flex space-x-4 justify-center">
                <button id="confirm-order-btn" class="bg-orange-500 text-white px-6 py-2 rounded font-medium">Confirm</button>
                <button id="cancel-modal-btn" class="bg-gray-200 text-gray-700 px-6 py-2 rounded font-medium">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Order Success Modal -->
    <div id="order-success-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center">
            <h3 class="text-xl font-semibold mb-4 text-green-600">Order placed successfully!</h3>
            <p class="text-gray-700 mb-6">Your order ID is: <span id="order-id-success" class="font-bold text-orange-500"></span>
            </p>
            <button id="close-success-modal-btn"
                class="bg-orange-500 text-white px-6 py-2 rounded font-medium">Close</button>
        </div>
    </div>

    <script>
        // Text-to-speech functionality - Always enabled
        function speakText(text) {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.rate = 1.0;
                utterance.pitch = 1.0;
                utterance.volume = 1.0;
                utterance.lang = 'en-US';
                
                // Wait for voices to load
                if (speechSynthesis.getVoices().length === 0) {
                    speechSynthesis.addEventListener('voiceschanged', function() {
                        const voices = speechSynthesis.getVoices();
                        const preferredVoice = voices.find(voice => 
                            voice.lang.includes('en') && 
                            voice.name.toLowerCase().includes('female')
                        );
                        if (preferredVoice) {
                            utterance.voice = preferredVoice;
                        }
                        speechSynthesis.speak(utterance);
                    });
                } else {
                    const voices = speechSynthesis.getVoices();
                    const preferredVoice = voices.find(voice => 
                        voice.lang.includes('en') && 
                        voice.name.toLowerCase().includes('female')
                    );
                    if (preferredVoice) {
                        utterance.voice = preferredVoice;
                    }
                    speechSynthesis.speak(utterance);
                }
            } else {
                console.warn('Speech synthesis not supported in this browser.');
            }
        }

        // New function to extract size from command
        function extractSizeFromCommand(command) {
            const sizePatterns = {
                '8oz': ['8oz', '8 oz', '8 ounce', '8 ounces', 'eight ounce', 'eight oz', 'eight'],
                '12oz': ['12oz', '12 oz', '12 ounce', '12 ounces', 'twelve ounce', 'twelve oz', 'twelve', '12'],
                '16oz': ['16oz', '16 oz', '16 ounce', '16 ounces', 'sixteen ounce', 'sixteen oz', 'sixteen', '16']
            };

            // Also check for number patterns that might indicate size
            const numberWords = {
                '8': ['eight', 'ate'],
                '12': ['twelve'],
                '16': ['sixteen']
            };

            // First check for explicit size patterns
            for (const [size, patterns] of Object.entries(sizePatterns)) {
                for (const pattern of patterns) {
                    // Use word boundaries to avoid partial matches
                    const regex = new RegExp('\\b' + pattern + '\\b', 'i');
                    if (regex.test(command)) {
                        return size;
                    }
                }
            }

            // Then check for number words that might indicate size
            for (const [number, words] of Object.entries(numberWords)) {
                for (const word of words) {
                    const regex = new RegExp('\\b' + word + '\\b', 'i');
                    if (regex.test(command)) {
                        return number + 'oz';
                    }
                }
            }

            return null;
        }

        // New function to extract product type from command
        function extractProductFromCommand(command) {
            const productKeywords = {
                'espresso': ['espresso', 'expresso', 'espress', 'express'],
                'caffe americano': ['americano', 'american coffee', 'cafe americano', 'caffe americano'],
                'cappuccino': ['cappuccino', 'capuccino', 'cappuchino'],
                'latte': ['latte', 'late', 'latté'],
                'mocha': ['mocha', 'moca', 'mocka'],
                'macchiato': ['macchiato', 'machiato', 'macato'],
                'double espresso': ['double espresso', 'double expresso', 'dobol espresso', 'double']
            };

            for (const [product, keywords] of Object.entries(productKeywords)) {
                for (const keyword of keywords) {
                    if (command.includes(keyword)) {
                        return product;
                    }
                }
            }
            return null;
        }

        // New function to find exact product match
        function findExactProductMatch(productType, size) {
            const searchTerm = productType.toLowerCase();
            const sizeTerm = size.toLowerCase();
            
            for (const product of window.allAvailableProducts) {
                const productName = product.productName.toLowerCase();
                
                // Check if product name contains both the product type and size
                if (productName.includes(searchTerm) && productName.includes(sizeTerm)) {
                    product.confidenceScore = 100;
                    return product;
                }
            }
            return null;
        }

        // New function for fallback matching
        function findFallbackProduct(productType, preferredSize = null) {
            const searchTerm = productType.toLowerCase();
            let bestMatch = null;
            let bestScore = 0;

            for (const product of window.allAvailableProducts) {
                const productName = product.productName.toLowerCase();
                let score = 0;

                // Base score for product type match
                if (productName.includes(searchTerm)) {
                    score += 70;
                }

                // Bonus for preferred size match
                if (preferredSize && productName.includes(preferredSize.toLowerCase())) {
                    score += 30;
                } else if (preferredSize) {
                    // Penalty for wrong size
                    score -= 20;
                }

                if (score > bestScore) {
                    bestScore = score;
                    bestMatch = product;
                    bestMatch.confidenceScore = Math.max(0, score);
                }
            }

            return bestMatch && bestMatch.confidenceScore >= 50 ? bestMatch : null;
        }

        // Voice recording and transcript display
        document.addEventListener('DOMContentLoaded', function() {
            const micBtn = document.getElementById('microphone-btn');
            const messagesPanel = document.getElementById('conversation-messages');
            const conversationPanel = document.getElementById('conversation-panel');
            let recognizing = false;
            let recognition;

            // Store all available products for voice recognition
            window.allAvailableProducts = @json($products);

            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                recognition = new SpeechRecognition();
                recognition.continuous = false;
                recognition.interimResults = false;
                recognition.lang = 'en-US';

                recognition.onstart = function() {
                    recognizing = true;
                    micBtn.classList.add('bg-orange-100');
                };
                recognition.onend = function() {
                    recognizing = false;
                    micBtn.classList.remove('bg-orange-100');
                };
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    displayUserMessage(transcript);
                    processVoiceCommand(transcript);
                };
            } else {
                micBtn.disabled = true;
                micBtn.title = 'Speech Recognition not supported in this browser.';
            }

            micBtn.addEventListener('click', function() {
                if (!recognition) return;
                if (recognizing) {
                    recognition.stop();
                } else {
                    recognition.start();
                }
            });

            function displayUserMessage(text) {
                const msgDiv = document.createElement('div');
                msgDiv.className = 'flex items-start space-x-3 mb-4 justify-end';
                msgDiv.innerHTML = `
                <div class="flex-1 text-right">
                    <div class="bg-orange-100 rounded-lg px-4 py-3 max-w-md inline-block">
                        <p class="text-gray-800" style="font-size: 16px;">${text}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">You</p>
                </div>
            `;
                messagesPanel.appendChild(msgDiv);
                messagesPanel.classList.remove('text-gray-400', 'py-8');

                // Auto-scroll to bottom
                conversationPanel.scrollTop = conversationPanel.scrollHeight;
            }

            function displaySystemMessage(text) {
                const msgDiv = document.createElement('div');
                msgDiv.className = 'flex items-start space-x-3 mb-4';
                msgDiv.innerHTML = `
                <div class="bg-orange-100 rounded-full p-2 flex-shrink-0">
                    <img src="{{ asset('images/voiceFill.svg') }}" alt="Voice Assistant" class="w-4 h-4">
                </div>
                <div class="flex-1">
                    <div class="bg-gray-100 rounded-lg px-4 py-3 max-w-md">
                        <p class="text-gray-800" style="font-size: 16px;">${text}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Assistant</p>
                </div>
            `;
                messagesPanel.appendChild(msgDiv);

                // Auto-scroll to bottom
                conversationPanel.scrollTop = conversationPanel.scrollHeight;
                
                // Speak the message with error handling
                try {
                    speakText(text);
                } catch (error) {
                    console.warn('Text-to-speech failed:', error);
                }
            }

            function processVoiceCommand(transcript) {
                const command = transcript.toLowerCase().trim();
                console.log("=== VOICE COMMAND DEBUG ===");
                console.log("Processing voice command:", command);

                // Debug: log all available products
                console.log("Available products:", window.allAvailableProducts.map(p => p.productName));

                let matchedProduct = findProductByVoiceCommand(command);

                if (matchedProduct) {
                    console.log("✅ FINAL MATCH:", matchedProduct.productName, "Confidence:", matchedProduct.confidenceScore + "%");
                    addToOrder(matchedProduct);
                    displaySystemMessage(`The ${matchedProduct.productName} is added to the order. Is there anything else you want to add?`);
                } else {
                    console.log("❌ No product matched");
                    displaySystemMessage("I couldn't find that product. Please try again or browse the menu.");
                }
                console.log("=== END DEBUG ===");
            }

            function findProductByVoiceCommand(command) {
                // Convert command to lowercase and clean it up
                const cleanCommand = command.toLowerCase().trim();
                
                // Log for debugging
                console.log("Voice command received:", cleanCommand);
                
                // Extract size from command first
                const detectedSize = extractSizeFromCommand(cleanCommand);
                console.log("Detected size:", detectedSize);
                
                // Extract product type from command
                const detectedProduct = extractProductFromCommand(cleanCommand);
                console.log("Detected product:", detectedProduct);
                
                // If we have both product and size, try to find exact match first
                if (detectedProduct && detectedSize) {
                    const exactMatch = findExactProductMatch(detectedProduct, detectedSize);
                    if (exactMatch) {
                        console.log("Found exact product with size match:", exactMatch.productName);
                        return exactMatch;
                    }
                }
                
                // Try keyword-based matching with size consideration
                const keywordMatch = findProductByKeywords(cleanCommand, detectedSize, detectedProduct);
                if (keywordMatch && keywordMatch.confidenceScore >= 60) {
                    return keywordMatch;
                }
                
                // Final fallback - find any product that matches the main product type
                if (detectedProduct) {
                    const fallbackMatch = findFallbackProduct(detectedProduct, detectedSize);
                    if (fallbackMatch) {
                        console.log("Using fallback match:", fallbackMatch.productName);
                        return fallbackMatch;
                    }
                }
                
                return null;
            }

            function findProductByKeywords(command, detectedSize = null, detectedProduct = null) {
                // Define product keywords and their variations
                const productKeywords = {
                    'ala': [
                        'a la', 'alla', 'ala', 'aala',
                    ],
                    'alfredo': [
                        'alfredo', 'apredo', 'alpedo', 'alpredo',
                    ],
                    'aligue': [
                        'alige', 'aligue', 'algiue', 'allyigwe',
                    ],
                    'almond': [
                        'almond', 'ahmond', 'amond', 'halmond',
                    ],
                    'baby': [
                        'baby', 'beybi', 'babby', 'babi',
                    ],
                    'back': [
                        'back', 'bak', 'bacc', 'buck',
                    ],
                    'baked': [
                        'baked', 'bake', 'backe', 'beyk',
                    ],
                    'bang': [
                        'bang', 'bangg', 'beng', 'bing',
                    ],
                    'bean': [
                        'bean', 'been', 'bin', 'binn',
                    ],
                    'belago': [
                        'belago', 'belaygo', 'bellago', 'bilago',
                    ],
                    'belly': [
                        'belly', 'bely', 'bel ly', 'belie',
                    ],
                    'biscoff': [
                        'biscoff', 'biskop', 'bisco', 'biskof',
                    ],
                    'binagoongan': [
                        'binagoongan', 'bagoong', 'bagong', 'bagoongan',
                    ],
                    'bone': [
                        'bone', 'bown', 'bonn', 'bon',
                    ],
                    'bulgogi': [
                        'bulgogi', 'bugogi', 'bul go gi', 'bulgogii',
                    ],
                    'buttered': [
                        'buttered', 'battered', 'bettered', 'bottered',
                    ],
                    'caesar': [
                        'caesar', 'cr', 'sisar', 'seesar',
                    ],
                    'canton': [
                        'canton', 'kanton', 'cantoon', 'kantoon',
                    ],
                    'cajun': [
                        'cajun', 'kajun', 'caa jun', 'cajoon',
                    ],
                    'aligue': [
                        'alige', 'aligue', 'algiue', 'allyigwe',
                    ],
                    'cappuccino': [
                        'cappuccino', 'capuccino', 'cappuchino', 'capruccino'
                    ],
                    'cheese': [
                        'cheese', 'chiz', 'chis', 'chiss',
                    ],
                    'chip': [
                        'chip', 'tsip', 'cheap', 'cheep',
                    ],
                    'choco': [
                        'choco', 'cho co', 'chooco', 'tsoco',
                    ],
                    'classic': [
                        'classic', 'class', 'clasik', 'klasic',
                    ],
                    'clubhouse': [
                        'clubhouse', 'club house', 'clumbhouse', 'clumphouse',
                    ],
                    'cookies': [
                        'cookies', 'kookies', 'cookie', 'cookies',
                    ],
                    'cristo': [
                        'cristo', 'christ', 'crist', 'cisto',
                    ],
                    'cutlet': [
                        'cutlet', 'cat let', 'katlet', 'cuttlet',
                    ],
                    'dressing': [
                        'dressing', 'dreesing', 'resting', 'deuresting',
                    ],
                    'dory': [
                        'dory', 'dori', 'doryn', 'doreen',
                    ],
                    'english': [
                        'english', 'inglish', 'englissh', 'anglish',
                    ],
                    'fish': [
                        'fish', 'pish', 'feesh', 'fissh',
                    ],
                    'honey': [
                        'honey', 'honi', 'hunney', 'hunni',
                    ],
                    'hungarian': [
                        'hungarian', 'hungaryan', 'hungariyan', 'hungarian',
                    ],
                    'java': [
                        'java', 'jawa', 'jova', 'jaba',
                    ],
                    'kare-kare': [
                        'kare-kare', 'kare kare', 'curry curry', 'carre carre',
                    ],
                    'king': [
                        'king', 'kingg', 'keng', 'kang',
                    ],
                    'korean': [
                        'korean', 'koreyan', 'koreaan', 'koreon',
                    ],
                    'lasagna': [
                        'lasagna', 'lasagna', 'lasania', 'lazanya',
                    ],
                    'lemon': [
                        'lemon', 'lemen', 'lemun', 'limon',
                    ],
                    'macademia': [
                        'macademia', 'makademia', 'macadamia', 'makadamia',
                    ],
                    'mexican': [
                        'mexican', 'meksikan', 'mexi kan', 'meksican',
                    ],
                    'milk': [
                        'milk', 'milc', 'milik', 'melk',
                    ],
                    'mojos': [
                        'mojos', 'mojos', 'mojos', 'mojos',
                    ],
                    'monte' : [
                        'monte', 'monte', 'monte', 'monte',
                    ],
                    'nachos': [
                        'nachos', 'nachos', 'nachos', 'nachos',
                    ],
                    'negra': [
                        'negra', 'negra', 'negro', 'negra',
                    ],
                    'okinawa': [
                        'okinawa', 'okinawa', 'okinawa', 'okinawa',
                    ],
                    'orane': [
                        'orane','orange', 'oreyn', 'foreign',
                    ],
                    'orange': [
                        'orange', 'oreynts', 'foreigns', 'oregin',
                    ],
                    'order': [
                        'order', 'ordir', 'odder', 'older',
                    ],
                    'oregano': [
                        'oregano', 'organo', 'ore gano', 'origano',
                    ],
                    'pad': [
                        'pad', 'phad', 'pa ad', 'pod',
                    ],
                    'pancit': [
                        'pancit', 'pasit', 'pan sit', 'pansit',
                    ],
                    'parmesan': [
                        'parmesan', 'pamesan', 'par mesan', 'parmisan',
                    ],
                    'peanut': [
                        'peanut', 'pinat', 'pea nut', 'nuts',
                    ],
                    'pesto': [
                        'pesto', 'pest o', 'pest', 'pisto',
                    ],
                    'porchetta': [
                        'porchetta', 'porsetta', 'ponseitta', 'allyigwe',
                    ],
                    'potato': [
                        'potato', 'po ta to', 'poteeto', 'patatas',
                    ],
                    'pulled': [
                        'pulled', 'pull', 'poll', 'polled',
                    ],
                    'pumpkin': [
                        'pumpkin', 'plumpkin', 'kalabasa', 'pump keen',
                    ],
                    'rangoon': [
                        'rangoon', 'rang goon', 'ragoon', 'rungoon',
                    ],
                    'red': [
                        'red', 'reed', 'read', 'rid',
                    ],
                    'ribs': [
                        'ribs', 'ribb', 'rib', 'reeb',
                    ],
                    'rice': [
                        'rice', 'rise', 'ri ce', 'rice',
                    ],
                    'rocksalt': [
                        'rocksalt', 'rock salt', 'salt rock', 'rocksalt',
                    ],
                    'sausage': [
                        'sausage', 'susej', 'sauce age', 'soosage',
                    ],
                    'savoury': [
                        'savoury', 'savory', 'savor ree', 'savor',
                    ],
                    'single': [
                        'single', 'singel', 'sengle', 'sangle',
                    ],
                    'skewers': [
                        'skewers', 'skewers', 'skewers', 'skewers',
                    ],
                    'smothered': [
                        'smothered', 'smother', 'smothred', 'smothed',
                    ],
                    'sour': [
                        'sour', 'sower', 'sourr', 'sor',
                    ],
                    'special': [
                        'special', 'specal', 'spesial', 'spesel',
                    ],
                    'spinach': [
                        'spinach', 'spinash', 'spenach', 'spenash',
                    ],
                    'strawberry': [
                        'strawberry', 'strawbery', 'strawberri', 'strawbary',
                    ],
                    'sweet': [
                        'sweet', 'sweat', 'swet', 'swett',
                    ],
                    'taco': [
                        'taco', 'tako', 'tacco', 'takoo',
                    ],
                    'tapa':[
                        'tapa', 'tappa', 'tappa', 'tapa',
                    ],
                    'taro': [
                        'taro', 'taro', 'taro', 'taro',
                    ],
                    'teriyaki': [
                        'teriyaki', 'teriyaki', 'teriyaki', 'teriyaki',
                    ],
                    'terragon' : [
                        'terragon', 'terragon', 'terragon', 'terragon',
                    ],
                    'thai': [
                        'thai', 'tai', 'thay', 'thae',
                    ],
                    'toffee': [
                        'toffee', 'tofi', 'toffy', 'tofe',
                    ],
                    'ube': [
                        'ube', 'oobe', 'oob', 'ube',
                    ],
                    'ultimate': [
                        'ultimate', 'ultimatte', 'ultimat', 'ultemate',
                    ],
                    'velvet': [
                        'velvet', 'velvit', 'velvet', 'velvet',
                    ],
                    'wintermelon': [
                        'wintermelon', 'winter melon', 'wintermalon', 'winter melun',
                    ],
                    'bagnet': [
                        'bagnet', 'bagnet', 'bagnet', 'bagnet',
                    ],
                    'barbeque': [
                        'barbeque', 'barbecue', 'bar b que', 'bar b q',
                    ],
                    'butterscotch': [
                        'butterscotch', 'butter scotch', 'buter scotch', 'buter scot',
                    ],
                    'cheesecake':[
                        'cheesecake', 'cheese cake', 'cheesecak', 'cheesecak',
                    ],
                    'cheesy': [
                        'cheesy', 'chizzy', 'chees', 'chisy',
                    ],
                    'crab': [
                        'crab', 'krab', 'crabb', 'crap',
                    ],
                    'creamy': [
                        'cream', 'crem', 'creme', 'crem',
                    ],
                    'double': [
                        'double', 'dobol', 'duoble', 'do b le',
                    ],
                    'espresso': [
                        'espresso', 'expresso', 'espress', 'express'
                    ],
                    'garlic': [
                        'garlic', 'garlic', 'garlic', 'garlic',
                    ],
                    'mango': [
                        'mango', 'mango', 'mango', 'mango',
                    ],
                    'paella': [
                        'paella', 'paella', 'paella', 'paella',
                    ],
                    'platter': [
                        'platter', 'plater', 'plater', 'platter',
                    ],
                    'plain': [
                        'plain', 'playn', 'plaine', 'plein',
                    ],
                    'quesadillas': [
                        'quesadillas', 'kesadillas', 'quesadila', 'quesadilas',
                    ],
                    'roasted': [
                        'roasted', 'rosted', 'roastid', 'roasted',
                    ],
                    'sandwich': [
                        'sandwich', 'sand wich', 'sandwiche', 'sandwitch',
                    ],
                    'shrimp': [
                        'shrimp', 'shrimps', 'shrim', 'shrimps',
                    ],
                    'steak': [
                        'steak', 'steak', 'steak', 'steak',
                    ],
                    'white': [
                        'white', 'whyte', 'whit', 'whitte',
                    ],
                    'wrap': [
                        'wrap', 'rap', 'wrapp', 'wrab',
                    ],
                    'americano': [
                        'americano', 'american coffee', 'cafe americano', 'caffe americano',
                    ],
                    'butter': [
                        'butter', 'buter', 'buttr', 'buttur',
                    ],
                    'fries': [
                        'fries', 'fryes', 'friez', 'frees',
                    ],
                    'grilled': [
                        'grilled', 'grild', 'gril led', 'grilled',
                    ],
                    'hazelnut': [
                        'hazelnut', 'haselnut', 'hazel nut', 'hazelnutt',
                    ],
                    'seafood': [
                        'seafood', 'seafod', 'seefood', 'sea food',
                    ],
                    'wings': [
                        'wings', 'wing', 'winggs', 'wings',
                    ],
                    'beef': [
                        'beef', 'beef', 'beef', 'beef',
                    ],
                    'chocolate': [
                        'chocolate', 'choclate', 'chocolat', 'chockolate',
                    ],
                    'french': [
                        'french', 'frenche', 'frenchh', 'french',
                    ],
                    'macchiato': [
                        'macchiato', 'machiato', 'macato'
                    ],
                    'matcha': [
                        'matcha', 'macha', 'matca', 'mat cha',
                    ],
                    'salad': [
                        'salad', 'selad', 'salid', 'saladd',
                    ],
                    'salted': [
                        'salted', 'saltid', 'saulted', 'salted',
                    ],
                    'sauce': [
                        'sauce', 'sause', 'sos', 'sauz',
                    ],
                    'vanilla': [
                        'vanilla', 'vanila', 'vanila', 'vanilla',
                    ],
                    'arabicas': [
                        'arabicas', 'arabica', 'arabcis', 'arabikas',
                    ],
                    'mocha': [
                        'mocha', 'moca', 'mocka'
                    ],
                    'adoras': [
                        'adoras', 'adoras', 'adoras', 'adoras',
                    ],
                    'and': [
                        'and', 'end', 'an', 'und',
                    ],
                    'caramel': [
                        'caramel', 'caramell', 'carmel', 'caramle',
                    ],
                    'crispy': [
                        'crispy', 'crisy', 'crisspy', 'crisspi',
                    ],
                    'caffe': [
                        'caffe', 'cafe', 'caffee', 'caffé',
                    ],
                    'pasta': [
                        'pasta', 'pasta', 'pasta', 'pasta',
                    ],
                    'pork': [
                        'pork', 'pork', 'pork', 'pork',
                    ],
                    'milktea': [
                        'milktea', 'milk tea', 'milkte', 'milktea',
                    ],
                    'with': [
                        'with', 'wit', 'withe', 'with',
                    ],
                    'frappe': [
                        'frappe', 'frap', 'frappé', 'frappe',
                    ],
                    'iced': [
                        'iced', 'ised', 'ice d', 'iced',
                    ],
                    'latte': [
                        'latte', 'late', 'latté'
                    ],
                    'chicken': [
                        'chicken', 'chiken', 'chickin', 'chickenn',
                    ]
                };

                // Try to find the best product match
                let bestMatch = null;
                let bestScore = 0;

                for (const product of window.allAvailableProducts) {
                    const productName = product.productName.toLowerCase();
                    let score = 0;

                    // Check against product keywords (Max: 60%)
                    for (const [baseProduct, variations] of Object.entries(productKeywords)) {
                        for (const variation of variations) {
                            if (command.includes(variation)) {
                                // If the actual product name contains the base product, give high score
                                if (productName.includes(baseProduct)) {
                                    score += 60; // 60% for primary product match
                                }
                            }
                        }
                    }

                    // Bonus for detected product type match (Max: 40%)
                    if (detectedProduct && productName.includes(detectedProduct)) {
                        score += 40;
                    }

                    // Size matching (Max: 50% - very important)
                    if (detectedSize) {
                        const sizePattern = detectedSize.toLowerCase();
                        if (productName.includes(sizePattern)) {
                            score += 50; // 50% for correct size
                            console.log("Size match bonus applied for:", productName);
                        } else {
                            // Heavy penalty for size mismatch when size is specifically requested
                            score -= 40; // -40% penalty for wrong size
                            console.log("Size mismatch penalty applied for:", productName);
                        }
                    }

                    // Ensure score is between 0-100%
                    score = Math.max(0, Math.min(100, score));

                    if (score > bestScore) {
                        bestScore = score;
                        bestMatch = product;
                        bestMatch.confidenceScore = Math.round(score);
                    }
                }

                console.log("Best match confidence:", bestScore + "%", "Product:", bestMatch?.productName);
                
                // Only return if we have a good match
                return bestScore >= 50 ? bestMatch : null;
            }

            function findProductByFuzzyMatch(command, detectedSize = null) {
                let bestMatch = null;
                let bestScore = 0;

                for (const product of window.allAvailableProducts) {
                    const productName = product.productName.toLowerCase();
                    const similarity = calculateSimilarity(command, productName);
                    let score = Math.round(similarity * 100); // Convert to percentage

                    // Size consideration for fuzzy matching
                    if (detectedSize) {
                        const sizePattern = detectedSize.toLowerCase();
                        if (productName.includes(sizePattern)) {
                            score += 25; // Bonus for correct size
                        } else {
                            score -= 20; // Penalty for wrong size
                        }
                    }

                    // Additional checks to prevent wrong matches
                    if (command.includes('americano') && productName.includes('espresso') && !productName.includes('americano')) {
                        score -= 50; // -50% penalty
                    }

                    // Ensure score is between 0-100%
                    score = Math.max(0, Math.min(100, score));

                    if (score > bestScore) {
                        bestScore = score;
                        bestMatch = product;
                        bestMatch.confidenceScore = score;
                    }
                }

                return bestMatch;
            }

            function calculateSimilarity(str1, str2) {
                // Improved similarity calculation
                const words1 = str1.split(/\s+/).filter(word => word.length >= 3);
                const words2 = str2.split(/\s+/).filter(word => word.length >= 3);

                if (words1.length === 0 || words2.length === 0) return 0;

                let matchCount = 0;
                for (const word1 of words1) {
                    for (const word2 of words2) {
                        // More flexible matching
                        if (word2.includes(word1) || word1.includes(word2) || 
                            levenshteinDistance(word1, word2) <= 2) {
                            matchCount++;
                            break;
                        }
                    }
                }

                return matchCount / Math.max(words1.length, words2.length);
            }

            // Add Levenshtein distance function for better fuzzy matching
            function levenshteinDistance(a, b) {
                const matrix = [];
                for (let i = 0; i <= b.length; i++) {
                    matrix[i] = [i];
                }
                for (let j = 0; j <= a.length; j++) {
                    matrix[0][j] = j;
                }
                for (let i = 1; i <= b.length; i++) {
                    for (let j = 1; j <= a.length; j++) {
                        if (b.charAt(i - 1) === a.charAt(j - 1)) {
                            matrix[i][j] = matrix[i - 1][j - 1];
                        } else {
                            matrix[i][j] = Math.min(
                                matrix[i - 1][j - 1] + 1,
                                matrix[i][j - 1] + 1,
                                matrix[i - 1][j] + 1
                            );
                        }
                    }
                }
                return matrix[b.length][a.length];
            }
        });

        // Order management (remaining code unchanged)
        window.orderItems = [];
        window.orderType = 'Dine-in'; // default

        // Set default category to Drinks
        window.currentCategory = 'drinks';
        window.currentSubcategory = 'hot';

        window.addToOrder = function(product) {
            // Check if product already exists in order
            const existingItemIndex = orderItems.findIndex(item => item.id === product.id);
            if (existingItemIndex !== -1) {
                orderItems[existingItemIndex].quantity += 1;
            } else {
                orderItems.push({
                    id: product.id,
                    name: product.productName,
                    price: parseFloat(product.productPrice),
                    quantity: 1,
                    image: product.productImage || null
                });
            }
            updateOrderDisplay();
        }

        window.updateOrderDisplay = function() {
            const orderContainer = document.getElementById('order-items-container');
            const itemsCount = document.getElementById('items-count');
            const subtotalEl = document.getElementById('subtotal');
            const taxEl = document.getElementById('tax');
            const totalAmountEl = document.getElementById('total-amount');
            const checkoutBtn = document.getElementById('checkout-btn');
            orderContainer.innerHTML = '';
            if (orderItems.length === 0) {
                orderContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center text-center py-10">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z" />
                        <path d="M9 8V17H11V8H9ZM13 8V17H15V8H13Z" />
                    </svg>
                    <p class="text-gray-400 text-sm font-medium">Your order is still empty</p>
                </div>
            `;
                itemsCount.textContent = '0';
                subtotalEl.textContent = '0.00';
                taxEl.textContent = '0.00';
                totalAmountEl.textContent = '0.00';
                checkoutBtn.disabled = true;
                checkoutBtn.style.cursor = 'not-allowed';
                checkoutBtn.style.opacity = '0.6';
                return;
            } else {
                checkoutBtn.disabled = false;
                checkoutBtn.style.cursor = 'pointer';
                checkoutBtn.style.opacity = '1';
            }
            let itemsTotal = 0;
            let itemsCountValue = 0;
            orderItems.forEach((item, index) => {
                itemsTotal += item.price * item.quantity;
                itemsCountValue += item.quantity;
                const itemElement = document.createElement('div');
                itemElement.className = 'flex items-center bg-white rounded-lg shadow p-2 mb-2';
                itemElement.innerHTML = `
                <div class="w-16 h-16 bg-gray-200 rounded mr-3 flex-shrink-0 flex items-center justify-center overflow-hidden">
                    ${item.image ? `<img src="/storage/${item.image}" alt="${item.name}" class="w-full h-full object-cover rounded" />` : ''}
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-sm text-gray-800">${item.name}</span>
                        <span class="font-bold text-orange-500 text-base">₱${item.price.toFixed(2)}</span>
                    </div>
                    <div class="flex items-center mt-2">
                        <button onclick="decreaseQuantity(${index})" class="w-6 h-6 bg-orange-200 rounded-full flex items-center justify-center text-orange-700 font-bold">-</button>
                        <span class="mx-2 text-base font-semibold">${item.quantity}</span>
                        <button onclick="increaseQuantity(${index})" class="w-6 h-6 bg-orange-200 rounded-full flex items-center justify-center text-orange-700 font-bold">+</button>
                        <button onclick="removeItem(${index})" class="ml-3 w-6 h-6 bg-red-200 rounded-full flex items-center justify-center text-red-700 hover:bg-red-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
                orderContainer.appendChild(itemElement);
            });
            const tax = itemsTotal * 0.00;
            const totalAmount = itemsTotal + tax;
            itemsCount.textContent = itemsCountValue;
            subtotalEl.textContent = itemsTotal.toFixed(2);
            taxEl.textContent = tax.toFixed(2);
            totalAmountEl.textContent = totalAmount.toFixed(2);
        }

        window.increaseQuantity = function(index) {
            orderItems[index].quantity += 1;
            updateOrderDisplay();
        }

        window.decreaseQuantity = function(index) {
            if (orderItems[index].quantity > 1) {
                orderItems[index].quantity -= 1;
            } else {
                orderItems.splice(index, 1);
            }
            updateOrderDisplay();
        }

        window.removeItem = function(index) {
            orderItems.splice(index, 1);
            updateOrderDisplay();
        }

        // Function to handle checkout
        window.processCheckout = function() {
            const checkoutBtn = document.getElementById('checkout-btn');
            const originalText = checkoutBtn.innerHTML;

            // Show loading spinner
            checkoutBtn.innerHTML = '<div class="spinner"></div> Processing...';
            checkoutBtn.disabled = true;

            // Prepare order data
            const orderData = {
                order_type: orderType,
                order_date: new Date().toISOString(),
                special_request: document.getElementById('special-request').value,
                total_items: parseInt(document.getElementById('items-count').textContent),
                subtotal: parseFloat(document.getElementById('subtotal').textContent),
                tax: parseFloat(document.getElementById('tax').textContent),
                totalAmount: parseFloat(document.getElementById('total-amount').textContent),
                status: 'New Order',
                order_items: orderItems.map(item => ({
                    product_name: item.name,
                    quantity: item.quantity,
                    unit_price: item.price
                }))
            };

            // Send AJAX request to save order
            fetch('{{ route('order.checkout') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(orderData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success modal
                        document.getElementById('order-id-success').textContent = data.order_id;
                        document.getElementById('order-success-modal').classList.remove('hidden');
                        orderItems = [];
                        updateOrderDisplay();
                        document.getElementById('special-request').value = '';

                        // Redirect after 4 seconds
                        setTimeout(function() {
                            window.location.href = "{{ route('customer.landing') }}";
                        }, 4000);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing your order. Please try again.');
                })
                .finally(() => {
                    // Restore button text
                    checkoutBtn.innerHTML = originalText;
                    checkoutBtn.disabled = orderItems.length === 0;
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('drinks-btn').classList.add('active-category');
            document.querySelector('#drinks-subcategories button').classList.add('active-subcategory');

            const dineInBtn = document.getElementById('dine-in-btn');
            const takeoutBtn = document.getElementById('takeout-btn');

            dineInBtn.addEventListener('click', function() {
                orderType = 'Dine-in';
                dineInBtn.classList.add('bg-orange-500', 'text-white');
                dineInBtn.classList.remove('bg-gray-200', 'text-gray-700');
                takeoutBtn.classList.remove('bg-orange-500', 'text-white');
                takeoutBtn.classList.add('bg-gray-200', 'text-gray-700');
            });

            takeoutBtn.addEventListener('click', function() {
                orderType = 'Take-out';
                takeoutBtn.classList.add('bg-orange-500', 'text-white');
                takeoutBtn.classList.remove('bg-gray-200', 'text-gray-700');
                dineInBtn.classList.remove('bg-orange-500', 'text-white');
                dineInBtn.classList.add('bg-gray-200', 'text-gray-700');
            });

            // Set initial state
            dineInBtn.classList.add('bg-orange-500', 'text-white');
            takeoutBtn.classList.add('bg-gray-200', 'text-gray-700');

            document.getElementById('cancel-order').addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel this order?')) {
                    orderItems = [];
                    updateOrderDisplay();
                }
            });
            document.getElementById('checkout-btn').addEventListener('click', function() {
                document.getElementById('order-confirm-modal').classList.remove('hidden');
            });

            document.getElementById('cancel-modal-btn').addEventListener('click', function() {
                document.getElementById('order-confirm-modal').classList.add('hidden');
            });

            document.getElementById('confirm-order-btn').addEventListener('click', function() {
                document.getElementById('order-confirm-modal').classList.add('hidden');
                processCheckout();
            });

            document.getElementById('close-success-modal-btn').addEventListener('click', function() {
                document.getElementById('order-success-modal').classList.add('hidden');
            });

            updateOrderDisplay();
        });
    </script>
@endsection