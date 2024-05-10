<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class login extends Controller
{
    public function viewlogin(){
        return view('pages.static-sign-in');
    }
    public function loginprocess(Request $request){
        
        $pass = bcrypt($request->password);
        
        $user = User::where('email', $request->email)->where('password', $pass);

        if($user){
            Auth::login($user);
            return response()->json(['status_code' => 0 ]);
        }
        else{
            return response()->json(['status_code' => 1, 'msg' => 'Invalid credentials']);
        }

    }

    
}
