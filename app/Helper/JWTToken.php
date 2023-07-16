<?php 

namespace App\Helper;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{

    function CreateToken($userEmail){

        $key = env('JWT_TOKEN');
        $payload =[

            'iss'=>'Laravel Token',
            'iat'=> time(),
            'exp'=>time()+60*60,
            'userEmail'=>$userEmail

        ];

        JWT::encode($payload, $key, 'HS256');

    }

    function VerifyToken($token){
        
        try{

            $key = env('JWT_TOKEN');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode->userEmail;
    

        }catch(Exception $e){

            return 'Unothorized';

        }
        

       
    }

}