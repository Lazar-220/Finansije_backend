<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(Request $request){

        $validator=Validator::make($request->all(),[
            'email'=>'required|string|email'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }

        $email=$validator->validated()['email'];

        $user=User::where('email',$email)->first();

        if(!$user){
            return response()->json([
                'message'=>'Ako nalog postoji poslali smo instrukcije za reset lozinke na mejl.'
            ],200);
        }

        $token=Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email'=>$user->email],
            [
                'token'=>Hash::make($token),
                'created_at'=>Carbon::now()
            ]
        );

        $resetUrl=config('app.frontend_url',config('app.url')) .
        '/reset-password?token=' . urlencode($token) . 
        '&email=' . urlencode($user->email);

        Mail::to($user->email)->send(new ResetPasswordMail($user,$token,$resetUrl));

        return response()->json([
                'message'=>'Ako nalog postoji poslali smo za reset lozinke na emejl.'
            ],200);
    }


    public function resetPassword(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required|string|email',
            'token'=>'required|string',
            'password'=>'required|string|min:6|confirmed'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }

        $data=$validator->validated();

        $record=DB::table('password_reset_tokens')
        ->where('email',$data['email'])
        ->first();

        if(!$record){
            return response()->json([
                'message'=>'Neispravan token ili email.'
            ],400);
        }

        $created_at=Carbon::parse($record->created_at);
        if($created_at->addMinutes(60)->isPast()){
            return response()->json([
                'message'=>'Token je istekao. Posaljite novi zahtev za reset lozinke.'
            ],400);
        }

        if(!Hash::check($data['token'],$record->token)){
            return response()->json([
                'message'=>'Neispravan token.'
            ],400);
        }

        $user=User::where('email',$data['email'])->firstOrFail();

        $user->password=$data['password'];

        $user->save();

        DB::table('password_reset_tokens')
        ->where('email',$data['email'])
        ->delete();

        return response()->json([
                'message'=>'Lozinka je uspesno resetovana. Mozete se prijaviti sa novom lozinkom.'
            ],200);


    }




}
