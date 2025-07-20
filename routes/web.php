<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Add this line

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

Route::get('/dashboard', function () {
    return view('adminDashboard');
})->name('dashboard')->middleware('auth');

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('adminDashboard');
})->name('admin.dashboard');

// Admin Inventory
Route::get('/admin/inventory', function () {
    return view('admin.inventory');
})->name('admin.inventory');

// Admin Menu
Route::get('/admin/menu', function () {
    return view('admin.menu');
})->name('admin.menu');

// Admin Users
Route::get('/admin/users', function () {
    return view('admin.users');
})->name('admin.users');

// Admin Order History
Route::get('/admin/orders', function () {
    return view('admin.orders');
})->name('admin.orders');

// Logout (if using Laravel Breeze/Fortify/Jetstream, this is usually already defined)
Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
// Password Reset Routes