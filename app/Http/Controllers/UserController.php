<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    
    public function UserRegistration(Request $request){

        try{

            User::create([

                'firstName' => $request-> input('firstName'),
                'lastName' => $request-> input('lastName'),
                'email' => $request-> input('email'),
                'mobile' => $request-> input('mobile'),
                'password' => $request-> input('password'),
                'otp' => $request-> input('otp')
                
            ]);
    
            return response()->json([
    
                "status"=>"success",
                "message"=>"Registration Successful!"
    
            ]);
            
        }catch(Exception $e){

            return response()->json([
    
                "status"=>"failed",
                "message"=>"Registration failed!"
    
            ]);


        }

        

    }


    public function UserLogin(Request $request){

        $count = User::where('email','=',$request->input('email'))
            ->where('password','=',$request->input('password'))
            ->count();


        if($count==1){

            $token = JWTToken::CreateToken($request->input('email'));

            return response()->json([
    
                "status"=>"success",
                "message"=>"User Login Successfully!",
                "token"=>"$token"
            ]);


        }else{

            return response()->json([
    
                "status"=>"failed",
                "message"=>"Unothorized"
                
            ]);

        }
    }


    public function SendOTPCode(Request $request){

        $email = $request->input('email');
        $otp = rand(1000,9000);

       $count =  User::where('email','=','$email')->count();

       if($count==1){

            //OTP email ADDRESS
            Mail::to($email)->send(new OTPMail($otp));

            User::where('email','=','$email')->update('otp');

       }else{

        return response()->json([
    
            "status"=>"failed",
            "message"=>"Registration failed!"

        ]);

       }

    }

}
