<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SongController;
use App\Http\Controllers\API\SongsByUserController;
use App\Http\Controllers\API\YoutubeController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\PostByUserController;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::get('users/{id}',[UserController::class,'show']);
Route::middleware('auth:sanctum')->group(function(){
    
     Route::post('logout',[AuthController::class,'logout']);
    
     Route::put('users/{id}',[UserController::class,'update']);

     Route::post('songs',[SongController::class,'store']);
     Route::delete('songs/{id}/{user_id}',[SongController::class,'destroy']);

     Route::get('youtube/{user_id}',[YoutubeController::class,'show']);
     Route::post('youtube',[YoutubeController::class,'store']);
     Route::delete('youtube/{id}',[YoutubeController::class,'destroy']);

     Route::post('user/{user_id}/songs',[SongsByUserController::class,'index']);

     Route::get('posts',[PostController::class,'index']);
     Route::get('posts/{id}',[PostController::class,'show']);
     Route::post('posts',[PostController::class,'store']);
     Route::put('posts/{id}',[PostController::class,'update']);
     Route::delete('posts/{id}',[PostController::class,'destroy']);

     Route::get('user/{user_id}/posts',[PostByUserController::class,'index']);

     


});
