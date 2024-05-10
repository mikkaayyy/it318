<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'min:5',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'role' => 'required|in:user,admin',
            'agreement' => 'accepted',
        ], [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'agreement.accepted' => 'You must agree to the Terms and Conditions.',
        ]);

       
        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
            // 'role' => $attributes['role'],
        ]);

        
        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }
}
