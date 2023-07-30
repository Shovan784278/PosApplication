<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends Controller
{
    //For page view

    function LoginPage():View{

        return view('pages.auth.login');
    }

    function RegistrationPage():View{

        return view('pages.auth.registration');
    }

    function SendOTP():View{

        return view('pages.auth.send-otp-page');
    }

    function ResetPass():View{

        return view('pages.auth.reset-password-page');
    }

    function VerifyOTPPage():View{

        return view('pages.auth.verify-otp-page');
    }


    //For Axios 
    
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
                
            ],status:200)->cookie('token', $token, 60*24*30);


        }else{

            return response()->json([
    
                "status"=>"failed",
                "message"=>"Unothorized"
                
            ],status:201);

        }
    }


    public function SendOTPCode(Request $request){

        $email = $request->input('email');
        $otp = rand(1000,9999);

       $count =  User::where('email','=', $email)->count();

       if($count == 1){

            //OTP email ADDRESS
            Mail::to($email)->send(new OTPMail($otp));
            
            //OTP database table update
            User::where('email','=',$email)->update(['otp'=>$otp]);

            return response()->json([
    
                "status"=>"success",
                "message"=>"4-Digit OTP has been sent to your Email"
    
            ],status:200);

       }else{

        return response()->json([
    
            "status"=>"failed",
            "message"=>"OTP not sent"

        ],status:401);

       }

    }


    public function VerifyOTP(Request $request){

        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email','=',$email)->where('otp','=',$otp)->count();

        if($count==1){

            //Database OTP Update for reset
            User::where('email','=',$email)->update(['otp'=>'0']);

            //Token issue for reset password
            $token = JWTToken::CreateTokenForResetPassword($request->input('email'));

            return response()->json([
    
                "status"=>"success",
                "message"=>"OTP Verification has successful",
                
            ],200)->cookie('token',$token,60*24*30);

        }else{

            return response()->json([
    
            "status"=>"failed",
            "message"=>"OTP not sent"

        ],status:401);
            
        }


    }

    public function ResetPassword(Request $request){

        try{

        $email = $request->header('email');
        $password = $request->input('password');

        //Reset Password Update In database
        User::where('email','=',$email)->update(['password'=>$password]);

        return response()->json([
    
            "status"=>"success",
            "message"=>"Password reset Successfully!"
            
        ],status:200);


        }catch(Exception $exeption){
            
            return response()->json([
    
                "status"=>"Failed!",
                "message"=>"Something Went Wrong",
                
            ],status:401);

        }

        


    }

    public function userLogout(){

        return redirect("/login")->cookie('token','',-1);
    }

}
