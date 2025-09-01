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
}
