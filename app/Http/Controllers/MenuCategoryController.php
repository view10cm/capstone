<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MenuCategoryController extends Controller
{
    /**
     * Store a new category
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'menuCategoryName' => 'required|string|max:100|unique:menuCategory,menuCategoryName'
            ]);

            $category = DB::table('menuCategory')->insertGetId([
                'menuCategoryName' => $request->menuCategoryName,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $newCategory = DB::table('menuCategory')->where('menuCategoryID', $category)->first();

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'category' => [
                    'id' => $newCategory->menuCategoryID,
                    'name' => $newCategory->menuCategoryName
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the category'
            ], 500);
        }
    }

    /**
     * Get all categories
     */
    public function index()
    {
        try {
            $categories = DB::table('menuCategory')
                ->select('menuCategoryID as id', 'menuCategoryName as name')
                ->orderBy('menuCategoryName')
                ->get();

            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching categories'
            ], 500);
        }
    }
}