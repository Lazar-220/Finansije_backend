<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'ime'=>'required|string|max:50',
            'prezime'=>'required|string|max:50',
            'email'=>'required|string|email|max:255|unique:users,email',
            'password'=>'required|string|min:6|confirmed'//password_confirmation
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }
        $data=$validator->validated();
        $user=User::create($data);

        $token=$user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message'=>'Uspesna registracija',
            'user'=>$user,
            'token'=>$token
        ],201);
    }


    public function login(Request $request){

        $validator=Validator::make($request->all(),[
            'email'=>'required|string|email',
            'password'=>'required|string'//password_confirmation
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }
        $data=$validator->validated();

        if(!Auth::attempt($data)){
            return response()->json([
                'message'=>'Pogresan email ili lozinka.'
            ],401);
        }

        $user=Auth::user();

        $token=$user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message'=>'Uspesno ste prijavljeni',
            'user'=>$user,
            'token'=>$token
        ],200);
    }

    public function logout(Request $request){

        $user=$request->user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'message'=>'Uspesno ste odjavljeni'
        ],200);
    }

    public function me(Request $request){
        return response()->json($request->user(),200);
    }

}
