<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

class MusicController extends Controller
{
    public function uploadMusic(Request $request){
    	
    	if ($request->hasFile('file')) {
		   $file = $request->file('file');
		  
		   $extension = $file->extension();
		   $fileName = $file->getClientOriginalName();
		   
		   if( !in_array($extension, ["mp3", ".mp3", "audio/mpeg"]) ){
		   		return response()->json(["success"=>false, 'error'=>'file must be valid music file']);
		   }

		   //store file
			$path = $file->storeAs('songs', $fileName);
			if(empty($path)){
				return response()->json(["success"=>false, 'error'=>'error occurred']);
			}

			//save songs inside db
			$song = new Song();
			$song->song_original_name = $fileName;
			$song->song_modified_name = $fileName;
			$song->song_genre = '';
			$song->song_comment_count = 0;
			$song->song_path = $path;
			

			$song->save();

			return response()->json(["success"=>true]);
		}
		
    }
}
