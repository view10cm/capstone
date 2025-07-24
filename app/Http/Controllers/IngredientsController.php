<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IngredientsController extends Controller
{
    /**
     * Display the admin inventory page
     */
    public function index()
    {
        // Get all ingredient categories for the dropdown
        $categories = DB::table('ingredient_categories')->get();
        
        return view('admin.adminInventory', compact('categories'));
    }

    /**
     * Store a new ingredient
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'category' => 'required|exists:ingredient_categories,id',
            'quantity' => 'required|integer|min:0',
            'availability' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if ingredient already exists
            $existingIngredient = DB::table('ingredients')
                ->where('ingredient_name', $request->product_name)
                ->first();

            if ($existingIngredient) {
                return response()->json([
                    'success' => false,
                    'message' => 'An ingredient with this name already exists!'
                ], 409);
            }

            // Get category name from category ID
            $category = DB::table('ingredient_categories')
                ->where('id', $request->category)
                ->first();

            // Insert the ingredient
            DB::table('ingredients')->insert([
                'ingredient_name' => $request->product_name,
                'ingredient_category' => $category->categoryName,
                'ingredient_quantity' => $request->quantity,
                'ingredient_availability' => $request->availability,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ingredient added successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding ingredient: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new ingredient category
     */
    public function storeCategory(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:ingredient_categories,categoryName'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Insert the category
            $categoryId = DB::table('ingredient_categories')->insertGetId([
                'categoryName' => $request->category_name,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Get the newly created category
            $category = DB::table('ingredient_categories')
                ->where('id', $categoryId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'category' => $category
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating category: ' . $e->getMessage()
            ], 500);
        }
    }
}