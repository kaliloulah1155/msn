<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Youtube;
use Illuminate\Http\Request;
use App\Http\Requests\Youtube\StoreYoutubeRequest;

class YoutubeController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show(int $user_id)
    {
       
        try{
            $videosByUser=Youtube::where('user_id',$user_id)->get();
            return response()->json(['videos_by_user'=>$videosByUser],200);
        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in YoutubeController.show ',
                'error'=>$e->getMessage()
            ],400);
        }
    }

     
    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Youtube\StoreYoutubeRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StoreYoutubeRequest $request)
    {
        try{

            $yt=new Youtube;
            $yt->user_id=$request->user_id;
            $yt->title=$request->title;
            $yt->url=env("YT_EMBED_URL").$request->url."?autoplay=0";
            
            $yt->save();

            return response()->json('New Youtube link saved!',200);

        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in YoutubeController.store',
                'error'=>$e->getMessage()
            ],400);
        }
    }
  

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try{
            $yt=Youtube::findOrfail($id);
            $yt->delete();
            return response()->json('Video deleted',200);

        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in YoutubeController.destroy',
                'error'=>$e->getMessage()
            ],400);
        }
    }
}
