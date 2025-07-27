<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductsData;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'subcategory' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'availability' => 'required|in:Available,Unavailable', // Add this
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = ProductsData::create([
            'productName' => $validated['name'],
            'productDescription' => $validated['description'],
            'productCategory' => $validated['category'],
            'productSubcategory' => $validated['subcategory'],
            'productPrice' => $validated['price'],
            'productImage' => $imagePath,
            'productAvailability' => $validated['availability'], // Add this
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product
        ]);
    }

    public function updateAvailability(Request $request, ProductsData $product)
    {
        $validated = $request->validate([
            'availability' => 'required|in:Available,Unavailable'
        ]);

        $product->update([
            'productAvailability' => $validated['availability']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Availability updated successfully'
        ]);
    }

}