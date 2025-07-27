@extends('customerBase')

@section('title', 'Caffe Arabica - Order Area')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col relative">
        <!-- Brand Header -->
        <div class="mb-6">
            <img src="{{ asset('images/Brand Header.svg') }}" alt="Caffe Arabica" class="w-full object-cover" style="height: 120px; max-height: 120px;">
        </div>

        <!-- Spacer to push the conversation panel and bottom image down -->
        <div class="flex-1"></div>

        <!-- Bottom Customer Order Area Image with Microphone Button -->
        <div class="mt-auto relative">
            <!-- Conversation Panel - Positioned behind the microphone, full width of main content area -->
            <div class="absolute bottom-0 left-0 right-0 z-10 mb-6">
                <div class="bg-white shadow-lg border border-gray-200 max-h-48 overflow-hidden" style="font-family: 'Manrope', 'Arial', sans-serif;">
                    <!-- Conversation Messages Area -->
                    <div class="p-6 max-h-40 overflow-y-auto scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none;">
                        <style>
                            .scrollbar-hide::-webkit-scrollbar {
                                display: none;
                            }
                        </style>
                        <!-- Welcome Message -->
                        <div class="mb-4">
                            <div class="flex items-start space-x-3">
                                <div class="bg-orange-100 rounded-full p-2 flex-shrink-0">
                                    <img src="{{ asset('images/voiceFill.svg') }}" alt="Voice Assistant" class="w-4 h-4">
                                </div>
                                <div class="flex-1">
                                    <div class="bg-gray-100 rounded-lg px-4 py-3 max-w-md">
                                        <p class="text-gray-800" style="font-size: 16px;">Hello! Welcome to Caffe Arabica. What would you like to order today?</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Assistant</p>
                                </div>
                            </div>
                        </div>

                        <!-- Placeholder for conversation messages -->
                        <div class="text-center text-gray-400 py-8">

                        </div>
                    </div>
                </div>
            </div>

            <img src="{{ asset('images/orderSpeakOrange.svg') }}" alt="Customer Order Area" class="w-full h-auto relative z-20">
            
            <!-- Microphone Button Overlay -->
            <div class="absolute inset-0 flex items-center justify-center z-30" style="transform: translateY(-25%)">
                <button class="bg-white rounded-full p-4 shadow-lg hover:shadow-xl transition-shadow duration-200 hover:bg-gray-50 active:scale-95 transform transition-transform border-2 border-gray-300">
                    <svg class="w-8 h-8 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/>
                        <path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Right Sidebar - Order Summary -->
    <div class="w-80 bg-white shadow-lg border-l border-gray-200 rounded-tl-xl rounded-tr-xl">
        <div class="p-6 h-full flex flex-col">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800">Order Summary</h2>
            </div>

            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center text-center">
                <!-- Shopping Cart Icon -->
                <div class="mb-4">
                    <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
                        <path d="M9 8V17H11V8H9ZM13 8V17H15V8H13Z"/>
                    </svg>
                </div>
                
                <!-- Empty Message -->
                <p class="text-gray-400 text-sm font-medium">Your order is still empty</p>
            </div>
        </div>
    </div>
</div>
@endsection