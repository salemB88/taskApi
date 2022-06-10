<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $validation = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users',
                'phone' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]
        );
        $validation['password'] = bcrypt($validation['password']);

        $user = User::create($validation);
        $accessToken1 = $user->createToken('authToken')->accessToken;
        return ['user' => $user, 'access_token' => $accessToken1];
    }

    public function login(Request $request)
    {
        $validation = $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ]
        );

        if (!auth()->attempt($validation)) {
            return response()->json(['message' => 'invalid login'], 401);
        }

        $accessToken1 = auth()->user()->createToken('authToken')->accessToken;

        return ['user' => auth()->user(), 'access_token' => $accessToken1];
    }



    public function updatePassword(Request $request){
        $user=auth()->user();
   if(Hash::check($request->password,$user->password)){
       return "S";
   }
        if(!Hash::check($request->password,$user->password)){
            return response()->json(['message'=>'invalid password'],401);
        }

        $validation= $request->validate
        ([
                'password' => 'required',
                'new_password' => 'required|confirmed',
                'new_password_confirmation' => 'required'
            ]
        );
        $user->password=bcrypt($request->new_password);
        if($user->save()){
            return response()->json(['message'=>'update successful']);


        }



    }


    public function updateProfile(Request $request){
        $user=auth()->user();



        $validation= $request->validate
        ([
                'name' => 'required',
                'email' => 'required|unique:users'.$user->id,
            ]
        );

        if($user->update($validation)){
            return response()->json(['message'=>'update successful']);


        }

    }
    public function delete(Request $request){
        $user=   auth()->user();
        if($user->delete()){
            return response()->json(['message'=>'Delete successful']);

        }

    }
}

