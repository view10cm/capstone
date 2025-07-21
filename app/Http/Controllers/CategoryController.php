<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'category_name' => 'required|string|max:100|unique:ingredients_category_table,ingredient_category_name'
            ]);

            // Insert the new category into the database
            $categoryId = DB::table('ingredients_category_table')->insertGetId([
                'ingredient_category_name' => $request->ingredient_category_name,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Get the created category
            $category = DB::table('ingredients_category_table')
                ->where('ingredient_category_ID', $categoryId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Category added successfully',
                'category' => $category
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', $e->validator->errors()->all())
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $categories = DB::table('ingredients_category_table')
                ->select('ingredient_category_ID', 'ingredient_category_name')
                ->orderBy('ingredient_category_name')
                ->get();

            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching categories: ' . $e->getMessage()
            ], 500);
        }
    }
}
