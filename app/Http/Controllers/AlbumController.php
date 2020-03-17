<?php

namespace App\Http\Controllers;

use App\Album;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {


        $user = Auth::user();

        if(empty($user)){

            $user2=User::find(1);
           // $albums = Album::where('user_id', $user2->id)->get();
            $albums = $id? Album::where([['user_id','=',1],['subalbum','=',1],['id_album_primario','=',$id]])->get() 
            : Album::where([['user_id','=',$user2->id],['subalbum','=',0]])->get();

        }else{
            $albums = Album::where('user_id', $user->id)->get();

        }

       //

        foreach ($albums as $album)
        {
           $album['latestPhoto'] = Photo::where('album_id', $album->id)->latest()->first();
         //$album['latestPhoto'] = Photo::where([['album_id','=',$album->id],['primario','=',1]] )->get();
        }
       //dd($albums);

        return response()->json($albums);
    }

    public function isSubAlbum($id){

        return   $albums =Album::where([['user_id','=',1],['subalbum','=',1],['id','=',$id]])->get();
       //$albums=Album::wheAlbum::where([['user_id','=',1],['subalbum','=',1],['id_album_primario','=',$id]])->get();re('user_id', 1)->get();
    
       // return response()->json($albums);
       
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $album = new Album();
        $album->user_id = Auth::id();
        $album->title = $request->title;
        $album->desc = $request->desc;
        $album->save();

        return response()->json($album, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = Album::with('photos')->where('id', $id)->first();

        return response()->json($album, 200);
       // echo $id;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $album = Album::find($request->album_id);

        $album->title = $request->title;
        $album->desc = $request->desc;
        $album->save();

        return response()->json(true, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = Album::find($id);
        $album->delete();

        return response()->json(true, 200);
    }
}
