<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderTransaction;
use App\Models\MenuOrderTransaction;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        try {
            $data = $request->all();
            
            // Create the main order transaction
            $order = OrderTransaction::create([
                'order_type' => $data['order_type'],
                'order_date' => now(),
                'special_request' => $data['special_request'],
                'total_items' => $data['total_items'],
                'subtotal' => $data['subtotal'],
                'tax' => $data['tax'],
                'totalAmount' => $data['totalAmount'],
                'status' => 'New Order'
            ]);
            
            // Create menu order items
            foreach ($data['order_items'] as $item) {
                MenuOrderTransaction::create([
                    'OrderID' => $order->OrderID,
                    'ProductName' => $item['product_name'],
                    'Quantity' => $item['quantity'],
                    'unitPrice' => $item['unit_price']
                ]);
            }
            
            return response()->json([
                'success' => true,
                'order_id' => $order->OrderID,
                'message' => 'Order placed successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing order: ' . $e->getMessage()
            ], 500);
        }
    }
}