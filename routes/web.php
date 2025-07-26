<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/system-description', function () {
    return view('systemDescription');
})->name('systemDescription');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', function () {
    return redirect('/');
})->name('logout');

// Admin Dashboard Pages
Route::get('/admin/dashboard', function () {
    return view('admin.adminDashboard');
})->name('admin.adminDashboard');

Route::get('/admin/menu', function () {
    return view('admin.adminMenu');
})->name('admin.adminMenu');

Route::get('/admin/users', function () {
    return view('admin.adminUsers');
})->name('admin.adminUsers');

Route::get('/admin/orders', function () {
    return view('admin.adminOrderHistory');
})->name('admin.adminOrderHistory');

// Temporary Inventory Route (might conflict with middleware one)
Route::get('/inventory', [InventoryController::class, 'index']);

// Ingredient Category Route (outside middleware)
Route::post('/admin/ingredient-categories', [InventoryController::class, 'storeCategory'])->name('admin.ingredient-categories.store');

// Protected Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Display inventory page
    Route::get('/inventory', [IngredientsController::class, 'index'])->name('admin.adminInventory');

    // Store new ingredient
    Route::post('/ingredients', [IngredientsController::class, 'store'])->name('admin.ingredients.store');

    // Delete ingredient
    Route::delete('/ingredients/{id}', [IngredientsController::class, 'destroy'])->name('admin.ingredients.destroy');

    // Store new ingredient category
    Route::post('/ingredients/categories', [IngredientsController::class, 'storeCategory'])->name('admin.ingredients.categories.store');
});

Route::prefix('admin/categories')->group(function () {
    Route::get('/', [MenuCategoryController::class, 'index'])->name('categories.index');
    Route::post('/', [MenuCategoryController::class, 'store'])->name('categories.store');
});

Route::prefix('admin')->group(function () {
    // ... other admin routes
    
    // Product routes
    Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])
        ->name('admin.products.store');
});

Route::get('/admin/menu', function () {
    $products = \App\Models\ProductsData::all();
    return view('admin.adminMenu', ['products' => $products]);
})->name('admin.adminMenu');

Route::get('/admin/menu', function () {
    $products = \App\Models\ProductsData::paginate(10);
    return view('admin.adminMenu', ['products' => $products]);
})->name('admin.adminMenu');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Customer routes
Route::middleware(['auth'])->group(function () {
    Route::get('/customer/landing', [CustomerController::class, 'landing'])->name('customer.landing');
});

Route::get('/customer/system-description', function () {
    return view('customer.systemDescription');
})->name('customer.systemDescription');

Route::get('/customer/order-area', function () {
    return view('customer.customerOrderArea');
})->name('customer.orderArea');