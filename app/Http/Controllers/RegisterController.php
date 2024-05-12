<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function create()
    {
        return view('pages.static-sign-up');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'min:5',
                // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'role' => 'required|in:user,admin',
            'phone' => 'required|max:12'
        ], [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'agreement.accepted' => 'You must agree to the Terms and Conditions.',
        ]);

        $hashedpassword = Hash::make($attributes['password']);
        // Log::info('hashedpass', (array)$hashedpassword);
        // dd($hashedpassword);
        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => $attributes['password'],
            // 'role' => $attributes['role'],
            'phone' => $attributes['phone'],
        ]);

        
        // return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
        return response()->json(['status_code' => 0]);
    }
}
