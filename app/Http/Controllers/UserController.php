<?php



namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('pages.laravel-examples.clients', ['users' => $users]);
    }

    public function getUser($id)
    {
        $id = Crypt::decryptString($id);
        $users = User::find($id);
        
        return $users;
    }

    public function updateUser(Request $request)
    {
        $id = Crypt::decryptString($request->encryptedUserId);

        $customAttributes = [
            'editname' => 'name',
            'editemail' => 'email',
            'editType' => 'type',
        ];

        $data = $request->validate([
                'editname' => 'required|max:255',
                'editemail' => 'required|email|max:255|unique:users,email,'.$id,
                'editType' => 'required|in:user,admin',
        ],[],$customAttributes);
            
        $users = User::find($id);

        $users->name = $data['editname'];
        $users->email = $data['editemail'];
        $users->role = $data['editType'];
        if(!empty($request->editpass)){
            $pass = ['editpass' => 'password'];
            $password = $request->validate([
                'editpass' => [
                    'required',
                    'min:5',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
                ],
            ],[
                'editpass.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
                ], $pass);
            $users->password = $password['editpass'];
        }
        $users->save();
        return response()->json(['status_code' => 0]);
    }
    public function deleteUser($userId)
    {
        $id = Crypt::decryptString($userId);

        $users = User::find($id);

        $users->delete();

        return response()->json(['status_code' => 0]);
    }
}