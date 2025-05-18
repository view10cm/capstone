<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/viewReminder', function () {
    return view('customer.viewReminder');
})->name('customer.viewReminder');
