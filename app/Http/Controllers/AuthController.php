<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

use function Illuminate\Support\now;

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

        //Logika za slanje verifikacionog mejla

        $url=URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id'=>$user->id]
        );
        Mail::to($user->email)->send(new VerifyEmail($user,$url));
        //

        // $token=$user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message'=>'Registracija uspesna',
            'user'=>$user
        ],201);
    }


    public function login(Request $request){

        $validator=Validator::make($request->all(),[
            'email'=>'required|string|email',
            'password'=>'required|string'
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

        if($user->email_verified_at==null){
            return response()->json([
                "message"=>"Niste verifikovali mejl, ne mozete se prijaviti."
            ],401);
        }

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


    public function verifyEmail(Request $request, $id){
        //Da li je link vazeci (nije istekao)
        if(!$request->hasValidSignature()){
            return response()->json([
                "message"=>"Link za verifikaciju je istekao."
            ],401);
        }

        $user=User::findOrFail($id);

        if($user->email_verified_at){
            return response()->json([
                "message"=>"Email je vec verifikovan."
            ],200);
        }

        $user->email_verified_at=now();
        $user->save();

        return response()->json([
                "message"=>"Email je uspesno verifikovan."
            ],200);

    }

}
