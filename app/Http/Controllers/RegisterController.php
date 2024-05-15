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
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'role' => 'required|in:user,admin',
            'phone' => 'required|max:12',
            'otp' => 'required'
        ], [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
        ]);

        $inputOTP = $attributes['otp'];
        $sessionOTP = session('otp');

        if ($inputOTP != $sessionOTP) {
            return response()->json(['error' => 'Invalid OTP']);
        }

        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
            'role' => $attributes['role'],
            'phone' => $attributes['phone'],
        ]);

        session()->forget('otp');

        return response()->json(['status_code' => 0]);
    }
}
