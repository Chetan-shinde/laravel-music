<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

class SongController extends Controller
{
    public function getSongs(){
    	$songs = Song::getSongs();
    	return response()->json(["success"=>true, "songs"=>$songs);
    }
}
