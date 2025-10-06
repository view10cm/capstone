<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'Admin') {
                return redirect()->route('admin.adminDashboard');
            }
            // You can add more role checks here if needed
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }
}
