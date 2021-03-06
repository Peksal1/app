<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query();
    if (!empty($request->searchKeyword)) {
        $query->where('name', 'LIKE', "%{$request->searchKeyword}%");
    }
    return $query->paginate(8);
}
   
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
        'message' => 'Wrong e-mail or password.'
                   ], 401);
               }
        
        $user = User::where('email', $request['email'])->firstOrFail();
        
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
                   'access_token' => $token,
                   'token_type' => 'Bearer',
        ]);
        }
    

    public function createAccount(Request $request)
    {
        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
                           'email' => 'required|string|email|max:255|unique:users',
                           'password' => 'required|string|min:8|confirmed',
                           'surname' => 'required|string|max:50',
                           'display_name' => 'required|string|min:3|max:12|unique:users',
                           'phone_number' => 'required|string|min:6|max:15|unique:users',
                           
        ]);
              $user = User::create([
                        'name' => $validatedData['name'],
                        'display_name' => $validatedData['display_name'],
                        'surname' => $validatedData['surname'],
                        'phone_number' => $validatedData['phone_number'],
                        'email' => $validatedData['email'],
                        'password' => Hash::make($validatedData['password']),
               ]);
        
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
                      'access_token' => $token,
                           'token_type' => 'Bearer',
        ]);
        }


    // this method signs out users by removing tokens
    public function signout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
    public function show($user)
    {
         $users=User::findOrFail($user);
        return $users;
    }

    public function store(Request $request)

{
    $request->validate([

        'name'=>'required',

        'email'=>'required',

        'password'=>'required',

        'surname' =>'required',
        'display_name' =>'required',
        'phone_number' =>'required',

        

          ]);

    

          return  User::create($request->all());
}


public function userfeedback($id){
    $user = User::where('id', $id)->firstOrFail();



        $user_feedback = $user->feedbacks;

     

        return response()->json($user_feedback, 200, [], JSON_PRETTY_PRINT);
}

public function userposts($id){
    $user = User::where('id', $id)->firstOrFail();



        $user_post = $user->posts;

     

        return response()->json($user_post, 200, [], JSON_PRETTY_PRINT);
}

public function destroy($user)
{
    $users=User::destroy($user);

    return response()->json($users,204);

}
public function update(Request $request, $user)
{
      
    $users= User::find($user);
        $users->update($request->all());
        return  $users;
}

public function updateuser(Request $request, $user)
{
      
    $users= User::find($user);
    if(auth()->user()==$users->user){
        $users->update($request->all());
        return  $users;
        }
        else
        {
            return "no rights";
        }
}

public function user_search(Request $request, $name)
{
    $result = User::where('name', 'LIKE', '%'. $name. '%')->get();
    if(count($result)){
     return Response()->json($result);
    }
    else
    {
    return response()->json(['Result' => 'No users found'], 404);
  }
}

}
