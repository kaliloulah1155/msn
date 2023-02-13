<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Song\StoreSongRequest;

class SongController extends Controller
{
     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSongRequest $request)
    {
        try{
            $file=$request->file;

            if(empty($file)){
                return response()->json('No song uploaded',400);
            }
            $user=User::findOrFail($request->get('user_id'));
            
            $song=$file->getClientOriginalName();
            $file->move('songs/'.$user->id,$song);

            Song::create([
                'user_id'=>$request->get('user_id'),
                'title'=>$request->get('title'),
                'song'=>$song,
            ]);

            return response()->json('Song Saved !',200);

        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in SongController.store ',
                'error'=>$e->getMessage()
            ],400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id,int $user_id)
    {
        try{
            $song=Song::findOrfail($id);
            $currentSong=public_path()."/songs/".$user_id."/".$song->song;
            if(file_exists($currentSong)){unlink($currentSong);}
            $song->delete();
            return response()->json('Song deleted',200);

        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in SongController.store ',
                'error'=>$e->getMessage()
            ],400);
        }
    }
}
