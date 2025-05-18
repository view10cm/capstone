<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// START OF CUSTOMER ROUTES

Route::get('/viewReminder', function () {
    return view('customer.viewReminder');
})->name('customer.viewReminder');

Route::get('/customer/viewCustomerOrderProper', function () {
    return view('customer.viewCustomerOrderProper');
})->name('viewCustomerOrderProper');

// END OF CUSTOMER ROUTES
