<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Show the customer landing page
     */
    public function landing()
    {
        return view('customerLandingPage');
    }
}