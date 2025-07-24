<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    public function index()
    {
        // Fetch all categories from the database
        $categories = DB::table('ingredient_categories')
            ->select('categoryID', 'categoryName')
            ->orderBy('categoryName', 'asc')
            ->get();

        return view('admin.adminInventory', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        try {
            // Validate the input
            $request->validate([
                'categoryName' => 'required|string|max:255|unique:ingredient_categories,categoryName'
            ]);

            // Create the category - using categoryID as primary key
            $categoryId = DB::table('ingredient_categories')->insertGetId([
                'categoryName' => $request->categoryName,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Get the created category data
            $categoryData = DB::table('ingredient_categories')
                ->where('categoryID', $categoryId) // Use categoryID instead of id
                ->first();

            // If categoryData is null, try with 'id' column
            if (!$categoryData) {
                $categoryData = DB::table('ingredient_categories')
                    ->where('id', $categoryId)
                    ->first();
            }

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'category' => [
                    'categoryID' => $categoryData->categoryID ?? $categoryData->id ?? $categoryId,
                    'categoryName' => $categoryData->categoryName
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category name already exists or is invalid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Category creation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating category: ' . $e->getMessage()
            ], 500);
        }
    }
}