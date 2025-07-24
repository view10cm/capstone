<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Add this line
use App\Http\Controllers\InventoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/system-description', function () {
    return view('systemDescription');
})->name('systemDescription');

Route::get('/login', function () {
    return view('login'); // Make sure you have a resources/views/login.blade.php file
})->name('login');

Route::get('forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/login', [AuthController::class, 'login'])->name('login');

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('admin.adminDashboard');
})->name('admin.adminDashboard');

// To this:
Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.adminInventory');
// Admin Menu
Route::get('/admin/menu', function () {
    return view('admin.adminMenu');
})->name('admin.adminMenu');

// Admin Users
Route::get('/admin/users', function () {
    return view('admin.adminUsers');
})->name('admin.adminUsers');

// Admin Order History
Route::get('/admin/orders', function () {
    return view('admin.adminOrderHistory');
})->name('admin.adminOrderHistory');

Route::get('/logout', function () {
    // Optionally, you can add Auth::logout(); if using authentication
    return redirect('/');
})->name('logout');

Route::get('/inventory', [InventoryController::class, 'index']);

// Add this route for creating ingredient categories
Route::post('/admin/ingredient-categories', [InventoryController::class, 'storeCategory'])->name('admin.ingredient-categories.store');