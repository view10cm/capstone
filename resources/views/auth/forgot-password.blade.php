<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('/images/landingPageBackground.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        .card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
        }
        .btn-primary {
            background-color: #3b82f6;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
        }
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .back-link {
            transition: all 0.2s ease;
        }
        .back-link:hover {
            transform: translateX(-3px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="card bg-white rounded-2xl p-8 border border-white/50">
            <!-- Header with Logo/Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center mb-4">
                    <img src="/images/cuate.svg" alt="Forgot Password" class="w-32 h-32">
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">FORGOT PASSWORD</h1>
                <p class="text-gray-600">Enter your email to receive the OTP code.</p>
            </div>

            <!-- Form -->
            <form id="forgotPasswordForm">
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            placeholder="Enter your email"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                    <div id="emailError" class="text-red-500 text-sm mt-1 hidden">Please enter a valid email address.</div>
                </div>

                <button 
                    type="submit" 
                    id="sendCodeBtn"
                    class="btn-primary w-full py-3 px-4 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mb-6 flex items-center justify-center"
                >
                    <span id="btnText">Send Code</span>
                    <i id="btnSpinner" class="fas fa-spinner fa-spin ml-2 hidden"></i>
                </button>
            </form>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-gray-600">
                    Remember your password? 
                    <a href="#" class="text-blue-600 font-medium hover:text-blue-800 transition back-link inline-flex items-center">
                        <i class="fas fa-arrow-left mr-1 text-sm"></i>
                        Back to Sign in
                    </a>
                </p>
            </div>
        </div>
        
        <!-- Success Message (Hidden by default) -->
        <div id="successMessage" class="hidden mt-6 p-4 bg-green-50 border border-green-200 rounded-lg text-center">
            <i class="fas fa-check-circle text-green-500 text-xl mb-2"></i>
            <p class="text-green-700 font-medium">OTP sent successfully!</p>
            <p class="text-green-600 text-sm mt-1">Please check your email for the verification code.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('forgotPasswordForm');
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const sendCodeBtn = document.getElementById('sendCodeBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const successMessage = document.getElementById('successMessage');
            
            // Email validation
            function validateEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
            
            // Form submission handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = emailInput.value.trim();
                
                // Reset error states
                emailError.classList.add('hidden');
                emailInput.classList.remove('border-red-500');
                successMessage.classList.add('hidden');
                
                // Validate email
                if (!email) {
                    emailError.textContent = 'Email address is required.';
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('border-red-500');
                    emailInput.focus();
                    return;
                }
                
                if (!validateEmail(email)) {
                    emailError.textContent = 'Please enter a valid email address.';
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('border-red-500');
                    emailInput.focus();
                    return;
                }
                
                // Simulate sending the code
                sendCodeBtn.disabled = true;
                btnText.textContent = 'Sending...';
                btnSpinner.classList.remove('hidden');
                
                // Simulate API call
                setTimeout(function() {
                    // Show success message
                    successMessage.classList.remove('hidden');
                    
                    // Reset button
                    sendCodeBtn.disabled = false;
                    btnText.textContent = 'Send Code';
                    btnSpinner.classList.add('hidden');
                    
                    // Clear form
                    form.reset();
                    
                    // Scroll to success message
                    successMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 2000);
            });
            
            // Real-time validation as user types
            emailInput.addEventListener('input', function() {
                if (emailInput.value.trim()) {
                    emailError.classList.add('hidden');
                    emailInput.classList.remove('border-red-500');
                }
            });
        });
    </script>
</body>
</html>