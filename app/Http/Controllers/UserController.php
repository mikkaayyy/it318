<?php



namespace App\Http\Controllers;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
{
    // Fetch all users from the database
    $users = User::all();

    // Pass the users data to the view and return it
    return view('pages.laravel-examples.clients', ['users' => $users]);
}

}
