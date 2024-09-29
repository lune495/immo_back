<?php

namespace App\Http\Controllers;

use App\Models\{User,Outil};
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $queryName = "users";
    // Register
    public function register(Request $request ) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|confirmed', 
            'role_id' => 'required|integer',
        ]);
        $user =  User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role_id' => $fields['role_id'],
             
        ]);
        $id = $user->id;
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        // return Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
        return $response;
    }

    public function login(Request $request ) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        // Check email
        $user = User::with('role')->where('email',$fields['email'])->first();
        //Check email
            if (!$user || !Hash::check($fields['password'],$user->password)) {
                return response([
                    'message' => 'Mot de passe Incorrect'
                ],401);
                # code...
            }
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Déconnecté !'
        ];
    }
}
