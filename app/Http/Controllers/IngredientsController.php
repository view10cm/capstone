<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf; // Correct import

class IngredientsController extends Controller
{
    /**
     * Display the admin inventory page
     */
    public function index()
    {
        // Get all ingredient categories for the dropdown
        $categories = DB::table('ingredient_categories')->get();
        
        // Get all ingredients with pagination
        $ingredients = DB::table('ingredients')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.adminInventory', compact('categories', 'ingredients'));
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

    /**
     * Delete an ingredient
     */
    public function destroy($id)
    {
        try {
            $deleted = DB::table('ingredients')
                ->where('ingredient_id', $id)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ingredient deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingredient not found!'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting ingredient: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export ingredients as PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            // Get all ingredients for export
            $ingredients = DB::table('ingredients')
                ->orderBy('created_at', 'desc')
                ->get();

            // Format the data for PDF
            $formattedIngredients = $ingredients->map(function ($ingredient) {
                return [
                    'item_id' => 'CA' . str_pad($ingredient->ingredient_id, 5, '0', STR_PAD_LEFT),
                    'name' => $ingredient->ingredient_name,
                    'category' => $ingredient->ingredient_category,
                    'quantity' => $ingredient->ingredient_quantity,
                    'availability' => $ingredient->ingredient_availability,
                    'unit' => $this->getUnit($ingredient->ingredient_name)
                ];
            });

            $data = [
                'ingredients' => $formattedIngredients,
                'exportDate' => now()->format('F j, Y'),
                'totalItems' => $ingredients->count()
            ];

            // Generate PDF
            $pdf = Pdf::loadView('admin.exports.ingredients-pdf', $data);

            // Download PDF
            return $pdf->download('ingredients-list-' . now()->format('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to determine unit based on ingredient name
     */
    private function getUnit($ingredientName)
    {
        $name = strtolower($ingredientName);
        if (str_contains($name, 'beef') || str_contains($name, 'oxtail')) {
            return 'kg';
        } elseif (str_contains($name, 'shot')) {
            return 'shots';
        } elseif (str_contains($name, 'syrup') || str_contains($name, 'pump')) {
            return 'pumps';
        } else {
            return 'pcs';
        }
    }
}