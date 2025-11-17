<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderTransaction;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // In your OrderController or a new AdminOrderController
    public function orderHistory()
    {
        $orders = OrderTransaction::where('status', 'Done')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.adminOrderHistory', compact('orders'));
    }

    // In your controller
    public function getOrderDetails($orderId)
    {
        $order = OrderTransaction::with('menuOrderItems')
            ->where('OrderID', $orderId)
            ->firstOrFail();

        return response()->json($order);
    }

}
