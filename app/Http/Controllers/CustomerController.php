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

    /**
     * Show the products gallery page
     */
    public function productsGallery()
    {
        $products = \App\Models\ProductsData::all();
        return view('customer.productsGallery', ['products' => $products]);
    }
}