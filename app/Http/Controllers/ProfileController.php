<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function create()
    {
        return view('pages.profile');
    }

    public function update()
    {
            
        $user = request()->user();
        $attributes = request()->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required',
            'phone' => 'required|max:10',
            'about_me' => 'required:max:150',
            'location' => 'required'
        ]);

        
        auth()->user()->update($attributes);
        return back()->withStatus('Profile successfully updated.');
    
}
}
