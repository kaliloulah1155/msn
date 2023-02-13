<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){

       try {
            $user=User::create([
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);
            $token=$user->createToken('user_token')->plainTextToken;
            
            return response()->json(['user'=>$user,'token'=>$token],200);

       } catch (\Exception $e) {
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Something went wrong in AuthController.register'
            ]);
       }
  
    }

    public function login(LoginRequest $request){

        try {
             $user=User::where('email','=',$request->email)->firstOrFail();
            
             if(!Hash::check($request->password,$user->password)){
                return response()->json([
                    'error'=>'Something went wrong in login'
                ]);
             }
             $token=$user->createToken('user_token')->plainTextToken;

             return response()->json(['user'=>$user,'token'=>$token],200);
        }catch(\Exception $e) {
             return response()->json([
                 'error'=>$e->getMessage(),
                 'message'=>'Something went wrong in AuthController.login'
             ]);
        }
     }

     public function logout(LogoutRequest $request){

        try {
             $user=User::findOrFail($request->user_id);
             $user->tokens()->delete();
             return response()->json(['User logged out!'],200);

        } catch (\Exception $e) {
             return response()->json([
                 'error'=>$e->getMessage(),
                 'message'=>'Something went wrong in AuthController.logout'
             ]);
        }
 
         
     }
}
