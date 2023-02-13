<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


Route::middleware('auth:sanctum')->group(function(){
    
     Route::post('logout',[AuthController::class,'logout']);
     Route::get('users/{id}',[UserController::class,'show']);
     Route::put('users/{id}',[UserController::class,'update']);
     Route::get('inside-mware',function(){
        return response()->json('success',200);
     });

});
