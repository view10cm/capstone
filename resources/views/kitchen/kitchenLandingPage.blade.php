@extends('kitchen.kitchenBase')

@section('title', 'Caffe Arabica - Kitchen')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Kitchen Orders Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($orders as $order)
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 
            @if($order->status == 'New Order') border-blue-500 
            @elseif($order->status == 'Preparing') border-yellow-500 
            @else border-green-500 @endif">
            <div class="p-4 bg-gray-50 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-700">{{ $order->order_name }}</h2>
                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                        @if($order->status == 'New Order') bg-blue-100 text-blue-800 
                        @elseif($order->status == 'Preparing') bg-yellow-100 text-yellow-800 
                        @else bg-green-100 text-green-800 @endif">
                        {{ $order->status }}
                    </span>
                </div>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $order->order_type }} • 
                    {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                </p>
            </div>
            
            <div class="p-4">
                <h3 class="font-medium text-gray-700 mb-2">Order Items:</h3>
                <ul class="space-y-2">
                    @foreach($order->products as $product)
                    <li class="flex justify-between text-sm">
                        <span>{{ $product->quantity }}x {{ $product->product_name }}</span>
                        <span class="text-gray-600">{{ $product->size }}</span>
                    </li>
                    @endforeach
                </ul>
                
                @if($order->special_request)
                <div class="mt-4 pt-2 border-t border-gray-100">
                    <h3 class="font-medium text-gray-700 mb-1">Special Request:</h3>
                    <p class="text-sm text-gray-600 italic">{{ $order->special_request }}</p>
                </div>
                @endif
                
                <div class="mt-4 flex space-x-2">
                    <form action="{{ route('kitchen.orders.update-status', $order->KitchenID) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Preparing">
                        <button type="submit" class="px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600 transition">
                            Start Preparing
                        </button>
                    </form>
                    
                    <form action="{{ route('kitchen.orders.update-status', $order->KitchenID) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Completed">
                        <button type="submit" class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition">
                            Mark as Done
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    @if(count($orders) === 0)
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No orders</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by accepting new orders from the staff.</p>
    </div>
    @endif
</div>
@endsection