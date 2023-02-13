<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SongController;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


Route::middleware('auth:sanctum')->group(function(){
    
     Route::post('logout',[AuthController::class,'logout']);
     Route::get('users/{id}',[UserController::class,'show']);
     Route::put('users/{id}',[UserController::class,'update']);

     Route::post('songs',[SongController::class,'store']);
     Route::delete('songs/{id}/{user_id}',[SongController::class,'destroy']);
      

});
