<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

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
                "message"=>"Registration Successfull!"
    
            ]);
            
        }catch(Exception $e){

            return response()->json([
    
                "status"=>"failed",
                "message"=>"Registration failed!"
    
            ]);


        }

        

    }

}
