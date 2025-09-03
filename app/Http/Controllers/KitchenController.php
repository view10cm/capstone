<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KitchenCooking;

class KitchenController extends Controller
{
    public function landingPage()
    {
        $orders = KitchenCooking::with('products')
            ->where('status', '!=', 'Completed')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kitchen.kitchenLandingPage', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = KitchenCooking::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('kitchen.landingPage')
            ->with('success', 'Order status updated successfully');
    }

    public function completedOrders()
    {
        $completedOrders = KitchenCooking::with('products')
            ->where('status', 'Completed')
            ->orderBy('updated_at', 'desc')
            ->paginate(10); // You can adjust the pagination number

        return view('kitchen.kitchenCompletedOrders', compact('completedOrders'));
    }

}