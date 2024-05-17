<?php

namespace App\Http\Controllers;

Use Str;
Use Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;

class SessionsController extends Controller
{
    public function create()
    {
        // return view('sessions.create');
        return view('pages.static-sign-in');
    }

    public function throttleKey(){
    return Str::lower(request('email')). '|' . request()->ip();
    }
    public function checkTooManyFailedAttempts(){
        if(! RateLimiter::tooManyAttempts($this->throttleKey(), 2)){
            return;
        }
        $seconds = RateLimiter::availableIn($this->throttleKey());
    
        throw new Exception('Too many failed login attempts. Try again in ' . gmdate("H:i:s", $seconds), 429);
        // return response()->json(['message' => 'Too many login attempts. Try again after 60 seconds.'], 429);
    }
    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // dd(hash::make($attributes['password']));
        $this -> checkTooManyFailedAttempts();

        if (!Auth::attempt($attributes)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }
        RateLimiter::clear($this->throttleKey());
        // session()->regenerate();

        // return redirect('/dashboard'); 
        return response()->json(['status_code' => 0, 'role' => auth()->user()->role]);
    }

    public function show(){
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
        
    }

    public function update(){
        
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]); 
          
        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => ($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
    public function verify_login_email(Request $request)
    {
        $user = User::where('email', $request->email)->first();
      
        try {
            if ($user) {
                Auth::login($user);
                return response()->json(['status' => 'success']);
            } else {
                // If user doesn't exist, you can return a response indicating such.
                return response()->json(['status' => 'error', 'message' => 'Unauthorized Access!'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 429);
        }
    }
    


    public function destroy()
    {
        auth()->logout();

        return redirect('/sign-in');
    }

}
